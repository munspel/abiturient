<?php

/**
 * This is the model class for table "specialities".
 *
 * The followings are the available columns in table 'specialities':

 */
class Specialities extends CActiveRecord {

  public $tSPEC;
  public $cnt_requests_per_day;
  public $cnt_requests;
  public $cnt_persons_per_day;
  public $cnt_persons;
  
  public $cnt_req_budget;
  public $cnt_req_contract;
  public $cnt_req_electro;
  public $cnt_req_original;
  public $cnt_req_pv;
  public $cnt_req_pzk;
  public $cnt_req_Donetsk;
  public $cnt_req_Lugansk;
  public $cnt_req_Crimea;
  
  public $cnt_requests_from_us;
  public $cnt_requests_from_aliens;
  public $cnt_grad;
  
  public $modes;
  public $statuses;



  public static function model($className = __CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'specialities';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
        array('idSpeciality', 'required'),
        array('idSpeciality, FacultetID, SpecialityBudgetCount, 
                              SpecialityContractCount, isZaoch, isPublishIn', 'numerical', 'integerOnly' => true),
        array('SpecialityName', 'length', 'max' => 100),
        array('SpecialityKode', 'length', 'max' => 40),
        array('SpecialityClasifierCode', 'length', 'max' => 12),
        array("WordPrice, StudyPeriodID", "safe"),
        array("YearPrice, SemPrice", 'numerical', 'integerOnly' => false),
        // The following rule is used by search().
        // Please remove those attributes that should not be searched.
        array('idSpeciality, SpecialityName, SpecialityKode, 
                            FacultetID, SpecialityClasifierCode, SpecialityBudgetCount, SpecialityContractCount, isZaoch, isPublishIn, 
                            WordPrice, YearPrice', 'safe', 'on' => 'search'),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array(
        'personsepcialities' => array(self::HAS_MANY, 'Personspeciality', 'SepcialityID'),
        'facultet' => array(self::BELONGS_TO, 'Facultets', 'FacultetID'),
        'eduform' => array(self::BELONGS_TO, 'Personeducationforms', 'PersonEducationFormID'),
        'specquotes' => array(self::HAS_MANY, 'Specialityquotes', 'SpecialityID'),
        'quotas' => array(self::HAS_MANY, 'Quota', 'QuotaID', 'through' => 'specquotes'),
        'basespecrel' => array(self::HAS_MANY, 'BasespecialityRelation', 'SpecialityID'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
        'idSpeciality' => 'Id Speciality',
        'SpecialityName' => 'Спеціальність',
        'SpecialityKode' => 'Speciality Kode',
        'FacultetID' => 'Facultet',
        'SpecialityClasifierCode' => 'Speciality Clasifier Code',
        'SpecialityBudgetCount' => 'Speciality Budget Count',
        'SpecialityContractCount' => 'Speciality Contract Count',
        'isZaoch' => 'Is Zaoch',
        'isPublishIn' => 'Is Publish In',
        'WordPrice' => "Загальна вартість прописом",
        'YearPrice' => "Загальна вартість",
        'SemPrice' => "Ціна за семестр",
        "PersonEducationFormID" => "Форма освіти",
        "StudyPeriodID" => "Період",
        "modes" => "Вивести кількість заявок абітурієнтів :",
        "statuses" => "Статуси заявок абітурієнтів :",
    );
  }

  /**
   * Retrieves a list of models based on the current search/filter conditions.
   * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
   */
  public function search() {
    // Warning: Please modify the following code to remove attributes that
    // should not be searched.

    $criteria = new CDbCriteria;

    $criteria->compare('idSpeciality', $this->idSpeciality);
    $criteria->compare('SpecialityName', $this->SpecialityName, true);
    $criteria->compare('SpecialityKode', $this->SpecialityKode, true);
    $criteria->compare('FacultetID', $this->FacultetID);
    $criteria->compare('SpecialityClasifierCode', $this->SpecialityClasifierCode, true);
    $criteria->compare('SpecialityBudgetCount', $this->SpecialityBudgetCount);
    $criteria->compare('SpecialityContractCount', $this->SpecialityContractCount);
    $criteria->compare('isZaoch', $this->isZaoch);
    $criteria->compare('isPublishIn', $this->isPublishIn);

    return new CActiveDataProvider($this, array(
        'criteria' => $criteria,
    ));
  }
}
