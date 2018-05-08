<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\Image;
use Yii;
use app\modules\admin\models\Product;
use app\modules\admin\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        $image_model = new Image();

        if ($model->load(Yii::$app->request->post())){
            $model->save();

//            --загрузка одной картинки--
            $image = $model->uploadCreate($model->imageFile = UploadedFile::getInstance($model, 'imageFile'));
            $image_model->filePath = $image;
            $image_model->itemId = $model->id;
            $image_model->modelName = 'Product' . $model->id;
            $image_model->save();

//            --загрузка нескольких картинок--
            $images = $model->uploadsCreate($model->imageFiles = UploadedFile::getInstances($model, 'imageFiles'));
            foreach ($images as $image){
                $image_model = new Image();
                $image_model->filePath = $image[0];
                $image_model->itemId = $model->id;
                $image_model->modelName = 'Product' . $model->id;
                $image_model->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $imagemodel = new Image();

        $currentimage = Image::find()->andWhere(['itemId' => $id])->one();

        if ($model->load(Yii::$app->request->post())){
            $model->save();
            $fileimg = $model->uploadImage($model->imageFile = UploadedFile::getInstance($model, 'imageFile'), $currentimage);
//           -------------- Загрузка нескольких картинок----
            $images = $model->uploadImages($model->imageFiles = UploadedFile::getInstances($model, 'imageFiles'));

            if(!empty($currentimage->filePath)){
                $currentimage->delete();
                $imagemodel->filePath = $fileimg;
                $imagemodel->itemId = $model->id;
                $imagemodel->modelName = 'Product' . $model->id;

                $imagemodel->save();
            }else{
                $imagemodel->filePath = $fileimg;
                $imagemodel->itemId = $model->id;
                $imagemodel->modelName = 'Product' . $model->id;
                $imagemodel->save();


            }
            foreach ($images as $image){

                $imagesmodel = new Image();
                $imagesmodel->filePath = $image[0];
                $imagesmodel->itemId = $model->id;
                $imagesmodel->modelName = 'Product' . $model->id;
                $imagesmodel->save();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
        'model' => $model,
    ]);
    }

    /**
     * Deletes an existing Product model.
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
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDeleteimage($id)
    {
        $model = $this->findModel($id);
        $pathcurrentimag = Image::find()->andWhere(['itemId' => $id])->one();
        unlink($pathcurrentimag->filePath);
        rmdir('uploads/Products/Product' . $id);
        $pathcurrentimag->delete();
        $model->imageFile = null;
        $model->update();
        if (Yii::$app->request->isAjax) {
            return '';

        } else {
            return $this->redirect(['update', 'id' => $model->id]);
        }
    }
}
