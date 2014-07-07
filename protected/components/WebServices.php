<?php

class WebServices {

    //static private $searchSrv = "http://10.1.22.25:8080/PersonSearch/";
    static public $MSG_EDBO_ERROR = "Відсутній доступ до сервера ЄДЕБО!";
    static public $MSG_EDBO_SEARCH_DENY = "Заборонено виконувати пошук у ЄДБО!";
    static public $MSG_EDBO_EDIT_DENY = "Заборонено виконувати синхронізацію з ЄДБО!";

    /**
     * Максимальная проолжительность запроса к сервису
     * @var integer 
     */
    static private $requestTimeout = 30;

    /**
     * Максимальная время жизни файлового кеша в минутах
     * @var integer 
     */
    static private $cachTime = 2;

    /**
     * Полукчает фото абитуриента по его коду ЭДЕБО 
     * Выполняет кеширование на указанное в настройках сервиса время
     * Устанавливает сообщение о ошибке с именем 'photomessage' 
     * return base64 string or null
     * $codeU string
     */
    public static function getPersonPhotoByCodeU($codeU) {
        if (!Yii::app()->user->checkAccess("wsAllowSearch")) {
            Yii::app()->user->setFlash("photomessage", WebServices::$MSG_EDBO_SEARCH_DENY);
        }
        $script = "getphoto.jsp?personCodeU=";
        $srv = Yii::app()->user->getEdboSearchUrl();
        
        $res = Yii::app()->cache->get($codeU);
        if ($res === false) {

            try {
                if (empty($codeU)) {
                    throw new Exception("Пусте значення кода персони!");
                }
                $ctx = stream_context_create(array('http' => array('timeout' => WebServices::$requestTimeout)));
                $res = @file_get_contents($srv. $script . $codeU, 0, $ctx);
                $tres = trim($res);

                $error = CJSON::decode($res);
                if (is_array($error) && isset($error['error'])) {
                    throw new Exception($error['error']);
                }

                if (!empty($res) && empty($tres)) {
                    throw new Exception("Фото у ЄДЕБО відсутне!");
                }

                if (empty($tres)) {
                    throw new Exception(WebServices::$MSG_EDBO_ERROR);
                }
                Yii::app()->cache->set($codeU, $res);
            } catch (Exception $ex) {
                if (defined('YII_DEBUG')) {
                    Yii::log($ex->getMessage(), CLogger::LEVEL_INFO, 'WebServices');
                }
                Yii::app()->user->setFlash("photomessage", $ex->getMessage());
                return null;
            }
        }
        return $res;
    }

    /**
     * findPerson виконуэ пошук персоны за номером та серією будь-якого докамента
     * @param string $series
     * @param string $number
     * @return string
     * @throws Exception
     */
    public static function findPerson($series, $number) {

        if (!Yii::app()->user->checkAccess("wsAllowSearch")) {
            throw new Exception(WebServices::$MSG_EDBO_SEARCH_DENY . "asdsa");
        }
        $srv = Yii::app()->user->getEdboSearchUrl() ;
        //Yii::log($srv);
        $series = trim($series);
        $number = trim($number);
        $script = "search.jsp?series=$series&number=$number";
        try {
            if (empty($series) && empty($number)) {
                throw new Exception("Відсутні параметри для пошуку111!");
            }
            $ctx = stream_context_create(array('http' => array('timeout' => WebServices::$requestTimeout)));
            $res = @file_get_contents($srv . $script, 0, $ctx);
            if ($res === false) {
                throw new Exception(WebServices::$MSG_EDBO_ERROR);
            }

            $error = CJSON::decode($res);

            if (is_array($error) && isset($error['error'])) {
                throw new Exception($error['error']);
            }
        } catch (Exception $ex) {
            if (defined('YII_DEBUG')) {
                Yii::log($ex->getMessage(), CLogger::LEVEL_INFO, 'WebServices::findPerson');
            }
            throw $ex;
        }


        return $res;
    }

