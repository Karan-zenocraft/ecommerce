<?php

namespace backend\controllers;

use backend\components\AdminCoreController;
use common\models\Advertise;
use common\models\AdvertiseSearch;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * AdvertiseController implements the CRUD actions for Advertise model.
 */
class AdvertiseController extends AdminCoreController
{
    /**
     * {@inheritdoc}
     */
    /*public function behaviors()
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
     */
    /**
     * Lists all Advertise models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdvertiseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Advertise model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Advertise model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Advertise();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $file = \yii\web\UploadedFile::getInstance($model, 'image');
            if (!empty($file)) {
                $file_name = $file->basename . "_" . uniqid() . "." . $file->extension;
                //p(trim($file_name));
                $file_filter = str_replace(" ", "", $file_name);
                $model->image = $file_filter;
                $file->saveAs(Yii::getAlias('@root') . '/uploads/advertise/' . $file_filter);
            }
            $model->save(false);
            Yii::$app->session->setFlash('success', Yii::getAlias('@advertise_add_message'));
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Advertise model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old_image = basename($model->image);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $file = \yii\web\UploadedFile::getInstance($model, 'image');
            if (!empty($file)) {
                $delete = $model->oldAttributes['image'];
                $file_name = $file->basename . "_" . uniqid() . "." . $file->extension;
                $file_filter = str_replace(" ", "", $file_name);
                if (!empty($old_image) && file_exists(Yii::getAlias('@root') . '/uploads/advertise/' . $old_image)) {
                    unlink(Yii::getAlias('@root') . '/uploads/advertise/' . $old_image);
                }
                $file->saveAs(Yii::getAlias('@root') . '/uploads/advertise/' . $file_filter, false);
                $model->image = $file_filter;
            } else {
                $model->image = $old_image;
            }
            $model->save(false);
            Yii::$app->session->setFlash('success', Yii::getAlias('@advertise_update_message'));
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Advertise model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', Yii::getAlias('@advertise_delete_message'));
        return $this->redirect(['index']);
    }

    /**
     * Finds the Advertise model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Advertise the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Advertise::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
