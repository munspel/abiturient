<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'person-form',
    //'type'=>'horizontal',
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array("class"=>"well"),
)); 

$form=new TbActiveForm();?>
<p class="help-block"><strong>Особисті дані</strong></p>
        <hr>
       
        <div class="row-fluid">
            <div class ="span4">
            <?php echo $form->label($model,'FirstName');//,array('class'=>'span3'));?>
            <?php echo $form->textField($model,'FirstName',array('class'=>'span12','maxlength'=>50)); ?>
            <?php echo $form->error($model,'FirstName'); ?>    
            </div>
            <div class ="span4">
            <?php echo $form->label($model,'LastName');//,array('class'=>'span3'));?>
            <?php echo $form->textField($model,'LastName',array('class'=>'span12','maxlength'=>50)); ?>
            <?php echo $form->error($model,'LastName'); ?>        
            </div>
            <div class ="span4">
            <?php echo $form->label($model,'MiddleName');//,array('class'=>'span3'));?>
            <?php echo $form->textField($model,'MiddleName',array('class'=>'span12','maxlength'=>50)); ?>
            <?php echo $form->error($model,'MiddleName'); ?>    
            </div>
        </div>
       <div class="row-fluid">
            <div class ="span4">
            <?php echo $form->label($model,'FirstNameR');//,array('class'=>'span3'));?>
            <?php echo $form->textField($model,'FirstNameR',array('class'=>'span12','maxlength'=>50)); ?>
            </div>
            <div class ="span4">
            <?php echo $form->label($model,'MiddleNameR');//,array('class'=>'span3'));?>
            <?php echo $form->textField($model,'MiddleNameR',array('class'=>'span12','maxlength'=>50)); ?>
            </div>
            <div class ="span4">
            <?php echo $form->label($model,'FirstNameR');//,array('class'=>'span3'));?>
            <?php echo $form->textField($model,'LastNameR',array('class'=>'span12','maxlength'=>50)); ?>
            </div>
        </div>
        
        <div class="row-fluid">
            <div class ="span3">
                <?php echo $form->labelEx($model,'Birthday'); ?>
                <?php echo $form->textField($model,'Birthday', array('class'=>'span12 datepicker')); ?>
                <script type="text/javascript">
                    $(".datepicker").datepicker({'format':"dd.mm.yyyy"});
                </script>
            </div>
            <div class ="span3">
                <?php echo $form->labelEx($model,'PersonSexID'); ?>
               
                <?php echo $form->dropDownList($model,'PersonSexID', PersonSexTypes::DropDown(), array('class'=>'span12')); ?>
               
                <?php echo $form->labelEx($model,'PersonSexID'); ?>
                <script type="text/javascript">
                    $('#togle_personsex').toggleButtons();
                </script>
            
            </div>
         
            <div class ="span3">
                <?php echo $form->labelEx($model,'IsResident'); ?>
                 <div id="togle_resident">
                    <?php echo $form->checkBox($model,'IsResident');//, array("Ні", "Так"), array('class'=>'span12')); ?>
                 </div>
                 <script type="text/javascript">
                    $('#togle_resident').toggleButtons({
                        //width: 100,
                        label: {
                            enabled: "Так",
                            disabled: "Ні"
                        }
                    });
                 </script>      
            </div>
        </div>
        <p class="help-block"><strong>Адреса</strong></p>
        <hr>
        <div class="row-fluid">
            <div class ="span12">
            <?php echo CHtml::label("Область або велике місто","KOATUUCodeL2ID");//,array('class'=>'span3'));?>
            <?php echo CHtml::activeDropDownList($model, "KOATUUCodeL1ID", KoatuuLevel1::DropDown(), 
                    array('class'=>'span12', 
                            'onchange'=>"PSN.KOATUUChange(this,1)"));
                     ?>
            </div>
        </div>
        <div class="row-fluid" <?php echo empty($model->KOATUUCodeL2ID) ? "style='display:none;'":""; ?>>
            <div class ="span12"  > 
            <?php echo CHtml::label("Район / місто / район міста","KOATUUCodeL2ID");?>
            <?php echo CHtml::activeDropDownList($model, "KOATUUCodeL2ID",  KoatuuLevel2::DropDown($model->KOATUUCodeL1ID), 
                    array('class'=>'span12', 
                            'onchange'=>"PSN.KOATUUChange(this,2)"));
                     ?>
            </div>
            
        </div>
        <div class="row-fluid" <?php echo empty($model->KOATUUCodeL3ID) ? "style='display:none;'":""; ?> >
           
            <div class ="span12" >
            <?php echo CHtml::label("Місто / ПГТ / Село / район міста","KOATUUCodeL3ID");//,array('class'=>'span3'));?>
            <?php echo CHtml::activeDropDownList($model, "KOATUUCodeL3ID",  KoatuuLevel3::DropDown($model->KOATUUCodeL2ID), 
                    array('class'=>'span12', 'onchange'=>"PSN.KOATUUChange(this,3)"));
                     ?>
            </div>
            
        </div>
       
        <div class="row-fluid">
           <div class ="span2">
            <?php echo $form->label($model,'PostIndex');//,array('class'=>'span3'));?>
            <?php echo $form->textField($model,'PostIndex',array('class'=>'span12','maxlength'=>50)); ?>
            </div>
            <div class ="span3">
            <?php echo $form->labelEx($model,'StreetTypeID'); ?>
            <?php echo $form->dropDownList($model,'StreetTypeID', StreetTypes::DropDown(), array('class'=>'span12')); ?>
            </div>
            <div class ="span5">
            <?php echo $form->label($model,'Address');//,array('class'=>'span3'));?>
            <?php echo $form->textField($model,'Address',array('class'=>'span12','maxlength'=>50)); ?>
            </div>
             <div class ="span2">
            <?php echo $form->label($model,'HomeNumber');//,array('class'=>'span3'));?>
            <?php echo $form->textField($model,'HomeNumber',array('class'=>'span12','maxlength'=>50)); ?>
            </div>
        </div>
            
        <p class="help-block"><strong>Школа</strong></p>
        <hr>
        <div class="row-fluid">
            <div class ="span5">
                <?php echo Chtml::label("Закінчив школу за місцем проживання", "sameschooladdr") ?>
            </div>
            <div class ="span1">
                 <div id="togle_sameschool">
                    <?php 
                    $is_samaschooladdr = true;
                    echo CHtml::checkBox("sameschooladdr", $is_samaschooladdr);//, array("Ні", "Так"), array('class'=>'span12')); ?>
                 </div>
                 <script type="text/javascript">
                    $('#togle_sameschool').toggleButtons({
                        //width: 100,
                        label: {
                            enabled: "Так",
                            disabled: "Ні"
                        },
                        onChange: function ($el, status, e) {
                            if (status){
                                $("#scholladdr").hide()
                                PSN.updateSchools(PSN.KOATUUCode);
                            } else {
                                $("#scholladdr").show();
                                PSN.updateSchools(PSN.KOATUUSchoolCode);
                            }
                            
                        }
                    });
                 </script>      
            </div>
        </div>
        <div id="scholladdr" <?php echo $is_samaschooladdr ? "style='display:none;'":"";?> >
        <p class="help-block"><strong>Адреса школи</strong></p>
        <hr>
        <div class="row-fluid">
          
        <div class="row-fluid">
            <div class ="span12">
            <?php echo CHtml::label("Область або велике місто","KOATUUCodeL2ID");//,array('class'=>'span3'));?>
            <?php echo CHtml::dropDownList("KOATUU1", $model->KOATUUCodeL1ID, KoatuuLevel1::DropDown(), 
                    array('class'=>'span12', 
                            'onchange'=>"PSN.KOATUUSchoolChange(this,1)"));
                     ?>
            </div>
        </div>
        <div class="row-fluid" <?php echo empty($model->KOATUUCodeL2ID) ? "style='display:none;'":""; ?>>
            <div class ="span12"  > 
            <?php echo CHtml::label("Район / місто / район міста","KOATUUCodeL2ID");?>
            <?php echo CHtml::dropDownList("KOATUU2", $model->KOATUUCodeL2ID, KoatuuLevel2::DropDown($model->KOATUUCodeL1ID), 
                    array('class'=>'span12', 
                            'onchange'=>"PSN.KOATUUSchoolChange(this,2)"));
                     ?>
            </div>
            
        </div>
        <div class="row-fluid" <?php echo empty($model->KOATUUCodeL3ID) ? "style='display:none;'":""; ?> >
           
            <div class ="span12" >
            <?php echo CHtml::label("Місто / ПГТ / Село / район міста","KOATUUCodeL3ID");//,array('class'=>'span3'));?>
            <?php echo CHtml::dropDownList("KOATUU3", $model->KOATUUCodeL3ID,  KoatuuLevel3::DropDown($model->KOATUUCodeL2ID), 
                    array('class'=>'span12', 'onchange'=>"PSN.KOATUUSchoolChange(this,3)"));
                     ?>
            </div>
        </div>
        </div>
        </div>
        
        <div class="row-fluid">
        <div class ="span12">
                <?php echo $form->labelEx($model,'SchoolID'); ?>
               
                <?php echo $form->dropDownList($model,'SchoolID', Schools::DropDown(KoatuuLevel2::getKoatuuLevel2Code($model->KOATUUCodeL2ID)), array('class'=>'span12')); ?>
           
               
            
            </div>
        </div>
	
        <p class="help-block">Fields with <span class="required">*</span> are required.</p>
         <?php echo $form->errorSummary($model); ?>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>
         <script type="text/javascript">
            var PSN = PSN || {};
            PSN.schoolLink = "<?php echo CController::createUrl('directory/Schools'); ?>";
            PSN.koatuuLink = "<?php echo CController::createUrl('directory/koatuu'); ?>";
            PSN.KOATUUCode = "<?php echo $js_code =  KoatuuLevel2::getKoatuuLevel2Code($model->KOATUUCodeL2ID);?>";
            PSN.KOATUUSchoolCode = "<?php echo $js_code; ?>";
         </script>
<?php $this->endWidget(); ?>
