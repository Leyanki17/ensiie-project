<?php
    namespace model;
    require_once '/var/www/html/src/Bootstrap.php';
    class AccountBuilder{

        const NOM_REF ="nom";
        const LOGIN_REF= "login";
        const PASSWORD_REF= "password";
        const CONFIRMPASSWORD_REF= "confirmPass";
        const STATUT_REF ="statut";
        const DESC_REF ="description";
        private $data;
        private $error;

        public function __construct($data){
            $this->data=$data;
            $this->error=array();
        }

        public function getData(){
            return $this->data;
        }

        public function getError(){
            return $this->error;
        }
        public function isValid(){
            if($this->data[self::NOM_REF]===""  || strlen($this->data[self::NOM_REF])<4){
                $this->error[self::NOM_REF]= "veiller entrer un nom valide ( au moins 4 charactéres)";
            }
            if($this->data[self::LOGIN_REF]==="" || strlen($this->data[self::LOGIN_REF])<4){
                $this->error[self::LOGIN_REF]= "veiller entrer un login valide ( au moins 4 charactéres)";
            }
            if($this->data[self::PASSWORD_REF]==="" || strlen($this->data[self::PASSWORD_REF])<5){
                $this->error[self::PASSWORD_REF]= "veiller entrer un password valide ( au moins 5 charactéres)";
            }

            if($this->data[self::PASSWORD_REF]!== $this->data[self::CONFIRMPASSWORD_REF]){
                $this->error[self::CONFIRMPASSWORD_REF]= "Les mots de passe ne correspond pas";
            }
            if($this->data[self::STATUT_REF]!=="user" && $this->data[self::STATUT_REF]!=="admin"){
                $this->error[self::STATUT_REF]="Veuiller entre un statut correct (admin ou user)";
            }
            return count($this->error)==0? true :false;
        }

        public function createAccount(){
            if($this->isValid()){
                $nom= htmlspecialchars($this->data[self::NOM_REF]);
                $login=htmlspecialchars($this->data[self::LOGIN_REF]);
                $statut= htmlspecialchars($this->data[self::STATUT_REF]);
                $pass= password_hash($this->data["password"], PASSWORD_BCRYPT);
                return new \model\Account(0,$nom,$login,$statut,$pass);
            }
        }
    }
?>