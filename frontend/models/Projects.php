<?php

namespace app\models;

use Yii;

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
            [['project_name', 'start_date', 'customer'], 'required'],
            [['edf'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['project_name', 'customer', 'logo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_project' => 'Id Project',
            'project_name' => 'Project Name',
            'edf' => 'Edf',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'customer' => 'Customer',
            'logo' => 'Logo',
        ];
    }
}
