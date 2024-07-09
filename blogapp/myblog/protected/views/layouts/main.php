<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><?php echo CHtml::link('Home', array('site/index'), array('class' => 'nav-link')); ?></li>
                <?php if (Yii::app()->user->isGuest): ?>
                    <li class="nav-item"><?php echo CHtml::link('Login', array('site/login'), array('class' => 'nav-link')); ?></li>
                    <li class="nav-item"><?php echo CHtml::link('Signup', array('site/signup'), array('class' => 'nav-link')); ?></li>
                <?php else: ?>
                    <li class="nav-item"><?php echo CHtml::link('Logout (' . Yii::app()->user->name . ')', array('site/logout'), array('class' => 'nav-link')); ?></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <div class="content">
        <?php
        $flashMessages = Yii::app()->user->getFlashes();
        if ($flashMessages) {
            foreach ($flashMessages as $key => $message) {
                echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
            }
        }
        ?>
        <?php echo $content; ?>
    </div>
</div>
</body>
</html>
