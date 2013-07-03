<?php

/**
 * This is the model class for table "person_speciality_view".
 *
 * The followings are the available columns in table 'person_speciality_view':
 * @property integer $idPersonSpeciality
 * @property string $CreateDate
 * @property integer $idPerson
 * @property string $Birthday
 * @property string $FIO
 * @property integer $isContract
 * @property integer $isBudget
 * @property string $SpecCodeName
 * @property integer $QualificationID
 * @property integer $CourseID
 * @property integer $RequestNumber
 * @property integer $PersonRequestNumber
 */
class PersonSpecialityView extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PersonSpecialityView the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
         public function getRequestPrefix(){
            $prefix = "";
            switch ($this->QualificationID){
                case 1:  $prefix = "Б"; break;
                case 2:  $prefix = "CМ"; break;
                case 3:  $prefix = "СМ"; break;
                case 4:  $prefix = "МС"; break;
                
            }
            
            $prefix .= $this->CourseID."-";
                
          return $prefix;
        }
        
        public function primaryKey() {
            return "idPersonSpeciality";
        }
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'person_speciality_view';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('isBudget, RequestNumber, PersonRequestNumber', 'required'),
			array('idPersonSpeciality, idPerson, isContract, isBudget, QualificationID, CourseID, RequestNumber, PersonRequestNumber', 'numerical', 'integerOnly'=>true),
			array('FIO', 'length', 'max'=>302),
			array('SpecCodeName', 'length', 'max'=>316),
			array('CreateDate, Birthday', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idPersonSpeciality, CreateDate, idPerson, Birthday, FIO, isContract, isBudget, SpecCodeName, QualificationID, CourseID, RequestNumber, PersonRequestNumber', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}
        

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
    'idPersonSpeciality' => 'Код',
    'CreateDate' => 'Дата створення',
    'idPerson' => 'Код',
    'Birthday' => 'Дата нар-ня',
    'FIO' => 'ФИО',
    'isContract' => 'Контракт',
    'isBudget' => 'Бюджет',
    'SpecCodeName' => 'Спеціальність',
    'QualificationID' => 'Qualification',
    'CourseID' => 'Курс',
    'RequestNumber' => 'Справа',
    'PersonRequestNumber' => 'Особ. справа',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
                $user = Yii::app()->user->getUserModel();
                
		$criteria=new CDbCriteria;

               
		$criteria->compare('idPersonSpeciality',$this->idPersonSpeciality);
		$criteria->compare('CreateDate',$this->CreateDate,true);
		$criteria->compare('idPerson',$this->idPerson);
		$criteria->compare('Birthday',$this->Birthday,true);
		$criteria->compare('FIO',$this->FIO,true);
		$criteria->compare('isContract',$this->isContract);
		$criteria->compare('isBudget',$this->isBudget);
		$criteria->compare('SpecCodeName',$this->SpecCodeName,true);
		$criteria->compare('QualificationID',$this->QualificationID);
		$criteria->compare('CourseID',$this->CourseID);
		$criteria->compare('RequestNumber',$this->RequestNumber);
		$criteria->compare('PersonRequestNumber',$this->PersonRequestNumber);
                if (!empty($user) && !empty($user->syspk->QualificationID)) {
                    if ($user->syspk->QualificationID > 1) {
                         $criteria->compare('QualificationID',">1");
                    } else {
                         $criteria->compare('QualificationID',$user->syspk->QualificationID);
                    }
                }
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}