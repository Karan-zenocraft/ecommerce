<?php

namespace backend\controllers;

use backend\components\AdminCoreController;
use common\models\Brands;
use common\models\BrandsSearch;
use common\models\Category;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * BrandsController implements the CRUD actions for Brands model.
 */
class BrandsController extends AdminCoreController
{
    /**
     * {@inheritdoc}
     */
    /*   public function behaviors()
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
     * Lists all Brands models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BrandsSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $queryParams = array_merge(array(), Yii::$app->request->getQueryParams());
        if (isset($_GET['BrandsSearch']['parent_category_id'])) {
            $amSubCategories = Category::SubCategoryDropdown($_GET['BrandsSearch']['parent_category_id']);
        } else {
            $amSubCategories = Category::SubCategoryDropdown($searchModel->parent_category_id);
        }
        if (isset($_GET['BrandsSearch']['sub_category_id']) && !empty($_GET['BrandsSearch']['sub_category_id'])) {
            $searchModel->sub_category_id = $_GET['BrandsSearch']['sub_category_id'];
        }
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'amSubCategories' => $amSubCategories,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Brands model.
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
     * Creates a new Brands model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Brands();
        $parentCategories = Category::ParentCategoryDropdown();
        $subCategories = [];
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::getAlias('@brand_add_message'));
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'parentCategories' => $parentCategories,
            'subCategories' => $subCategories,
        ]);
    }

    /**
     * Updates an existing Brands model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $parentCategories = Category::ParentCategoryDropdown();
        // GET MILESTONES //
        $subCategories = !empty($model->parent_category_id) ? Category::SubCategoryDropdown($model->parent_category_id) : [];
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::getAlias('@brand_update_message'));
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'parentCategories' => $parentCategories,
            'subCategories' => $subCategories,
        ]);
    }

    /**
     * Deletes an existing Brands model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->session->setFlash('success', Yii::getAlias('@brand_delete_message'));
        return $this->redirect(['index']);
    }

    /**
     * Finds the Brands model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Brands the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Brands::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
