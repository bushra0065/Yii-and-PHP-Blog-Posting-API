<?php
$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
    'Login',
);
?>

<h1>Login</h1>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'enableClientValidation' => true,
        'enableAjaxValidation' => false,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'htmlOptions' => array('class' => 'form-horizontal'),
    ));

    echo $form->errorSummary($model, null, null, array('class' => 'alert alert-danger'));

    echo '<div class="form-group">';
    echo $form->labelEx($model, 'username', array('class' => 'control-label col-sm-2'));
    echo '<div class="col-sm-10">';
    echo $form->textField($model, 'username', array('class' => 'form-control'));
    echo $form->error($model, 'username', array('class' => 'text-danger'));
    echo '</div></div>';

    echo '<div class="form-group">';
    echo $form->labelEx($model, 'password', array('class' => 'control-label col-sm-2'));
    echo '<div class="col-sm-10">';
    echo $form->passwordField($model, 'password', array('class' => 'form-control'));
    echo $form->error($model, 'password', array('class' => 'text-danger'));
    echo '</div></div>';

    echo '<div class="form-group">';
    echo '<div class="col-sm-offset-2 col-sm-10">';
    echo $form->checkBox($model, 'rememberMe');
    echo $form->label($model, 'rememberMe');
    echo '</div></div>';

    echo '<div class="form-group">';
    echo '<div class="col-sm-offset-2 col-sm-10">';
    echo CHtml::submitButton('Login', array('class' => 'btn btn-primary'));
    echo '</div></div>';

    $this->endWidget();
    ?>

</div><!-- form -->
