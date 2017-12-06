<?php

namespace backend\models;

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
 */
class User extends \yii\db\ActiveRecord
{
    public $password;
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
        return [
            [['username','full_name','password','position'],'required','on'=>'create'],
            [['username','full_name','position'],'required','on'=>'update'],
            ['username', 'trim'],
            ['username', 'string', 'min' => 6, 'max' => 255],
            [['username'], 'match', 'pattern' => '/^[a-zA-Z0-9\!\@\#\$\&\*\_\+\+\-\.]+$/i',
                'message'=>'Username must have letters, numbers or those symbols (! @ # $ & * _ + - .)'],

            ['password', 'string', 'min' => 6,'on'=>'create'],
            [['password'], 'match', 'pattern' => '/^[a-zA-Z0-9\!\@\#\$\&\*\_\+\+\-\.]+$/i',
                'message'=>'Password must have English letters, numbers or those symbols (! @ # $ & * _ + - .)'],
            [['full_name'], 'string','min'=>2,'max'=>20],
            [['full_name'], 'match', 'pattern' => '/^[a-zA-Z\s]+$/i'],
            ['position', 'required','message'=>'You must choose one of them.'],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['update'] = ['full_name','username','password','position'];
        $scenarios['create'] = ['full_name','username','password','position'];
        return $scenarios;
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
            'full_name' => 'Full Name',
            'position' => 'Position',
        ];
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
}
