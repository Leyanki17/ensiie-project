<?php

    namespace model;
    require_once '/var/www/html/src/Bootstrap.php';

    class Likes{
        private $id_user;
        private $id_chanson;
       

        public function __construct($id_user,$id_chanson){
            $this->id_user = $id_user;
            $this->id_chanson = $id_chanson;
        }
      
        public function get_id_user(){
            return $this->id_user;
        }
        public function get_id_chanson(){
            return $this->id_chanson;
        }
       
    }



    
