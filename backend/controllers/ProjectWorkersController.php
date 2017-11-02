<?php

namespace backend\controllers;

use backend\models\ProjectWorker;
use \yii\db\Query;
class ProjectWorkersController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $workers = (new Query())
            ->select('*')
            ->from('user')
            ->all();
        return $this->render('index',[
            'workers'=>$workers
        ]);
    }
    public function actionAddworkers() {
        if (\Yii::$app->request->isAjax) {
            $data = \Yii::$app->request->post();
            $workers=$data['workers'];
            $project=$data['project'];
            $worker= new ProjectWorker();
            $worker->id_worker=$workers;
            $worker->id_project=$project;
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $worker->save();
        }
        return $this->render('index');
    }
}
