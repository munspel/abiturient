<?php
class WebUser extends CWebUser {
    
    public function getGroup(){
        if (!Yii::app()->user->hasState("group")){
            Yii::app()->user->setState("group","");
        }
        return Yii::app()->user->getState("group");
    }
    public function getUserModel(){
        return User::model()->findByPk($this->id);
    }
    /**
     * isPkSet - проверяет установлен ли параметр в парематрах приемной комиссии
     * @param type $attribute
     * @return boolean
     */
    public function isPkSet($attribute = null){
        $model = $this->getUserModel();
        if (empty($model->syspk)) return false;
        
        if (!empty($attribute)){
            return !empty($model->syspk->{$attribute});
        } 
        return true;
    }
     public function isShortForm(){
        $model = $this->getUserModel();
        if (empty($model->syspk)) return false;
        
        if ($model->syspk->QualificationID == 2 || $model->syspk->QualificationID == 3){
            return true;
        }
        
        return false;
    }
    public static function getPkName(){
        if (!Yii::app()->user->isGuest){
            
            $user = User::model()->findByPk(Yii::app()->user->id);
            if (!empty($user->syspk)) return $user->syspk->PkName;
        }
        return "";
    }
    public function getPrintUrl($personid, $specid){
        $model = $this->getUserModel();
        if (empty($model->syspk) || empty($model->syspk->printIP) ) throw new Exception ("Необхідно визначити адресу серверу друку документів!");
        $ip = $model->syspk->printIP;  
        return "http://".$ip.Yii::app()->params["printUrl"]."PersonID=".$personid."&PersonSpecialityID=".$specid."&iframe=true&width=1024&height=600";
    }
    public function getEdboSearchUrl(){
        $model = $this->getUserModel();
        if (empty($model->syspk) || empty($model->syspk->searchIP) ) throw new Exception ("Необхідно визначити адресу серверу для пошуку!!");
        return "http://".$model->syspk->printIP;  
    }
}
?>
