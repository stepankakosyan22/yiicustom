<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "checkin".
 *
 * @property integer $checkin_id
 * @property integer $user_id
 * @property integer $week
 * @property integer $month
 * @property string $day
 * @property string $check_in
 * @property string $lunch_check_out
 * @property string $lunch_check_in
 * @property string $check_out
 * @property string $worked_hours
 * @property string $work_hours_extra
 * @property string $comment
 */
class Checkin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'checkin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id','week','month'], 'integer'],
            [['day', 'comment'], 'string', 'max' => 500],
            [['check_in', 'lunch_check_out', 'lunch_check_in', 'check_out', 'worked_hours', 'work_hours_extra'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'checkin_id' => 'Checkin ID',
            'user_id' => 'User ID',
            'day' => 'Day',
            'check_in' => 'Check In',
            'lunch_check_out' => 'Lunch Check Out',
            'lunch_check_in' => 'Lunch Check In',
            'check_out' => 'Check Out',
            'worked_hours' => 'Worked Hours',
            'work_hours_extra' => 'Work Hours Extra',
            'comment' => 'Comment',
            'week' => 'Week',
            'month' => 'Month',
        ];
    }
}
