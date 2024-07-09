<?php

class PostsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
//			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','like'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'users'=>array('admins'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     * @throws CHttpException
     */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @throws CHttpException
     */
    public function actionCreate()
    {
        $model = new Post;
        if(Yii::app()->user->verified == 1) {
        if(isset($_POST['Post']))
        {
            $model->attributes = $_POST['Post'];
            $model->user_id = Yii::app()->user->id;
            if($model->save())
                Yii::app()->user->setFlash('success', 'Blog posted successfully');
            $this->redirect(array('view', 'id'=>$model->id));
        }
            $this->render('create', array('model'=>$model));
        }else{
            $this->display_verification_link();

        }

    }


    /**
     * displays email verification link
     */
     function display_verification_link()
    {
        $verificationLink = Yii::app()->createAbsoluteUrl('site/verify', array('token' => User::model()->findByPk(Yii::app()->user->id)->verification_token));
        Yii::app()->user->setFlash('success', "Please verify your email address by clicking the following link to first: <a href='{$verificationLink}'>{$verificationLink}</a>");
        $this->redirect(array('index'));
    }
    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     * @throws CHttpException
     */
    public function actionUpdate($id)
    {
        $model = Post::model()->findByPk($id);
        if(Yii::app()->user->verified != 1) {
            $this->display_verification_link();
        }
        if($model->user_id != Yii::app()->user->id)
            throw new CHttpException(403, 'You are not authorized to update this post.');

        if(isset($_POST['Post']))
        {
            $model->attributes = $_POST['Post'];
            if($model->save())
                $this->redirect(array('view', 'id'=>$model->id));
        }
        $this->render('update', array('model'=>$model));
    }


    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     * @throws CHttpException
     * @throws CDbException
     */
    public function actionDelete($id)
    {
        $model = Post::model()->findByPk($id);
        if(Yii::app()->user->verified != 1) {
            $this->display_verification_link();
        }
        if($model->user_id != Yii::app()->user->id)
            throw new CHttpException(403, 'You are not authorized to delete this post.');

        if($model->delete()){
            Yii::app()->user->setFlash('success', 'Blog posted successfully');
        };
        $this->redirect(array('index'));
    }


    /**
	 * Lists all models.
	 */
    public function actionIndex()
    {

        $model = new Post('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Post'])) {
            $model->attributes = $_GET['Post'];
        }

        $criteria = new CDbCriteria();
        // Check if username search is provided in GET parameter

        // Fetch the logged-in user's ID
        $userId = Yii::app()->user->id;

        if (isset(Yii::app()->user->id)){
            // Fetch blog posts that belong to the logged-in user
            $criteria->addCondition('user_id = :user_id', 'OR');
            $criteria->params[':user_id'] = $userId;
            // Fetch blog posts that are public but do not belong to the logged-in user
            $criteria->addCondition('is_public = 1 AND user_id != :user_id', 'OR');
        }else{
            // Fetch blog posts that are public but do not belong to the logged-in user
            $criteria->addCondition('is_public = 1', 'OR');
        }

        // Search functionality

        if (!empty($model->title)) {
            $criteria->addSearchCondition('title', $model->title, true, 'AND', 'LIKE');
        }
        if (!empty($model->content)) {
            $criteria->addSearchCondition('content', $model->content, true, 'AND', 'LIKE');
        }

        // Date filter
        if (!empty($model->created_at)) {
            // Assuming created_at is a date field in your database
            $criteria->compare('created_at', $model->created_at, true);
        }

        if (isset($_GET['username'])) {
            $criteria->with = array('user'); // Assuming 'user' is the relation name
            $criteria->addSearchCondition('user.username', $_GET['username'], true, 'AND', 'LIKE' );
        }
        // Order by created_at date (newest first)
        $criteria->order = 'created_at DESC';

        $dataProvider = new CActiveDataProvider('Post', array('criteria' => $criteria));

        // Set layout to column1 if the user is not logged in
        if (!isset(Yii::app()->user->id)) {
            $this->layout = 'column1';
        }

        $this->render('index', array('dataProvider' => $dataProvider,
            'model' => $model,
        ));
    }


    /**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Post('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Post']))
			$model->attributes=$_GET['Post'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Post the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Post::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Post $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='posts-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    /**
     * adds like to a post.
     */
    public function actionLike($id)
    {

        if (!isset(Yii::app()->user->id)){
            Yii::app()->user->setFlash('danger', 'PLease log in to like.');
        }else{
            $like = new Like;
            $like->user_id = Yii::app()->user->id;
            $like->post_id = $id;
            $like->save();
            Yii::app()->user->setFlash('success', 'Success');
        }
        $this->redirect(array('index'));
    }

    /**updates a post model to public or private.
     */
    public function actionUpdateVisibility()
    {
        if (isset($_POST['id'], $_POST['is_public'])) {
            $id = (int) $_POST['id'];
            $is_public = (int) $_POST['is_public'];

            $model = $this->loadModel($id);

            if (Yii::app()->user->id === $model->user_id) {
                $model->is_public = $is_public;
                if ($model->save()) {
                    echo CJSON::encode(array('status' => 'success'));
                } else {
                    echo CJSON::encode(array('status' => 'failure', 'errors' => $model->getErrors()));
                }
            } else {
                throw new CHttpException(403, 'You are not authorized to perform this action.');
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

}
