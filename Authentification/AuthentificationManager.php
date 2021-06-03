<?php
    class AuthentificationManager{
        private $listeDeComptes;

        /**
         * Permet de creer un gestionnaire d'authentification
         * @param liste des comptes de la base de donné;
         */
        public function __construct($liste){
            $this->listeDeComptes= $liste;
        }

        /**
         * Permet de verifier si un user correspond au password qu'il à entrer 
         * si oui stocke le user  en session 
         * @param String login entré par l"utilisateur
         * @param String password entré par l'utilisateur 
         * @return boolean  qui precise si la connection à reussie 
         */
        public function connectUser($login,$password){
            if(!$this>isUserConnected()){
                foreach($listeDeComptes as $key => $account){
                    if($account->login===$login){
                        
                        if($password=== "1234"){
                            $_SESSION["user"]=$account;
                            return true;
                        }
                    }
                }
            }
            return false;
        }


        /**
         * Indique si un user est deja connecté
         * @return boolean 
         */
        public function isUserConnected(){
            return key_exists("user",$_SESSION);
        }
        /**
         * Renvoie le nom du user connected
         * @return String correspondant au nom de l'utilisateur 
         */
        public function getUserName(){
            if($this->isUserConnected){
                return $_SESSION["user"]["nom"];
            }
        }

        /**
         * Permet de supprimer un user
         * @return boolean en fonction de si oui ou non la deconnection a reussie
         */
        public function disconnectUser(){
            if($this->isUserConnected){
                unset($_SESSION["user"]);
                return true;
            }
            return false;
        }
    }
    

?>