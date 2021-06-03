<?php

    namespace view;
    
    class PrivateView extends View { 

        protected $account ;
        public function __construct($router,$account,$feedback){
            parent::__construct($router,$feedback);
            $this->account=$account;
        }

        public function getMenu(){
            return ' 
            <ul class="nav">
              <li class="nav-item">
                  <a class="nav-link" href='. $this->router->rootUrl().'> Acceuil</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href='. $this->router->getChansonList().'> Liste des chansons</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href='. $this->router->getChansonList().'> Mes playLists</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href='.$this->router->getMyChansonList().'> Mes Chansons</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href='.$this->router->getLikedChansonList().'> Mes Likes</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href='. $this->router->getChansonCreationURL().'> Ajout chanson</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href='.$this->router->getAproposUrl().'> A propos</a>
             </li>
              <li class="nav-item">
                  <a class="nav-link btn bnt-red" href='. $this->router->getDeconnexionURL().'>Deconnexion</a>
              </li>
              
            </ul>';
        }

        public function welcomePage(){
            $this->setTitle("Acceuil Privé");
            $this->content= '<h3> Bienvenu(e) votre espace Mr (Mme) '.$this->account->getNom(). ' </h3>
                <p> Vous pouvez d\'ores et déjà consulter, ajouter, supprimer et modifier les chansons</p>
            ';  
        }
    }
    
?>