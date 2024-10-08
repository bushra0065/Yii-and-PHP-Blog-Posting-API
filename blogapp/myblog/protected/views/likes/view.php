<?php
/* @var $this LikesController */
/* @var $model Like */

$this->breadcrumbs=array(
	'Like'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Like', 'url'=>array('index')),
	array('label'=>'Create Like', 'url'=>array('create')),
	array('label'=>'Update Like', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Like', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Like', 'url'=>array('admin')),
);
?>

<h1>View Likes #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'post_id',
	),
)); ?>
