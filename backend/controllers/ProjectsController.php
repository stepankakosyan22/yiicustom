<?php

namespace backend\controllers;

use backend\models\ProjectWorker;
use backend\models\User;
use Yii;
use backend\models\Projects;
use backend\models\ProjectsSearch;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;


/**
 * ProjectsController implements the CRUD actions for Projects model.
 */
class ProjectsController extends Controller
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
     * Lists all Projects models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Projects model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Updates an existing Projects model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update_project';
        $developers=ProjectWorker::find()->where(['id_project'=>$model->id_project])->all();

        $users=User::find()->all();
        $worker = new ProjectWorker();
        $worker_ids = Yii::$app->request->post();



        if ($model->load(Yii::$app->request->post())) {
            foreach ($developers as $developer){
                $developer->delete();
            }
            $imageName = $model->project_name;
            $model->logo = UploadedFile::getInstance($model, 'logo');
            if (!empty($model->logo)) {
                $model->logo->saveAs('uploads/logo/' . $imageName . '.' . $model->logo->extension);
                $model->logo = 'uploads/logo/' . $imageName . '.' . $model->logo->extension;
            }
            $model->save();
            if($worker_ids['ProjectWorker']['id_worker'] ){
                foreach ($worker_ids['ProjectWorker']['id_worker'] as $id_worker) {
                    $workers = new ProjectWorker();
                    if (!($workers->id_project == $model->id_project && $workers->id_worker == $id_worker)) {
                        $workers->id_project = $model->id_project;
                        $workers->id_worker = $id_worker;
                        $workers->save();
                    }
                }
            }


            return $this->redirect(['/site/project', 'id_project' => $model->id_project]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'workers' => $worker,
                'developers' => $developers,
                'users'=>$users
            ]);
        }
    }

    /**
     * Creates a new Projects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate()
    {
        $model = new Projects();
        $model->scenario = 'create_project';
        $worker_ids = Yii::$app->request->post();
        $worker = new ProjectWorker();

        if ($model->load(Yii::$app->request->post()) && isset($worker_ids['ProjectWorker']) && isset($worker_ids['ProjectWorker']['id_worker'])) {
            $imageName = $model->project_name;

            $model->logo = UploadedFile::getInstance($model, 'logo');

            if (!empty($model->logo)) {
                $model->logo->saveAs('uploads/logo/' . $imageName . '.' . $model->logo->extension);
                $model->logo = 'uploads/logo/' . $imageName . '.' . $model->logo->extension;

            }
            $model->save();
            if (!empty($worker_ids['ProjectWorker']['id_worker'])) {
                foreach ($worker_ids['ProjectWorker']['id_worker'] as $id_worker) {
                    $workers = new ProjectWorker();
                    $workers->id_project = $model->id_project;
                    $workers->id_worker = $id_worker;
                    $workers->save();
                }
            }

            return $this->redirect(['/site/project', 'id_project' => $model->id_project]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'workers' => $worker,
            ]);
        }
    }

    public function actionValidation()
    {
        $model = new Projects();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = 'json';
            return ActiveForm::validate($model);
        }
    }

    /**
     * Deletes an existing Projects model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['/site/index']);
    }

    /**
     * Finds the Projects model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Projects the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Projects::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
