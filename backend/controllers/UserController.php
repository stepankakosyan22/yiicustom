<?php

namespace backend\controllers;

use frontend\models\Checkin;
use Yii;
use backend\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public $password;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $workers=User::find()->andWhere(['position'=>'Worker'])->all();
        $customers=User::find()->andWhere(['position'=>'Customer'])->all();
        return $this->render('index', [
            'workers' => $workers,
            'customers' => $customers,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $checkins=Checkin::find()->where(['user_id'=>$id])->orderBy('week')->all();
        $hours = (new \yii\db\Query())
            ->select(['*', 'SUM(`worked_hours`) AS week_hours','SUM(`work_hours_extra`) AS week_hours_extra'])
            ->from('checkin')
            ->where(['user_id' => $id])
            ->groupBy('week')
            ->orderBy('week DESC')
            ->all();

            $months = (new \yii\db\Query())
            ->select(['*', 'SUM(`worked_hours`) AS week_hours','SUM(`work_hours_extra`) AS week_hours_extra'])
            ->from('checkin')
            ->where(['user_id' => $id])
            ->groupBy('month')
            ->orderBy('month DESC')
            ->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'checkins' => $checkins,
            'hours' => $hours,
            'months' => $months
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $model->scenario='create';
        if ($model->load(Yii::$app->request->post())) {
            $model->setPassword($model->password);
            $model->generateAuthKey();
            $model->save();
            return $this->redirect(['user/index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario='update';
        if ($model->load(Yii::$app->request->post())) {
            $model->setPassword($model->password);
            $model->save();
            return $this->redirect(['user/index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['/user/index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
