<?php
$this->pageTitle=Yii::app()->name . ' - Signup';
$this->breadcrumbs=array(
    'Signup',
);
?>

<h1>Signup</h1>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'signup-form',
        'enableClientValidation' => true,
        'enableAjaxValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => true,
            'validateOnType' => true,
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
    echo $form->labelEx($model, 'email', array('class' => 'control-label col-sm-2'));
    echo '<div class="col-sm-10">';
    echo $form->textField($model, 'email', array('class' => 'form-control'));
    echo $form->error($model, 'email', array('class' => 'text-danger'));
    echo '</div></div>';

    echo '<div class="form-group">';
    echo $form->labelEx($model, 'password', array('class' => 'control-label col-sm-2'));
    echo '<div class="col-sm-10">';
    echo $form->passwordField($model, 'password', array('class' => 'form-control'));
    echo $form->error($model, 'password', array('class' => 'text-danger'));
    echo '</div></div>';

    echo '<div class="form-group">';
    echo '<div class="col-sm-offset-2 col-sm-10">';
    echo CHtml::submitButton('Signup', array('class' => 'btn btn-primary'));
    echo '</div></div>';

    $this->endWidget();
    ?>

</div><!-- form -->
