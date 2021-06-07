<?php

    namespace model;

    class Account{
        private $id;
        private $nom;
        private $login;
        private $password;
        private $statut;
        private $description;
        private $avatar;
        private $ext;

        public function __construct($id,$nom,$login,$password,$avatar,$ext=null,$statut="user",){
            $this->id=$id;
            $this->nom=$nom;
            $this->login= $login;
            $this->password=$password;
            $this->statut=$statut;
            $this->avatar=$avatar;
            // echo $avatar;
            // die("obje");
            $this->ext=$ext;

            // echo $this->ext;
            // die("obje");
        }

        

        public function getId(){
            return $this->id;
        }
        public function getNom(){
            return $this->nom;
        }

        public function getStatut(){
            return $this->statut;
        }
        public function getPassword(){
            return $this->password;
        }

        public function getLogin(){
            return $this->login;
        }
        public function getAvatar(){
            return $this->avatar;
        }
        public function getExt(){
            return $this->ext;
        }
       
    }
    

?>