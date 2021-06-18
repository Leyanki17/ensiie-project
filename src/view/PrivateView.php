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
               <a class="nav-link" href='. $this->router->rootUrl().'> <i class="fas fa-home"></i> Accueil</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href='. $this->router->getChansonList().'><i class="fas fa-list"></i> Liste des Chansons</a>
              </li>
              <li class="nav-item">
                 <a class="nav-link" href='. $this->router->getLikedChansonList().'> <i class="fas fa-heart"></i>  Mes PlayLists</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href='.$this->router->getMyChansonList().'><i class="fas fa-music"></i> Mes Chansons</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href='. $this->router->getChansonCreationURL().'> <i class="fas fa-plus-circle"></i>  Ajout chanson</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href='.$this->router->getAproposUrl().'> A Propos</a>
             </li>

             <hr style="color:white; width:80%;margin-left:auto;margin-right:auto;margin-top:15px;"/>
              <li class="nav-item container-fluid w-100 row ">
                <div class="col-12">
                    <a class="nav-link btn bnt-red" href='. $this->router->getDeconnexionURL().'>Déconnexion</a>
                </div> 
             </li>
              
            </ul>';
        }

        public function welcomePage(){
            $this->setTitle("Accueil Privé");
            $this->content='<h3> Bienvenu(e) votre espace  <h2><em><strong>SPOTIFIIE </strong></em></h2> <h2>Mr (Mme) '.$this->account->getNom(). ',</h2></h3>
                <p> Vous pouvez d\'ores et déjà consulter, ajouter, supprimer et modifier des musiques</p>
            ';  
        }
    }
    
?>