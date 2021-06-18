<?php
    
    namespace view;
    
    class AdminView extends PrivateView{

        public function  __construct($router,$account,$feedback){
            parent::__construct($router,$account,$feedback);
            $this->menu=$this->getMenu();
        }

        public function getMenu(){
    
        return ' 
            <ul class="nav">
              <li class="nav-item">
                <a class="nav-link" href='. $this->router->rootUrl().'><i class="fas fa-home"></i> Accueil</a>
              </li>
              <li class="nav-item">
                 <a class="nav-link" href='. $this->router->getChansonList().'>  <i class="fas fa-list"></i> Liste des Chansons</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href='. $this->router->getLikedChansonList().'><i class="fas fa-heart"></i> Mes PlayLists</a>
              </li>
              <li class="nav-item">
               <a class="nav-link" href='.$this->router->getMyChansonList().'>  <i class="fas fa-music"></i> Mes Chansons</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href='. $this->router->getChansonCreationURL().'> <i class="fas fa-plus-circle"></i> Ajout chanson</a>
              </li>
              <li class="nav-item">
             <a class="nav-link" href='. $this->router->getUserList().'>  <i class="fas fa-users"></i> Liste des User</a>
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
            $this->setTitle("Gestion de l'application ");
            $this->content= '<h3> Bienvenu(e) votre espace  <h2><em><strong>SPOTIFIIE </strong></em></h2> <h2>Mr (Mme) '.$this->account->getNom(). ',</h2></h3>
                <p>En tant que <strong> admin</strong>, vous pouvez tout faire ( consulter, ajouter, supprimer et modifier les chansons de n\'importe quel utilisateur).
                Vous pourrez également gérer les comptes des utilisateurs: suppression modification cration
                </p>
            ';  
        }
        public function makeUserListPage($data){
            $this->title= "Liste des utilisateur ";
            if($data!=null){
              $contenu=null;
              $taille= count($data);
              foreach($data as $key => $account) { 
                $contenu.='<div class="spot-card center"><h4 >' 
                .$account->getNom().' est un '. $account->getStatut().' il est connu sur le nom d\'utilisateur: '.$account->getLogin().' </h4>
                <div class="center">
                    <a class="btn btn-red" href='.$this->router->getAskDeletionUser($key).'>Supprimer</a></div>
                </div>' ;
              }
              $this->content =$contenu;
            }else{
              $this->content="<h4 center > Aucun utilisateur disponible</h4>"; 
            }
        }

        public function makedeletionUSer($id){
            $this->title= "Suppression de l\'utilisateur d'identifiant : ".$id;
            $this->content='<h3 class="center"> Confimer la suppression de l\'utilisateur d\'identifiant '.$id.'</h3><br>
              <form method="POST" class="center" action="'.$this->router->getDeletionUser($id).'">
                  <button type="submit btn btn-danger"> Supprimer l\'utilisateur </button>
              </form>
            ';
        }

        public function displaydeletionUserSuccess($id){
            $this->router->PostRedirect($this->router->getUserList(),"Suppression de l'utilsateur de compte".$id."reussi");
        }
        public function displaydeletionUserFailure($id){
            $this->router->PostRedirect( $this->router->getaskDeletionUserURL($id),"La suppression de l'utilsateur de compte".$id."a echoue");
        }
      
    }

?>