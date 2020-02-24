<?php

namespace backend\controllers;

use backend\components\AdminCoreController;
use common\components\Common;
use common\models\Products;
use common\models\ProductsSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends AdminCoreController
{
    /**
     * {@inheritdoc}
     */
/*    public function behaviors()
{
return [
'verbs' => [
'class' => VerbFilter::className(),
'actions' => [
'delete' => ['POST'],
],
],
];
}*/

    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Products model.
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
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Products();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::getAlias('@product_add_message'));
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::getAlias('@product_update_message'));
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionApproveProduct($product_id)
    {
        $this->layout = 'popup';
        $productModel = Products::find()->where(['id' => $product_id])->one();
        if (!empty(Yii::$app->request->post()) && !empty($productModel)) {
            $postData = Yii::$app->request->post();
            $productModel->is_approve = $postData['Products']['is_approve'];
            $productModel->owner_discount = $postData['Products']['owner_discount'];
            $productModel->save(false);
            Yii::$app->session->setFlash('success', Yii::getAlias('@product_update_message'));
            return Common::closeColorBox();

        }
        return $this->render('approve_product', [
            'productModel' => $productModel,
        ]);
    }
}
