<?php
/* @var $this PersonSexTypesController */
/* @var $model PersonSexTypes */

$this->breadcrumbs=array(
	'Person Sex Types'=>array('index'),
	'Довідник ',
);

$this->menu=array(
/*array('label'=>'List PersonSexTypes', 'url'=>array('index')),*/
array('label'=>'Додати запис', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('person-sex-types-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1>Довідник "Статі"</h1>

<p>
    Можна додати оператор порівняння (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) перед значенням пошуку
</p>

<?php echo CHtml::link('Розширений пошук','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
'id'=>'person-sex-types-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'idPersonSexTypes',
		'PersonSexTypesName',
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
),
),
)); ?>