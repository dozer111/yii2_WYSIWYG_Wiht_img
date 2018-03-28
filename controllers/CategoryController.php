<?php

namespace app\controllers;

use Yii;
use app\models\Category;
use app\models\SearchCategory;
use yii\base\DynamicModel;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;
use vova07\imperavi\actions\UploadFileAction;
use vova07\imperavi\actions\GetImagesAction;


/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{
    /**
     * @inheritdoc
     */

    public function actions()

    {

        return [

            'image-upload' => [

                'class' => UploadFileAction::className(),

                'url' => '../upload/',

                'path' => '@webroot/upload/',

            ],

            'images-get' => [

                'class' => GetImagesAction::className(),

                'url' => '../upload/',

                'path' => '@webroot/upload/',



            ],

        ];

    }


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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchCategory();
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            #echo "<pre>";
            #die(var_dump(Yii::$app->request->post()));
            return $this->redirect(['view', 'id' => $model->id]);
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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




    public  function actionSaveRedactorImg($sub='main')
    {
        $this->enableCsrfValidation=false;

        if(Yii::$app->request->isPost)
        {
            #1 выбираем директорию для загрузки фотографий
            $dir='/web/img/'.$sub.'/';
            #2 делаем для редактора строку со ссылкой на файл картинки
            $res_link=str_replace('admin.','',
                    Url::home(true)).'/web/img/'.$sub.'/';
            #3 получаем файл с формы по имени
            $file=UploadedFile::getInstanceByName('file');
            #4 создаем модель на лету, и валидируем её
            $model=new DynamicModel(compact('file'));
            $model->addRule('file','image')->validate();

            # 5 провалидировали
            if($model->hasErrors())
                $result=['error'=>$model->getFirstError('file')];
            // если ошибок нету
            else
            {
                #6 генерируем название файла
                $model->file->name=strtotime('now').'_'.Yii::$app->security
                        ->generateRandomString(56).'.'.$model->file->extension;

                #7 загружаем его в директорию
                if($model->file->saveAs($dir.$model->file->name)) {
                    // возвращаем для виджета ссылку на файл
                    $result = ['filelink' => $res_link . $model->file->name, 'filename' => $model->file->name];
                }
                else
                    $result=['error'=>Yii::t('vova07/imperavi','ERROR_CAN_NOT_UPLOAD_FILE')];

                Yii::$app->response->format=Response::FORMAT_JSON;
                return $result;
            }}


            else
            {
                throw new BadRequestHttpException('ONLY POST IS ALLOWED');
            }

        }
    }




