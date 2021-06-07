<?php

    namespace control;

    require_once '/var/www/html/src/Bootstrap.php';
    // require_once("../src/model/Account.php");
    // require_once("../src/model/AccountBuilder.php");



    class ControllerAccount {
        
        private $view;
        private $accoutBd;
        
        public function __construct($view,$accountBd){
            $this->view= $view;
            $this->accountBd= $accountBd;
        }


        /**
         * Affiche toute les chansons de la base de donnée;
         */
        public function showUserList(){
            $this->view->makeUserListPage($this->accountBd->readAll());
        }
        /**
        * Inscription d'un account;
        */
        public function saveAccount(array $data, array $file){
            
            $accountBuilder= new \model\AccountBuilder($data,$file);
          
            if($accountBuilder->isValid()){
                $account = $accountBuilder->createAccount();
                if(!$this->accountBd->isLoginAlreadyUser($account->getLogin())){
                    $this->accountBd->create($account);
                    if(key_exists("newAccount", $_SESSION)){
                        unset($_SESSION["newAccount"]);
                    } 
                    $this->view->displayCreationAccountSuccess();
                }else{
                    $accountBuilder->setAttError(\model\AccountBuilder::LOGIN_REF, "Le login est déjà utilisé. Veuillez choisir un autre.");
                    $_SESSION["newAccount"]=$accountBuilder;
                    $this->view->displayCreationAccountFailure();
                }
            }else{
                $_SESSION["newAccount"]=$accountBuilder;
                $this->view->displayCreationAccountFailure();
            }
        }

        /**
         * Formulaire de modification 
         */

        public function askUpdateUser($data){

        }

         /**
         * Formulaire de suppression 
         */

        public function askDeletionUser($id){
            if($this->accountBd->exists($id)){
                $this->view->makedeletionUSer($id);
            }else{
                $this->view->setContent("impossible d'effectuer cette action. <br />Cet element ne fais pas partie de nôtre base");
            }
        }
        

        /**
         * Modification d'un utilisateur 
         */
        public function updateAccount(){

        }

        /**
         * Suppression d'un compte
        */
        public function deleteAccount($id){
            if($this->accountBd->exists($id)){
                $this->accountBd->delete($id);
                $this->view->displaydeletionUserSuccess($id);
            }else{
                $this->view->displaydeletionUserFailure($id);
            }   
        }

        /**
         * Creation d'utilisateur builder à partie  de la session si elle existe sinon à parti d'un tableau
         */
        public function newAccount($data=array(),$file=[]){
            if(key_exists("newAccount",$_SESSION)){
                return $_SESSION["newAccount"];
            }else{
                return new \model\AccountBuilder($data,$file);
            }
        }

         /**
         * Creation d'utilisateur builder pour la mofication à partie  de la session si elle existe sinon à parti d'un tableau
         */
        public function currentUpdateAccount($id){

            
        }
        


    }
    

?>