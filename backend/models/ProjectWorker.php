<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "project_worker".
 *
 * @property integer $id_project
 * @property integer $id_worker
 */
class ProjectWorker extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_worker';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_project', 'id_worker'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_project' => 'Id Project',
            'id_worker' => 'Worker',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersUser(){
        return $this->hasMany(User::className(), ['id'=>'id_worker']);
    }
}
