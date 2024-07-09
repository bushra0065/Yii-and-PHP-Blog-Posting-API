<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
        $this->redirect(array('posts/index'));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

    /**
     * registers a new user.
     * @throws CException
     * @throws Exception
     */
    public function actionSignup()
    {
        $model=new User;

        if(isset($_POST['ajax']) && $_POST['ajax']==='signup-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if(isset($_POST['User']))
        {
            $model->attributes=$_POST['User'];
            $model->password= $model->hashPassword($_POST['User']['password']);

            if($model->save()){
                // Generate the verification token
                $model->generateVerificationToken();
                // Simulate sending an email with the verification link
                // In a real application, you would send an actual email
                $verificationLink = Yii::app()->createAbsoluteUrl('site/verify', array('token' => $model->verification_token));
                Yii::app()->user->setFlash('success', "Please verify your email address by clicking the following link: <a href='{$verificationLink}'>{$verificationLink}</a>");
            }
             $this->redirect(array('site/login'));
        }

        $this->render('signup', array('model'=>$model));
    }

    /**
     * verifies user email.
     */
    public function actionVerify($token)
    {
        $user = User::model()->findByAttributes(array('verification_token'=>$token));
        if($user !== null)
        {
            $user->verified = 1;
            $user->verification_token = null;
            $user->save();
            if (isset(Yii::app()->user->id)){
                Yii::app()->user->setState('verified', 1);
                Yii::app()->user->setFlash('success', 'Your email has been verified. Proceed post a blog post');
                $this->redirect(array('posts/index'));
            }
            Yii::app()->user->setFlash('success', 'Your email has been verified. Proceed to log in');
        }
        else
        {
            Yii::app()->user->setFlash('error', 'Invalid verification token.');
        }

        $this->redirect(array('site/login'));
    }

    /**
     * Creates a blog.
     */
    public function actionCreate()
    {
        $model = new Post;
        if(isset($_POST['Post']))
        {
            $model->attributes = $_POST['Post'];
            $model->user_id = Yii::app()->user->id;
            if($model->save())
                $this->redirect(array('view', 'id'=>$model->id));
        }
        $this->render('create', array('model'=>$model));
    }

    /**
     * Views a blog.
     */
    public function actionView($id)
    {
        $model = Post::model()->findByPk($id);
        $this->render('view', array('model'=>$model));
    }


    /**
     * Updates a blog.
     * @throws CHttpException
     */
    public function actionUpdate($id)
    {
        $model = Post::model()->findByPk($id);
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
     * Deletes a blog.
     * @throws CHttpException
     * @throws CDbException
     */
    public function actionDelete($id)
    {
        $model = Post::model()->findByPk($id);
        if($model->user_id != Yii::app()->user->id)
            throw new CHttpException(403, 'You are not authorized to delete this post.');

        $model->delete();
        $this->redirect(array('index'));
    }

    /**
     * Checks if email exists
     */
    public function actionCheckEmail()
    {
        if (Yii::app()->request->isAjaxRequest && isset($_POST['email'])) {
            $email = $_POST['email'];
            $user = User::model()->findByAttributes(array('email' => $email));
            if ($user === null) {
                echo CJSON::encode(array('valid' => true));
            } else {
                echo CJSON::encode(array('valid' => false, 'message' => 'This email is already in use.'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

}