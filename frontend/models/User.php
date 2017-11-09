<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $full_name
 * @property string $gender
 * @property string $dob
 * @property string $prof_image
 * @property string $work_time
 * @property string $team
 * @property string $start_working_at
 * @property string $position
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $def_image=Yii::$app->user->identity->prof_image;
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['start_working_at','dob'],'string'],

            [['username', 'password_hash', 'password_reset_token', 'email', 'gender', 'work_time', 'team', 'position'], 'string', 'max' => 255],

            [['full_name'],'string','min'=>2, 'max'=>25],
            [['full_name'],'required'],
            [['full_name'], 'match', 'pattern' => '/^[a-zA-Z\s]+$/i','message'=>'All characters must be a letters.'],


            [['prof_image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'on'=>'update'],
            [['prof_image'], 'default','value'=>$def_image],

            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'string'],
            [['username'], 'unique'],
            [['email'], 'string'],
            [['password_reset_token'], 'string'],
            ['dob', 'validateBirthday'],
            ['start_working_at', 'validateDates'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'full_name' => 'Full Name',
            'gender' => 'Gender',
            'dob' => 'Dob',
            'prof_image' => 'Prof Image',
            'work_time' => 'Work Time',
            'team' => 'Team',
            'start_working_at' => 'Start Working At',
            'position' => 'Position',
        ];
    }

    public function validateDates($attribute, $params, $validator)
    {
        $model = new User();
        if ($model->load(\Yii::$app->request->post())) {
            if (strtotime($model->start_working_at) > strtotime(date('Y-m-d'))) {
               return $this->addError($attribute, "Start working date cannot be future date.");
            }
        }
    }

    public function validateBirthday($attribute, $params, $validator)
    {
        $model = new User();
        if ($model->load(\Yii::$app->request->post())) {
            if (strtotime($model->dob) > (strtotime(date('Y-m-d'))-504921600)) {
                return $this->addError($attribute, "Your age cannot be small than 16.");
            }
        }
    }

}
