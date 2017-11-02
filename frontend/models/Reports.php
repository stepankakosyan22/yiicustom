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
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsProject(){
        return $this->hasOne(Projects::className(), ['id_project'=>'id_project']);
    }
}
