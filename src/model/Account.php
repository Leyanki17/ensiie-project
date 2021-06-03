<?php

    namespace model;

    class Account{
        private $id;
        private $nom;
        private $login;
        private $password;
        private $statut;
        private $description;

        public function __construct($id,$nom,$login,$statut,$password,$description=""){
            $this->id=$id;
            $this->nom=$nom;
            $this->login= $login;
            $this->password=$password;
            $this->statut=$statut;
            $this->description=$description;
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
        public function getDescription(){
            return $this->description;
        }
    }
    

?>