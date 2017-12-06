<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            [['gender','dob','team','start_working_at'],'string'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            [['full_name'], 'string','min'=>2,'max'=>20],
            [['full_name'], 'required'],
            [['full_name'], 'match', 'pattern' => '/^[a-zA-Z\s]+$/i'],
            ['dob', 'validateBirthday'],
            ['prof_image', 'file','skipOnEmpty' => true, 'extensions' => 'jpeg, png, jpg'],

            ['work_time', 'string'],
            ['position', 'required','message'=>'You must choose one of them.'],
            ['start_working_at', 'validateDates'],
        ];
    }

    public function validateDates($attribute, $params, $validator)
    {
        $model = new SignupForm();
        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
            if (strtotime($model->start_working_at) > strtotime(date('Y-m-d'))) {
                $this->addError($attribute, "Start working date cannot be future date.");
            }
        }
    }

    public function validateBirthday($attribute, $params, $validator)
    {
        $model = new SignupForm();
        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
            if (strtotime($model->dob) > (strtotime(date('Y-m-d'))-504921600)) {
                $this->addError($attribute, "Your age cannot be small than 16.");
            }
        }
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->full_name = $this->full_name;
        $user->gender = $this->gender;
        $user->dob=$this->dob;
        $user->prof_image=$this->prof_image;
        $user->work_time=$this->work_time;
        $user->team=$this->team;
        $user->start_working_at=$this->start_working_at;
        $user->position=$this->position;

        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
