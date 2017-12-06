<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reports".
 *
 * @property integer $id_report
 * @property integer $id_project
 * @property integer $id_user
 * @property string $report_day
 * @property string $description
 * @property double $working_time
 */
class Reports extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reports';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_project', 'id_user', 'report_day', 'description','working_time'], 'required'],
            [['id_project', 'id_user'], 'integer'],
            ['id_project','validateReportDates','on'=>'create_report'],
            [['report_day'], 'safe'],
            [['description'], 'required'],
            [['working_time'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_report' => 'Id Report',
            'id_project' => 'Choose project',
            'id_user' => 'Id User',
            'report_day' => 'Report Day',
            'description' => 'Description',
            'working_time' => 'Working Day',
        ];
    }
    public function validateReportDates($attribute, $params, $validator)
    {
        $model = new Reports();
        $items=Yii::$app->request->post();
        $existing_reports=Reports::find()
            ->andWhere(['id_project'=>$items['Reports']['id_project']])
            ->andWhere(['id_user'=>Yii::$app->user->id])
            ->all();
            if ($model->load(\Yii::$app->request->post())) {
                foreach ($existing_reports as $ex_rep){
                    if ($existing_reports && substr($ex_rep['report_day'],0,10)==date('Y-m-d')) {
                        $this->addError($attribute,'Today you already taken report for this project!');
                }
            }
        }
    }
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create_report'] = ['id_project','id_user','report_day','description','working_time'];
        return $scenarios;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsProject(){
        return $this->hasOne(Projects::className(), ['id_project'=>'id_project']);
    }
}
