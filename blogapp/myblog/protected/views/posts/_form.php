<?php
/* @var $this PostsController */
/* @var $model Post */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'posts-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('class' => 'form-horizontal'), // Add Bootstrap form-horizontal class
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model, '<div class="alert alert-danger">', '</div>'); ?>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'title', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model, 'title', array('class' => 'form-control', 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'title', array('class' => 'help-block')); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'content', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textArea($model, 'content', array('rows' => 6, 'cols' => 50, 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'content', array('class' => 'help-block')); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'is_public', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->dropDownList($model, 'is_public', array(
                '1' => 'Public',
                '0' => 'Private',
            ), array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'is_public', array('class' => 'help-block')); ?>
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary')); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
