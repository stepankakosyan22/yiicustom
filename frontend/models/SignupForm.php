<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $first_name;
    public $last_name;
    public $gender;
    public $dob;
    public $prof_image;
    public $work_time;
    public $team;
    public $position;
    public $company_name;
    public $start_working_at;


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

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['first_name', 'string'],
            ['last_name', 'string'],
            ['gender', 'string'],
            ['dob', 'string'],
            ['dob', 'validateBirthday'],
            ['work_time', 'string'],
            ['team', 'string'],
            ['position', 'required'],
            ['company_name', 'string'],
            ['start_working_at', 'string'],
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
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->gender = $this->gender;
        $user->dob=$this->dob;
        $user->prof_image=$this->prof_image;
        $user->work_time=$this->work_time;
        $user->team=$this->team;
        $user->start_working_at=$this->start_working_at;
        $user->position=$this->position;
        $user->company_name=$this->company_name;

        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
