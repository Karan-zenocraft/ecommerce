<?php

namespace backend\controllers;

use common\models\Category;
use common\models\CategorySearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $file = \yii\web\UploadedFile::getInstance($model, 'photo');
            if (!empty($file)) {
                $file_name = $file->basename . "_" . uniqid() . "." . $file->extension;
                //p(trim($file_name));
                $file_filter = str_replace(" ", "", $file_name);
                $model->photo = Yii::$app->params['root_url'] . '/uploads/category/' . $file_filter;
                $file->saveAs(Yii::getAlias('@root') . '/uploads/category/' . $file_filter);
            }
            $model->save(false);
            Yii::$app->session->setFlash('success', Yii::getAlias('@category_add_message'));
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old_image = basename($model->photo);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $file = \yii\web\UploadedFile::getInstance($model, 'photo');
            if (!empty($file)) {
                $delete = $model->oldAttributes['photo'];
                $file_name = $file->basename . "_" . uniqid() . "." . $file->extension;
                $file_filter = str_replace(" ", "", $file_name);
                if (!empty($old_image) && file_exists(Yii::getAlias('@root') . '/uploads/category/' . $old_image)) {
                    unlink(Yii::getAlias('@root') . '/uploads/category/' . $old_image);
                }
                $file->saveAs(Yii::getAlias('@root') . '/uploads/category/' . $file_filter, false);
                $model->photo = Yii::$app->params['root_url'] . '/uploads/category/' . $file_filter;
            } else {
                $model->photo = Yii::$app->params['root_url'] . '/uploads/category/' . $old_image;
            }
            $model->save(false);
            Yii::$app->session->setFlash('success', Yii::getAlias('@category_update_message'));
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->session->setFlash('success', Yii::getAlias('@category_delete_message'));
        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionGetSubcategory()
    {

        $snParentCategoryId = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        // GET MILESTONES //
        $subCategories = Category::SubCategoryDropdown($snParentCategoryId, $flag = "");
        echo "<option value=''>--Choose Sub Category--</option>";
        if (count($subCategories) > 0) {
            foreach ($subCategories as $snId => $smValues) {
                echo "<option value='" . $snId . "'>" . $smValues . "</option>";
            }
        } else {
            // echo  "<option value=''>No data found</option>";
        }
        exit;
    }
}
