<?php
/* @var $this PostsController */
/* @var $model Post */

$this->breadcrumbs=array(
	'Post'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Post', 'url'=>array('index')),
	array('label'=>'Manage Post', 'url'=>array('admin')),
);
?>

<h1>Create Posts</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>