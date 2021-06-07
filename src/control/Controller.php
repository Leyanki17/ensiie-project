<?php
    namespace control;
    require_once '/var/www/html/src/Bootstrap.php';

    // require_once("../src/model/Chanson.php");
    // require_once("../src/model/ChansonBuilder.php");
    // require_once("AuthenticationManager.php");
    
    // ajouter la securiter sur les authentication manage;
    /**
     * Va permettre de gerer les actions et d'appelé les vues
     * $view reference sur la vue 
     * $zik reference sur le model
     */
    class Controller{
        private $view;
        private $chansons;
        private $accounts;
        private $authentication;
        
        /**
         * Construit un objet controller
         * $view la vue de notre site;
         * $zik  le mode de notre du site
         */
        public function __construct($view, $chansons,$accounts){
            $this->view=$view;
            $this->chansons= $chansons;
            $this->accounts=$accounts;
            $accountList= $this->accounts->readAll();
            $this->authentication = new \control\AuthenticationManager($accountList);

        }
        /**
         * Permet la connexion d'un user
         * @param String login de l'utilisateur
         * @param String password de l'utilisateur;
         */
        public function login($data){
            $login= htmlspecialchars($data["login"]);
            $password=htmlspecialchars($data["password"]);
            if($this->authentication->checkAuth($login,$password)){
                $this->view->displayConnexionSuccess();
            }else{
                $this->view->displayConnexionfailure();
            } 
        }

        /**
         * Permet la deconnexion d'un user
         * @param String login de l'utilisateur
         * @param String password de l'utilisateur;
         */
        public function logout(){
            if($this->authentication->disconnectUser()){
                $this->view->displayDeconnexionSuccess();
            }else{
                $this->view->displayDeconnexionfailure();
            }
            
        }
        public function getView(){
            return $this->view;
        }

        /**
         * Permet  d'appeler la vue d'une chanson;
         * @param id de la chanson dont on veux obtenir la vue;
         */
        public function showInformation($id){
            $chanson=$this->chansons->read($id);
            if($chanson){
                $this->view->makeChansonPage($chanson,$id);
            }else{
            $this->view->makeUnknownChansonPage($id);
            }
        }

         /**
         * Affiche toute les chansons de la base de donnée;
         */
        public function showList(){
            $this->view->makeListPageChanson($this->chansons->readAll());
        }

        public function showMyList(){
            if(key_exists("user",$_SESSION)){
                $this->view->makeListPageChanson($this->chansons->readAllFromUser($_SESSION["user"]->getId()));
            }else{
                $this->view->displayConnexionFeedback("Vous devez vous connectez pour voir les musiques vous avez ajouté.");            
            }
            
        }

        // public function showMyLikedList(){
        //     if(key_exists("user",$_SESSION)){
        //         $this->view->makeListPageChanson($this->chansons->readAllFromUser($_SESSION["user"]->getId()));
        //     }else{
        //         $this->view->displayConnexionFeedback("Vous devez vous connectez pour voir les musiques vous avez ajouté.");            
        //     }
            
        // }

        /**
         * Permet de de sauvegarder une nouvelle chanson;
         */
        public function saveNewChanson(array $data, array $file){   
            $chansonBuilder= new \model\ChansonBuilder($data,$file);
            if($chansonBuilder->isValid()){
                $chanson= $chansonBuilder->createChanson();
                
                $chanson->setUser(intval($_SESSION["user"]->getId()));
                
                $id= $this->chansons->create($chanson);

                unset($_SESSION["currentNewChanson"]);
                $this->view->displayChansonCreationSuccess($id);
            }else{
                $_SESSION["currentNewChanson"]=$chansonBuilder;
                $this->view->displayChansonCreationFailure();
            }
        }

        /**
         * Permet d'afficher la page de suppression d'une chanson
         * prend en paramettre l'id  de la chanson
         */
        public function askChansonDeletion($id){
            if($this->chansons->exists($id)){
                if( $this->chansons->isOwner($id,$_SESSION["user"]->getId())){
                    $this->view->makeDeletionPageChanson($id);
                }else{
                    $this->view->displayAccessDenied($id);
                }           
            }else{
                $this->view->setContent("impossible d'effectuer cette action. <br />Cet element ne fais pas partie de nôtre base");
            }
          
        }

         /**
         * Supprime definitive une chanson dans la base
         * @param String id de la chanson à supprimer de la base
         */
        public function deleteChanson($id){
            if($this->chansons->exists($id)){
                $this->chansons->delete($id);
                $this->view->displayChansonDeletionSuccess($id);
            }else{
                $this->view->displayChansonDeletionFailure($id);
            }   

        } 

        /**
         * affiche le formulaire de modification
         * @param String correspond à l'id de la chanson à modifier
         */
        public function askChansonModification($id){
            if(key_exists("user",$_SESSION)){
                if( $this->chansons->isOwner($id,$_SESSION["user"]->getId())){
                    if($this->chansons->exists($id)){
                        $this->view->makeChansonUpdatePage($this->updateChansonBuilder($id),$id);
                    }
                }else{
                    $this->view->displayAccessDenied($id);
                }
            }else{
                $this->view->displayConnexionFeedback("Vous devez être connecter pour modifier des chansons");
            }
        }
        /**
         * permet de modifier une chason 
         * @param array tableau de contenant les information pour modifier 
         * @param String identifiant de la chanson à modifiert
         * 
         */
        public function updateChanson(array $data,$id){
            $chansonBuilder= new \model\ChansonBuilder($data);
            $idSessionChanson="currentUpdateChanson".$id;
            if($chansonBuilder->isValidForUpdate()){
                $this->chansons->update($id ,$chansonBuilder->createChanson());
                unset( $_SESSION[$idSessionChanson]);
                $this->view->displayUpdateChansonSuccess($id);
            }else{
                $_SESSION[$idSessionChanson]= $chansonBuilder;
                $this->view->displayUpdateChansonFailure($id);
            }   
        
        }

        /**
         * permet de modifier une chason 
         * @param array tableau de contenant les information pour modifier 
         * @param String identifiant de la chanson à modifiert
         * 
         */
        public function likeChanson($id,$idUser){    
            if($this->chansons->like($id ,$idUser)){
                return "Ajout reussi";
            }else{
                return "Ajout echec";
            }
        }



        





        /**
         * Permet de creer une chanson soit en chargeant la session soit
         * en passant un tableau en paramètre. La creation avec session 
         * est prioritaire
         * @return Chanson une chanson
         */
        public function newChanson($data= array()){
            if(key_exists("currentNewChanson", $_SESSION)){
                return $_SESSION["currentNewChanson"];
            }else{
                return new \model\ChansonBuilder($data);
            }
        }
        
        /**
         * Permet de charger une chanson soit en chargeant la session soit
         * en passant un tableau en paramètre. La creation avec session 
         * est prioritaire
         * @return Chanson une chanson
         */
        public function updateChansonBuilder($id){
            $idUpdateElt="currentUpdateChanson".$id;
            if(key_exists($idUpdateElt, $_SESSION)){
                return $_SESSION[$idUpdateElt];
            }else{
                $data=$this->chansons->read($id);
                return new \model\ChansonBuilder($data->getArray());
            }
        }
        
    }


?>
