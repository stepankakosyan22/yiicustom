<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "projects".
 *
 * @property integer $id_project
 * @property string $project_name
 * @property integer $edf
 * @property string $start_date
 * @property string $end_date
 * @property string $customer
 * @property string $logo
 */
class Projects extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $logoFile;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start_date', 'customer'], 'required'],
            [['edf'], 'integer',  'min' => 1,'skipOnEmpty' => true],
            [['start_date', 'end_date'], 'safe'],
            [['logo'], 'file','skipOnEmpty' => true, 'extensions' => 'jpeg, png, jpg,gif'],
            [['customer'], 'string', 'max' => 255],

            ['project_name', 'required', 'message' => 'Please write a project name.'],
            ['project_name', 'string', 'min' => 2],
            ['project_name','unique'],
            ['end_date', 'validateDates'],
        ];
    }
    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['create_project'] = ['project_name','start_date','edf','start_date', 'customer','logo','end_date'];
        $scenarios['update_project'] = ['start_date','edf','start_date', 'customer','logo','end_date'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_project' => 'Id Project',
            'project_name' => 'Project Name',
            'edf' => 'Estimated days of finishing project',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'customer' => 'Customer',
            'logo' => 'Logo',
        ];
    }


    public function validateDates($attribute, $params, $validator)
    {
        $model = new Projects();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            if (strtotime($model->start_date) > strtotime($model->end_date)) {
                $this->addError($attribute, "End date cannot be before Start date");
            }
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomersCustomer(){
        return $this->hasOne(ProjectWorker::className(), ['id_project'=>'id_project']);
    }
}
