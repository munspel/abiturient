<?php

class DocumentsController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
                        'ajaxOnly + newZno, newZnoSubject, appendZno, delZno, delZnoSubject',
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(   'newZno',
                                                    'newZnoSubject', 
                                                    'appendZno',
                                                    'delZno',
                                                    'delZnoSubject',
                                                ),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        public function actionNewZno($personid)
            {   
                $model = new Documents('ZNO');
                $model->PersonID = $personid;
                $this->renderPartial('_form',array(
                            'model'=>$model,
                            'personid'=>$personid,true,true
                ));
            }
            
        public function actionNewZnoSubject()
            {   
                $model = new Documents('ZNO');
                $subjects = array();
                $valid = true;
                if (isset($_GET["Documents"])){
                    $model->attributes = $_GET["Documents"];
                    $model->validate();
                }
                $dateget = "";
                if (isset($_GET["Documentsubject"])){
                        foreach ($_GET["Documentsubject"] as $i=>$obj){
                            $item = new Documentsubject();
                            $item->attributes = $obj;
                            $valid = $item->validate() && $valid ;
                            $subjects[] = $item;
                            $dateget = $item->DateGet;
                        }
                } 
                if ($valid) {
                    $tm = new Documentsubject();
                    $tm->DateGet = $dateget;
                    $subjects[] = $tm;
                }
                
                $this->renderPartial('_form',array(
                            'model'=>$model,
                            'subjects'=>$subjects, 
                ));
            } 
        public function actionDelZnoSubject($num)
            {   
                $model = new Documents('ZNO');
                $subjects = array();
                $valid = true;
                if (isset($_GET["Documents"])){
                    $model->attributes = $_GET["Documents"];
                    $model->validate();
                }
                
                if (isset($_GET["Documentsubject"])){
                        unset($_GET["Documentsubject"][$num]); 
                        foreach ($_GET["Documentsubject"] as $i=>$obj){
                            $item = new Documentsubject();
                            $item->attributes = $obj;
                            $valid = $item->validate() && $valid ;
                            $subjects[] = $item;
                        }
                } 
                
                $this->renderPartial('_form',array(
                            'model'=>$model,
                            'subjects'=>$subjects, 
                ));
            }     
        public function actionAppendZno(){
            $model = new Documents('ZNO');
            $model->TypeID = 4;
            $subjects = array();
            $valid = true;
            if (isset($_GET["Documents"])){
                $model->attributes = $_GET["Documents"];
                $valid  = $model->validate() && $valid;
            }

            if (isset($_GET["Documentsubject"])){
                    foreach ($_GET["Documentsubject"] as $i=>$obj){
                        $item = new Documentsubject();
                        $item->attributes = $obj;
                        $valid = $item->validate() && $valid;
                        $subjects[] = $item;
                    }
            } 
                
            if (!$valid){
                echo CJSON::encode(array("result"=>"error","data" =>
                $this->renderPartial('_form', array('model'=>$model,'subjects'=>$subjects),true)));
            } else {
                /* save all new records */
                $flag = $transaction = Yii::app()->db->getCurrentTransaction();
                if ($transaction === null)
                {
                    $transaction = Yii::app()->db->beginTransaction();
                }
                try
                {
                   if ($model->save()){
                       foreach ($subjects as $subject){
                           $subject->DocumentID = $model->idDocuments;
                           if (!$subject->save()){
                               throw new Exception("Помилка збереження даних!");
                           }
                       }
                   }
                   $transaction->commit();
                   $person = Person::model()->findByPk($model->PersonID);
                   echo CJSON::encode(array("result"=>"success","data" =>
                        $this->renderPartial("//person/tabs/_zno", array('models'=>$person->znos,'personid'=>$model->PersonID), true)
                        ));
                } catch (Exception $e) {
                    if ($flag !== null)
                    {
                        $transaction->rollback();
                       
                    }
                    echo CJSON::encode(array("result"=>"error","data" =>$e->getMessage()));
                   
                }
               
                
            };
            
        } 
        
        public function actionDelZno($documentid)
	{   
            $flag = $transaction = Yii::app()->db->getCurrentTransaction();
            if ($transaction === null)
            {
                $transaction = Yii::app()->db->beginTransaction();
            }
            try
            {
                $document = Documents::model()->findByPk($documentid);
                
                if (!empty($document)){
                    $document->delete();
                } else {
                    throw new Exception("Документ (documentID = $documentid) не знайдено!");
                }
                $personid = $document->PersonID;
                $transaction->commit();
                $person = Person::model()->findByPk($personid);
                $this->renderPartial("//person/tabs/_zno", array('models'=>$person->znos,'personid'=>$personid));
            } catch (Exception $e) {
                    if ($flag !== null)
                    {
                        $transaction->rollback();
                        
                    }
                    echo $e->getMessage();
                    if (defined('YII_DEBUG')){
                        debug($e->getMessage());
                    }
            }
	}
        

}