<?php
    namespace model;
    require_once '/var/www/html/src/Bootstrap.php';
    class AccountBuilder{

        const NOM_REF ="nom";
        const LOGIN_REF= "login";
        const PASSWORD_REF= "password";
        const CONFIRMPASSWORD_REF= "confirmPass";
        const STATUT_REF ="statut";
        const FILE_REF ="avatar";
        const EXT ="ext";
        Const MAX_SIZE = 7999999;
        private $exts = array('jpg','gif','png','jpeg');
        private $data;
        private $file;
        private $errors;

        public function __construct($data,$file){
            $this->data=$data;
            $this->file =$file;
            $this->errors=array();
        }
        

        public function getData(){
            return $this->data;
        }

        public function getErrors(){
            return $this->errors;
        }
        public function setAttError($att, $val){
            $this->errors[$att]= $val;
        }
        public function isValid(){
            if($this->data[self::NOM_REF]===""  || strlen($this->data[self::NOM_REF])<4){
                $this->errors[self::NOM_REF]= "veiller entrer un nom valide ( au moins 4 charactéres)";
            }
            if($this->data[self::LOGIN_REF]==="" || strlen($this->data[self::LOGIN_REF])<4){
                $this->errors[self::LOGIN_REF]= "veiller entrer un login valide ( au moins 4 charactéres)";
            }
            if($this->data[self::PASSWORD_REF]==="" || strlen($this->data[self::PASSWORD_REF])<5){
                $this->errors[self::PASSWORD_REF]= "veiller entrer un password valide ( au moins 5 charactéres)";
            }

            if($this->data[self::PASSWORD_REF]!== $this->data[self::CONFIRMPASSWORD_REF]){
                $this->errors[self::CONFIRMPASSWORD_REF]= "Les mots de passe ne correspond pas";
            }
            
            if(key_exists(self::FILE_REF,$this->file) && $this->file[self::FILE_REF]["error"] == 0){
                
                if($this->file[self::FILE_REF]["size"] < self::MAX_SIZE){
                    $infos = pathinfo($this->file[self::FILE_REF]["name"]);
                    $ext = $infos["extension"];
                    if(in_array(strtolower($ext), $this->exts)){
                        $this->data[self::EXT] =  $ext;
                        $this->data[self::FILE_REF]= $this->file[self::FILE_REF]["tmp_name"];
                    }else{
                        $this->errors[self::FILE_REF]="L'extension n'est pas bonne"; 
                    }
                }else{
                    $this->errors[self::FILE_REF]="Taille du fichier trop grande"; 
                }
            }else{
                $this->errors[self::FILE_REF]="Vous devez uploader un fichier";
            }
            


            return count($this->errors)== 0? true :false;
        }

        public function createAccount(){
            if($this->isValid()){
                $nom= htmlspecialchars($this->data[self::NOM_REF]);
                $login=htmlspecialchars($this->data[self::LOGIN_REF]);
                $pass= password_hash($this->data["password"], PASSWORD_BCRYPT);
                return new \model\Account(0,$nom,$login,$pass, $this->data[self::FILE_REF],$this->data[self::EXT],"user");
            }
        }
    }
?>