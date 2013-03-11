<?php
$burl = Yii::app()->baseUrl;
Yii::app()->getClientScript()->registerCoreScript('jquery');
Yii::app()->clientScript->registerScriptFile($burl."/js/bootstrap-datepicker.js");
Yii::app()->clientScript->registerScriptFile($burl."/js/person.js");

$this->menu=array(
	array('label'=>'Перелік абітурієнтів','url'=>array('index'),'icon'=>"icon-list-alt"),
	array('label'=>'Додати  абітурієнта','url'=>array('create'),'icon'=>"icon-plus"),
	array('label'=>'Редагувати абітурієнта','url'=>array('update','id'=>$model->idPerson),'icon'=>" icon-pencil"),
	array('label'=>'Видалити абітурієнта','url'=>'#','icon'=>"icon-trash", 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idPerson),'confirm'=>'Are you sure you want to delete this item?')),
	//array('label'=>'Manage Person','url'=>array('admin')),
);
?>

<h2>Загальна інформація про абітурієнта (<?php echo $model->idPerson; ?>)</h2>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
        'type'=>array('bordered', 'condensed','striped'),
	'attributes'=>array(
		'idPerson',
		'FirstName',
		'LastName',
                'MiddleName',
                "Birthday"
	),
)); ?>
<h3>Параметри вступу та пільги що маэ абітуріент</h3> 
<div  style="   background-color: #fff;
                border: 1px solid #ddd;
                -webkit-border-radius: 4px;
                -moz-border-radius: 4px;
                border-radius: 4px;
                padding:10px;">
    <!--Шапка встапу-->
    <div style="margin-bottom: 10px;">
        
    <?php 
                $url = Yii::app()->createUrl("personspeciality/create",array('personid'=>$model->idPerson));
                    $this->widget('bootstrap.widgets.TbButton', array(
                    'label'=>'Додати спеціальність',
                    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                    'size' => null, // null, 'large', 'small' or 'mini'
                    'loadingText'=>'Зачекайте...',
                    'htmlOptions'=>array('id'=>'addSpec',
                        'onclick'=>"PSN.addSpec(this,'$url');",
                        ),
                )); ?>
    </div>
    <!--/Шапка встапу-->
    <!--Вкладки-->
    <div id="tab-holder">
       <?php $this->renderPartial("tabs/_tabs",  array('model'=>$model)); ?>
    </div>
    <!--/Вкладки-->
    <hr>
       <?php $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType'=>'button',
                'type'=>'primary',
                'label'=>'Зберегти всі зміни',
                'size'=>"large",
                'loadingText'=>'Збереження...',
                'htmlOptions'=>array('id'=>'personSave'),
                )); 
            ?>
    
</div>
<?php $this->renderPartial("modals/_benefitModal",array());?>
<div id="new-zno"></div>
<div id="spec-modal-holder"></div>