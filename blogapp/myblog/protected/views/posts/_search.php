<?php
/* @var $this PostsController */
/* @var $model Post */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
    )); ?>
<h2>Search Form</h2>
    <div class="row">
        <div class="col-md-6"> <!-- First column, spans 6 grid units -->
            <?php echo $form->label($model,'title'); ?>
            <?php echo $form->textField($model,'title', array('class' => 'form-control')); ?>
        </div>
        <div class="col-md-6"> <!-- Second column, spans 6 grid units -->
            <?php echo $form->label($model,'content'); ?>
            <?php echo $form->textField($model,'content', array('class' => 'form-control')); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6"> <!-- First column, spans 6 grid units -->
            <?php echo $form->labelEx($model,'created_at'); ?>
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'created_at',
                'options' => array(
                    'dateFormat' => 'yy-mm-dd', // Specify the format
                    // Additional options for the datepicker can be added here
                ),
                'htmlOptions' => array(
                    'class' => 'form-control', // Add Bootstrap form-control class
                ),
            )); ?>
            <?php echo $form->error($model,'created_at'); ?>
        </div>
        <div class="col-md-6"> <!-- Second column, spans 6 grid units -->
            <?php echo CHtml::label('Username', 'username', array('class' => 'control-label')); ?>
            <?php echo CHtml::textField('username', isset($_GET['username']) ? $_GET['username'] : '', array('class' => 'form-control', 'placeholder' => 'Search by Author')); ?>
        </div>
    </div>

    <div class="row buttons">
        <div class="col-md-12"> <!-- Full-width column for buttons -->
            <?php echo CHtml::submitButton('Search', array('class' => 'btn btn-primary')); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->
