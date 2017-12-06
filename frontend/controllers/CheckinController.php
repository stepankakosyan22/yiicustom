<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Checkin;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CheckinController implements the CRUD actions for Checkin model.
 */
class CheckinController extends Controller
{
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
     * Lists all Checkin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $checkins = Checkin::find()->where(['user_id' => \Yii::$app->user->id])->all();

        return $this->render('index', [
            'checkins' => $checkins,
            'chackedin'=>$this->isCheckined()
        ]);
    }

    private function isCheckined(){
        $checkins = Checkin::find()->where(['user_id' => \Yii::$app->user->id,'day'=>date('d-m-Y D')])->all();
        if($checkins){
            return true;
        }else{
            return false;
        }

    }
    /**
     * Displays a single Checkin model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionCreate()
    {
        $model = new Checkin();
        if (\Yii::$app->request->isAjax) {
            $data = \Yii::$app->request->post();
            $checkins = (new Query())
                ->select('*')
                ->from('checkin')
                ->andWhere(['user_id' => \Yii::$app->user->id])
                ->all();
            $check_in = $data['check_in'];
            $model->day = date('d-m-Y D');
            $model->user_id = \Yii::$app->user->id;
            $model->check_in = $check_in;
            $model->week=date('W');
            $model->month=date('m');
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model->save();
            return $this->redirect(['/checkin/index']);
        } else {
            return $this->render('/checkin/index', [
                'model' => $model,
            ]);
        }
    }

    public function actionLunchcheckout()
    {
        if (\Yii::$app->request->isAjax) {
            $data = \Yii::$app->request->post();
            $model = $this->findModel($data['id']);
            $lunch_check_out = $data['lunch_check_out'];
            $model->lunch_check_out = $lunch_check_out;
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model->save();
            return $this->redirect(['/checkin/index']);
        } else {
            return $this->render('/checkin/index');
        }
    }

    public function actionLunchcheckin()
    {
        if (\Yii::$app->request->isAjax) {
            $data = \Yii::$app->request->post();
            $model = $this->findModel($data['id']);
            $lunch_check_in = $data['lunch_check_in'];
            $model->lunch_check_in = $lunch_check_in;
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model->save();
            return $this->redirect(['/checkin/index']);
        } else {
            return $this->render('/checkin/index');
        }
    }

    public function actionCheckout()
    {
        if (\Yii::$app->request->isAjax) {
            $data = \Yii::$app->request->post();
            $model = $this->findModel($data['id']);
            $check_out = $data['check_out'];

            $check_in_hour = substr($model['check_in'], 0, 2);
            $check_in_minute = substr($model['check_in'], 3, 5);
            $lunch_check_out_hour = substr($model['lunch_check_out'], 0, 2);
            $lunch_check_out_minute = substr($model['lunch_check_out'], 3, 5);
            $lunch_check_in_hour = substr($model['lunch_check_in'], 0, 2);
            $lunch_check_in_minute = substr($model['lunch_check_in'], 3, 5);
            $check_out_hour = substr($check_out, 0, 2);
            $check_out_minute = substr($check_out, 3, 5);
            $hours = (($lunch_check_out_hour - $check_in_hour) + ($check_out_hour - $lunch_check_in_hour)) * 60;
            $minutes = ($lunch_check_out_minute - $check_in_minute) + ($check_out_minute - $lunch_check_in_minute);
            $all = $hours + $minutes;

            $starting_day = \Yii::$app->user->identity->start_working_at;
            $st = substr($starting_day, 2, 4);

            if ($check_out_hour>=18 && $check_out_minute >30 && $st === '30') {
                $def_hour = 18;
                $def_minute = 30;
            }elseif ($check_out_hour>=18 && $st === '00'){
                $def_hour = 18;
                $def_minute = 0;
            }

            if (isset($def_hour) && isset($def_minute)){
                $h=($check_out_hour-$def_hour)*60;
                $m=$check_out_minute+$def_minute+$h;
            }
            if (isset($m)){
                $model->worked_hours=json_encode(abs($m-$all));
            } else {
                $model->worked_hours=json_encode(abs($all));
            }

            $model->check_out = $check_out;
            $model->work_hours_extra = json_encode($all);

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model->save();

            return $this->redirect(['/checkin/index']);
        } else {
            return $this->render('/checkin/index');
        }
    }

    public function actionComment()
    {
        if (\Yii::$app->request->isAjax) {
            $data = \Yii::$app->request->post();
            $model = $this->findModel($data['id']);
            $comment = $data['comment'];
            $model->comment = $comment;
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model->save();
            return $this->redirect(['/checkin/index']);
        } else {
            return $this->render('/checkin/index');
        }
    }

    /**
     * Updates an existing Checkin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->checkin_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Checkin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Checkin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Checkin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Checkin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