    /**
     * findPersonDocumentsByCodeU
     * @param type $codeU
     * @return type
     * @throws Exception
     */
    public static function findPersonDocumentsByCodeU($codeU) {
        if (!Yii::app()->user->checkAccess("wsAllowSearch")) {
            throw new Exception(WebServices::$MSG_EDBO_SEARCH_DENY);
        }
        $script = "documents.jsp?personCodeU=$codeU";
        $codeU = trim($codeU);
        $srv = Yii::app()->user->getEdboSearchUrl();
        try {
            if (empty($codeU)) {
                throw new Exception("Пусте значення кода персони!");
            }
            $ctx = stream_context_create(array('http' => array('timeout' => WebServices::$requestTimeout)));
            $res = @file_get_contents($srv . $script, 0, $ctx);
            if ($res === false) {
                throw new Exception(WebServices::$MSG_EDBO_ERROR);
            }

            $error = CJSON::decode($res);

            if (is_array($error) && isset($error['error'])) {
                throw new Exception($error['error']);
            }
        } catch (Exception $ex) {
            if (defined('YII_DEBUG')) {
                Yii::log($ex->getMessage(), CLogger::LEVEL_INFO, 'WebServices::findPersonDocumentsByCodeU');
            }
            throw $ex;
        }


        return $res;
    }

    /**
     * findPersonContactsByCodeU
     * @param type $codeU
     * @return type
     * @throws Exception
     */
    public static function findPersonContactsByCodeU($codeU) {
        if (!Yii::app()->user->checkAccess("wsAllowSearch")) {
            throw new Exception(WebServices::$MSG_EDBO_SEARCH_DENY);
        }
        $script = "contacts.jsp?personCodeU=$codeU";
        $codeU = trim($codeU);
        $srv = Yii::app()->user->getEdboSearchUrl() ;
        try {
            if (empty($codeU)) {
                throw new Exception("Пусте значення кода персони!");
            }
            $ctx = stream_context_create(array('http' => array('timeout' => WebServices::$requestTimeout)));
            $res = @file_get_contents($srv . $script, 0, $ctx);
            if ($res === false) {
                throw new Exception(WebServices::$MSG_EDBO_ERROR);
            }

            $error = CJSON::decode($res);

            if (is_array($error) && isset($error['error'])) {
                throw new Exception($error['error']);
            }
        } catch (Exception $ex) {
            if (defined('YII_DEBUG')) {
                Yii::log($ex->getMessage(), CLogger::LEVEL_INFO, 'WebServices::findPersonContactsByCodeU');
            }
            throw $ex;
        }


        return $res;
    }

    /**
     * sendEdboRequest - отправляет запрос на добавление персоны в Edbo 
     * 
     * @return boolean - сигнализирует о возможности сохранения персоны в локальной базе
     * Если false - рекомендуется откатить транзакцию или удалить созданную персону
     */
    public function sendEdboRequest($person) {
        if (!Yii::app()->user->checkAccess("wsAllowEdit")) {
            Yii::app()->user->setFlash("message", '<h3 style="color: red;">' . WebServices::$MSG_EDBO_EDIT_DENY . '</h3>');
            return false;
        }

        $params = array(
            "personIdMySql" => $this->idPerson,
            "entrantDocumentIdMySql" => $this->getEntrantdoc()->idDocuments,
            "personalDocumentIdMySql" => $this->getPersondoc()->idDocuments
        );

        $script = "personaddedbo.jsp?personIdMySql={$person->idPerson}&entrantDocumentIdMySql={$person->getEntrantdoc()->idDocuments}&personalDocumentIdMySql={$person->getPersondoc()->idDocuments}";
        $srv = Yii::app()->user->getEdboSearchUrl();
        try {
            $ctx = stream_context_create(array('http' => array('timeout' => WebServices::$requestTimeout)));
            $res = @file_get_contents($srv . $script, 0, $ctx);
            if ($res === false) {
                throw new Exception(WebServices::$MSG_EDBO_ERROR);
            }
            $obj = (object) CJSON::decode($res);

            if ($obj->backTransaction) {
                Yii::app()->user->setFlash("message", '<h3 style="color: red;">' . $obj->message . '</h3>');
                return false;
            } else {
                Yii::app()->user->setFlash("message", '<h3 style="color: red;">' . $obj->message . '</h3>');
            }
        } catch (Exception $ex) {
            if (defined('YII_DEBUG')) {
                Yii::log($ex->getMessage(), CLogger::LEVEL_INFO, 'WebServices::findPersonContactsByCodeU');
            }
            Yii::app()->user->setFlash("message", '<h3 style="color: red;">' . $ex->getMessage() . '</h3>');
            return false;
        }

//            
        return true;
    }

}
