<?php
/* @var $this Coursescontroller */
/* @var $model Courses */

$this->breadcrumbs=array(
	'Courses'=>array('index'),
	$model->idCourse=>array('view','id'=>$model->idCourse),
	'Зміна запису довідника',
);

$this->menu=array(
	/*array('label'=>'List Courses', 'url'=>array('index')),*/
	array('label'=>'Додати запис', 'url'=>array('create'),'icon'=>"icon-plus"),
	array('label'=>'Переглянути запис', 'url'=>array('view', 'id'=>$model->idCourse),'icon'=>"icon-eye-open"),
	array('label'=>'Переглянути записи', 'url'=>array('admin'),'icon'=>"icon-list-alt"),
);
?>

<h1>Змінити запис довідника "Курси" <?php echo $model->idCourse; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>