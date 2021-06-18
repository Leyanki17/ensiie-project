<?php
    namespace view;

    use model\likes;
    
    class View{
        protected $menu;
        protected $title;
        protected $content;
        protected $router;
        // private $feedback

        public function __construct($router,$feedback){
            $this->router=$router;
            $this->menu = $this->getMenu();
            $this->feedback=$feedback;
        }

        public function getMenu(){
         return ' 
          <ul class="nav">  
            <li class="nav-item">
                <a class="nav-link" href='.$this->router->rootUrl().'> Acceuil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href='.$this->router->getAproposUrl().'> A propos</a>
            </li>
            <hr style="color:white; width:80%;margin-left:auto;margin-right:auto;margin-top:15px;"/>
            <li class="nav-item container-fluid w-100 row ">
                <div class="col-6">
                   <a class="btn btn-blue " href='.$this->router->getConnexionURL().'>connexion</a>
                </div>
                <div class="col-6">
                    <a class="btn btn-green" href='.$this->router->getInscriptionURL().'>inscription</a>
                </div>
            </li>
          </ul>';
        }

        /**
        * Permet de modifier le titre de la page
        * @param $title String nouveau titre;
        */
        public function setTitle($newTitle){
          $this->title=$newTitle;
        }

        /**
        * Permet de modifier le titre de la page
        * @param $content String nouveau titre;
        */
        public function setContent($newContent){
          $this->content=$newContent;
        }
        
        public function render(){
            include("squelette.php");
           
        }

        /**
         * Page d'acceuil 
         */
        public function welcomePage(){
          $this->setTitle("acceuil");
          $this->content= '<h3> Bienvenu(e) votre espace  <h2><em><strong>SPOTIFIIE </strong></em></h2> </h3>
          <p>
            Inscrivez vous pour commencer votre aventure.
          </p>
      ';  
        
        }

        /**
         * Creer la page d'une chanson
         * @param Objet chanson en represanter
         * @param id de la chanson
         */
        public function makeChansonPage($chanson,$list, $id=null){
            $this->title= $chanson->getTitre();
            $this->content='
            <div class="">'.$chanson->getTitre().' est un musique créée par  '.$chanson->getArtistes().' Cette 
            chanson fait partie de son album '.$chanson->getAlbum().' <br />'
            .$chanson->getTitre().' est sortie officiellement en l\'an '. $chanson->getDates().' Elle chanson du style
            '.$chanson->getStyle().'<br />';
            

            $this->content.='<div><audio src ="'.$chanson->getMusique().'" controls></audio> <i class="fas fa-eye"></i> <span id="liked">'.$chanson->getVues().'</span> like(s)</div>';

      
            if($chanson->getUser() ==  $_SESSION["user"]->getId() || $_SESSION["user"]->getStatut() == "admin"){
              if( $_SESSION["user"]->getStatut() == "admin"){
                $this->content.= '<p>
                <a class="btn btn-danger " href="'.$this->router->getchansonAskDeletionUrl($id).'">Supprimer la chanson </a>
                  <a class="btn btn-warning" href="'.$this->router->getchansonAskUpdateURL($id).'">modifier  la chanson </a> 
                  <a class="btn btn-green" id ="btn-ajax" op="ajout" lien="'.$this->router->getLikeChansonURL($id).'" onClick="managePlaylist(event);">Ajouter à ma playslist </a> 
                </p></div><div id="musicID" style="display:none">'.$id.'</div>';
              }else{
                $this->content.= '<p>
                <a class="btn btn-danger " href="'.$this->router->getchansonAskDeletionUrl($id).'">Supprimer la chanson </a>
                  <a class="btn btn-warning" href="'.$this->router->getchansonAskUpdateURL($id).'">modifier  la chanson </a> 
                  <a class="btn btn-green" id ="btn-ajax" op="ajout" lien="'.$this->router->getLikeChansonURL($id).'" onClick="managePlaylist(event);">Ajouter à ma playslist </a> 
                </p></div><div id="musicID" style="display:none">'.$id.'</div>'; 
              }
            }else{
              $this->content.= '<p>
              <a class="btn btn-green" id ="btn-ajax" op="ajout" lien="'.$this->router->getLikeChansonURL($id).'" onClick="managePlaylist(event);">Ajouter à ma playslist </a> 
                </p></div><div id="musicID" style="display:none">'.$id.'</div>'; 
            } 

            
            if($list!=null){
              $contenu="";
              $taille= count($list);
                 foreach($list as $key => $chanson) { 
              
                    $contenu.='<div class="card col-3 px-0 mx-5 my-4 bg-secondary" >
                    <img class="card-img-top" src="/img/music.jpg" alt="Card image cap">
                    <div class="card-body">
                      <h5 class="card-title">'.$chanson->getTitre().'</h5>
                      <p class="card-text"> Informations <br />(Artiste,album,année de sortie):<br>'.$chanson->getArtistes().', '. $chanson->getAlbum().','.$chanson->getDates().'</p>
                      <a href="'.$this->router->getChansonUrl($key).'" class="btn btn-primary">Voir la musique</a>
                    </div></div>';  
                }
               $this->content.='<br/><br/><hr class="w-100 px-5" /><br /><br/><h4 class="center"> Suggestion des musiques</h4><br /><div class="container-fluid row mx-3">'.$contenu.'</div>';
              }else{
                  $this->content.='<br/><br/><hr class="w-100 px-5" /><br /><br/><h4 class="center"> Suggestion des musiques</h4><br/><div class="container-fluid row mx-3"> Liste Vide</div>' ;
              }


        }

        /**
         * Formulaire d'inscription
         */
        public function makeSignInFormPage(\model\AccountBuilder $account){    
          
          $nomValue= key_exists($account::NOM_REF ,$account->getData()) ? $account->getData()[$account::NOM_REF] : "";
          $loginValue= key_exists($account::LOGIN_REF,$account->getData()) ? $account->getData()[$account::LOGIN_REF] : "";
          // $statutValue= key_exists($account::STATUT_REF,$account->getData()) ? $account->getData()[$account::STATUT_REF] :"";
          $passwordValue= key_exists($account::PASSWORD_REF,$account->getData()) ? $account->getData()[$account::PASSWORD_REF] : "";

          $nomError= key_exists($account::NOM_REF,$account->getErrors()) ? $account->getErrors()[$account::NOM_REF] : "";
          $loginError= key_exists($account::LOGIN_REF,$account->getErrors()) ? $account->getErrors()[$account::LOGIN_REF] : "";
          // $statutError= key_exists($account::STATUT_REF,$account->getErrors()) ? $account->getErrors()[$account::STATUT_REF] : "";
          $passwordError= key_exists($account::PASSWORD_REF,$account->getErrors()) ? $account->getErrors()[$account::PASSWORD_REF] : "";
          $confirmPasswordError= key_exists($account::CONFIRMPASSWORD_REF,$account->getErrors()) ? $account->getErrors()[$account::CONFIRMPASSWORD_REF] : "";
          $avatarError = key_exists($account::FILE_REF,$account->getErrors()) ? $account->getErrors()[$account::FILE_REF] : "";
          $form='<form enctype="multipart/form-data" method="POST" class="formulaire" action="'.$this->router->getConfirmInscriptionURL().'">
            <div class="form-group">
              <p class="error">'. $loginError .'</p>
              <label>Login</label>
              <input class="form-control "type="text" name="'.$account::LOGIN_REF.'"  value="'.$loginValue.'" />
            </div>
            <div class="form-group">
              <p class="error">'. $nomError .'</p>
              <label>Nom</label>
              <input class="form-control "type="text" name="'.$account::NOM_REF.'" value="'.  $nomValue.'" />
            </div>
            <div class="form-group">
              <p class="error">'. $passwordError .'</p>
              <label>Password</label>
              <input class="form-control "type="password" name="'.$account::PASSWORD_REF.'"  value="'.$passwordValue.'" />
            </div>
            <div class="form-group">
              <p class="error">'. $confirmPasswordError .'</p>
              <label>confirmPassword</label>
              <input class="form-control "type="password" name="'.$account::CONFIRMPASSWORD_REF.'"value="" />
            </div>

            <div class="form-group">
            <p class="error">'. $avatarError .'</p>
              <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Envoyer le fichier :</label>
              <input name="avatar" type="file" id="fichier_a_uploader" />  
            </div>

           <div class="form-group center">
              <button type="submit" class="btn btn-blue bnt-form">inscription</button>
           </div>
           
          </form>';
          $this->title = "Inscription";
             $this->content='<h3 class="center"> Inscription</h3><br>'.$form;
        }
        /**
         * Page d'erreur 
         * @param id de la page que l'on souhaite avoir
         */
        public function makeUnknownChansonPage($idChanson){
          $this->content="<h2>404 Page Introuvable</h4> 
            La page de l'identifiant".$idChanson." ne fais pas partie des nôtres
          ";
        }

        public function makeReponseAjaxChansonPage($text){
          $this->content="<h2>404 Page Introuvable</h4> 
            La page de l'identifiant text ajax ne fais pas partie des nôtres
          ";
        }

        /**
         * Affiche la liste de chanson
         */
        public function makeListPageChanson($list){
          $this->title= "Liste de chansons";
          if($list!=null){
            $contenu=null;
            $taille= count($list);
            foreach($list as $key => $chanson) { 
              $contenu.='<div class="card col-3 px-0 mx-5 my-4 bg-secondary" >
              <img class="card-img-top" src="/img/music.jpg" alt="Card image cap">
              <div class="card-body">
                <h5 class="card-title">'.$chanson->getTitre().'</h5>
                <p class="card-text"> Informations <br />(Artiste,album,année de sortie):<br>'.$chanson->getArtistes().', '. $chanson->getAlbum().','.$chanson->getDates().'</p>
                <p><i class="fas fa-eye"></i> '.$chanson->getVues().' like(s)<p>
                <a href="'.$this->router->getChansonUrl($key).'" class="btn btn-primary">Voir la musique</a>
              </div></div>';
            }
             $this->content='<h3 class="center"> Musiques</h3><br><div class="container-fluid row mx-3">'.$contenu.'</div>';
          }else{
            $this->content="<h4 center > La liste est vide </h4>"; 
          }

        }


        /**
         * creer un formulaire d'ajout d'une chanson;
         */
        public function makeCreationFormChansonPage(\model\ChansonBuilder $chansons){

          
          $titreValue= key_exists($chansons::TITRE_REF ,$chansons->getData()) ? $chansons->getData()[$chansons::TITRE_REF] : "";
          $artisteValue= key_exists($chansons::ARTISTES_REF,$chansons->getData()) ? $chansons->getData()[$chansons::ARTISTES_REF] : "";
          $albumValue= key_exists($chansons::ALBUM_REF,$chansons->getData()) ? $chansons->getData()[$chansons::ALBUM_REF] :"";
          $styleValue= key_exists($chansons::STYLE_REF,$chansons->getData()) ? $chansons->getData()[$chansons::STYLE_REF] : "";
          $anneeValue= key_exists($chansons::DATE_REF,$chansons->getData()) ? $chansons->getData()[$chansons::DATE_REF] :"";

          $titreError= key_exists($chansons::TITRE_REF,$chansons->getErrors()) ? $chansons->getErrors()[$chansons::TITRE_REF] : "";
          $artisteError= key_exists($chansons::ARTISTES_REF,$chansons->getErrors()) ? $chansons->getErrors()[$chansons::ARTISTES_REF] : "";
          $albumError= key_exists($chansons::ALBUM_REF,$chansons->getErrors()) ? $chansons->getErrors()[$chansons::ALBUM_REF] : "";
          $styleError= key_exists($chansons::STYLE_REF,$chansons->getErrors()) ? $chansons->getErrors()[$chansons::STYLE_REF] : "";
          $anneeError= key_exists($chansons::DATE_REF,$chansons->getErrors()) ? $chansons->getErrors()[$chansons::DATE_REF] : "";
          $musicError= key_exists($chansons::FILE_REF,$chansons->getErrors()) ? $chansons->getErrors()[$chansons::FILE_REF] : "";


          $form='<form enctype="multipart/form-data" method="POST" class="formulaire" action="'.$this->router->getChansonSaveUrl().'">
            <div class="form-group">
              <p class="error">'. $titreError .'</p>
              <label>Titre</label>
              <input class="form-control "type="text" name="'.$chansons::TITRE_REF.'"  value="'.$titreValue.'" />
            </div>
            <div class="form-group">
              <p class="error">'. $artisteError .'</p>
              <label>Artiste</label>
              <input class="form-control "type="text" name="'.$chansons::ARTISTES_REF.'" value="'.  $artisteValue.'" />
            </div>
            <div class="form-group">
              <p class="error">'. $albumError .'</p>
              <label>Album</label>
              <input class="form-control "type="text" name="'.$chansons::ALBUM_REF.'"  value="'.$albumValue.'" />
            </div>
            <div class="form-group">
              <p class="error">'. $styleError .'</p>
              <label>Style</label>
              <input class="form-control "type="text" name="'.$chansons::STYLE_REF.'"  value="'.  $styleValue.'" />
            </div>
            <div class="form-group">
            <p class="error">'. $anneeError .'</p>
              <label>annee</label>
              <input class="form-control "type="text" name="'.$chansons::DATE_REF.'"  value="'.  $anneeValue.'" />
            </div>
            <div>
            <p class="error">'. $musicError .'</p>
              <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Envoyer le fichier :</label>
              <input name="'.$chansons::FILE_REF.'" type="file" id="fichier_a_uploader" />  
            </div>

           <div class="form-group center">
              <button type="submit" class="btn btn-blue bnt-form">Ajouter une nouvelle chanson</button>
           </div>
          </form>';
          $this->title = "create de la chanson";
          $this->content='<h3 class="center"> Ajouter une musique au catalogue </h3><br>'.$form;
        }

        /**
         * Redirige vers la page de la chanson qui à été bien inserer
         */
        public function displayChansonCreationSuccess($id){
          $this->router->PostRedirect($this->router->getChansonUrl($id),"Votre chanson à été bien ajouter à la liste");
        }

        /**
         * Redirige vers la page du formulaire de creation
         */
        public function displayChansonCreationFailure(){
          $this->router->PostRedirect($this->router->getChansonCreationUrl(),"Votre chansons n'est pas valide ");
        }



        
        /**
        * Creer un formulaire de modifiacation d'une chanson;
         */
        public function makeChansonUpdatePage(\model\ChansonBuilder $chansons,$id){

          $titreValue= key_exists($chansons::TITRE_REF,$chansons->getData()) ? $chansons->getData()[$chansons::TITRE_REF] : "";
          $artisteValue= key_exists($chansons::ARTISTES_REF,$chansons->getData()) ? $chansons->getData()[$chansons::ARTISTES_REF] : "";
          $albumValue= key_exists($chansons::ALBUM_REF,$chansons->getData()) ? $chansons->getData()[$chansons::ALBUM_REF] :"";
          $styleValue= key_exists($chansons::STYLE_REF,$chansons->getData()) ? $chansons->getData()[$chansons::STYLE_REF] : "";
          $anneeValue= key_exists($chansons::DATE_REF,$chansons->getData()) ? $chansons->getData()[$chansons::DATE_REF] :"";

          $titreError= key_exists($chansons::TITRE_REF,$chansons->getErrors()) ? $chansons->getErrors()[$chansons::TITRE_REF] : "";
          $artisteError= key_exists($chansons::ARTISTES_REF,$chansons->getErrors()) ? $chansons->getErrors()[$chansons::ARTISTES_REF] : "";
          $albumError= key_exists($chansons::ALBUM_REF,$chansons->getErrors()) ? $chansons->getErrors()[$chansons::ALBUM_REF] : "";
          $styleError= key_exists($chansons::STYLE_REF,$chansons->getErrors()) ? $chansons->getErrors()[$chansons::STYLE_REF] : "";
          $anneeError= key_exists($chansons::DATE_REF,$chansons->getErrors()) ? $chansons->getErrors()[$chansons::DATE_REF] : "";


          $form='<form method="POST" action="'.$this->router->getChansonUpdateUrl($id).'">
            <div class="form-group">
              <p class="error">'. $titreError .'</p>
              <label>Titre</label>
              <input class="form-control "type="text" name="'.$chansons::TITRE_REF.'"  value="'.$titreValue.'" />
            </div>
            <div class="form-group">
              <p class="error">'. $artisteError .'</p>
              <label>Artiste</label>
              <input class="form-control "type="text" name="'.$chansons::ARTISTES_REF.'" value="'.  $artisteValue.'" />
            </div>
            <div class="form-group">
              <p class="error">'. $albumError .'</p>
              <label>Album</label>
              <input class="form-control "type="text" name="'.$chansons::ALBUM_REF.'"  value="'.$albumValue.'" />
            </div>
            <div class="form-group">
              <p class="error">'. $styleError .'</p>
              <label>Style</label>
              <input class="form-control "type="text" name="'.$chansons::STYLE_REF.'"  value="'.  $styleValue.'" />
            </div>
            <div class="form-group">
            <p class="error">'. $anneeError .'</p>
              <label>annee</label>
              <input class="form-control "type="text" name="'.$chansons::DATE_REF.'" value="'.  $anneeValue.'" />
            </div>

            <div>
            <div class="form-center center">
              <button type="submit" class="btn btn-green bnt-form">Ajouter une nouvelle chansons</button>
            </div>
          </form>';
          $this->title = "modifier chanson";
          $this->content='<h3 class="center"> Modifier la chanson id: '.$id.'</h3><br>'.$form;

        }

        /**
         * Redirige vers la page de la chanson qui à été bien inserer
         */
        public function displayUpdateChansonSuccess($id){
          $this->router->PostRedirect($this->router->getChansonUrl($id),"Votre chanson à été bien modifiée ");
        }

        /**
         * Redirige vers la page du formulaire de modification
         */
        public function displayUpdateChansonFailure($id){

          $this->router->PostRedirect($this->router->getChansonAskUpdateURL($id),"Erreur lors de la modification de la chansons");
        }

        /**
         * Creer une page de suppression 
         */
        public function makeDeletionPageChanson($id){
          $this->title= "Suppression de la Chanson d'identifiant : ".$id;
          $this->content='<h3 class="center"> Confimer la suppression de la chanson d\'identifiant '.$id.'</h3><br>
            <form method="POST" class="center" action="'.$this->router->getChansonDeletionURL($id).'">
                <button type="submit btn btn-danger"> Supprimer la chanson </button>
            </form>
          ';
        }  

        public function makeApropos(){
          $this->title= "A propos";
          include ("apropos.php");
          $this->content=$apropos;
        }

        /**
         * Renvoie  vers la page d'erreur 
         */
        public function makePageUnaccessible(){
          $this->title="404 Page Introuvable";
          $this->content="<h2>404 Page Introuvable</h4> 
          le serveur n'a pas pu trouver cette page;
        ";
        }        
        /**
         * 
         */

        /**
         * Redirige vers la liste de chanson en cas de suppression 
         */
        public function displayChansonDeletionSuccess($id){
          $this->router->PostRedirect($this->router->getChansonList(),"Votre Chanson d'identifiant ".$id." à été bien supprimer");
        }

        /**
         * Redirige vers la page de suppression de la chanson en, cas d'echec de suppression
         */
        public function displayChansonDeletionFailure(){
          $this->router->PostRedirect($this->router->getChansonDeletionUrl(),"La suppression n'a pas fonctionner");
        }



        /**
         * Affiche la page de connexion 
         */
        public function  makeLoginFormPage(){
          $this->title= "Connexion ";
          $this->content='<h3 class="center"> connectez vous</h3><br>
            <form method="POST" action='.$this->router->getConfirmConnexionURL().'>
                <div class="form-group row">
                  <label class="col-2">Login</label>
                  <input class="form-control col-10" type="text" name="login">
                </div>
                <div class="form-group row">
                  <label class="col-2">Password</label>
                  <input class="form-control col-10" type="password" name="password">
                </div>
                <div class="form-group row center">
                  <button type="submit" class="btn btn-form btn-green"> connection </button>
                </div>
               
            </form>
          ';
        }
        /**
         * Redirige vers la page  en cas de success d'inscription
         */
        public function displayCreationAccountSuccess(){
          $this->router->PostRedirect($this->router->getConnexionURL(),"Felicitation votre inscription c'est bien passé");
        }
        /**
         * Redirige vers la page d'inscription en cas d'echec d'inscription
         */
        public function displayCreationAccountFailure(){
          $this->router->PostRedirect($this->router->getInscriptionURL(),"Impossible de soumettre le formulaire veuiller corriger les erreurs");
        }
        /**
         * Redirige vers la page d'acceuil de chanson en cas de connexion reussie
         */
        public function displayConnexionSuccess(){
          $this->router->PostRedirect($this->router->rootUrl(),"Vous êtes maintenant connecter vous pouver effectuer des ajouts et modifications");
        }

        /**
         * Redirige vers la page d'acceuil de chanson en cas de connexion deja effective
         */
        public function displayAlreadyConnectSuccess(){
          $this->router->PostRedirect($this->router->rootUrl(),"Vous êtes deja connecter vous pouver effectuer des ajouts et modifications");
        }

        /**
         * Redirige vers la page de connexion , cas d'echec de connexion
         */
        public function displayConnexionfailure(){
          $this->router->PostRedirect($this->router->getConnexionURL(),"Login ou mot de passe incorrect");
        }


        /**
         * Redirige vers la page d'acceuil de chanson en cas de connexion reussie
         */
        public function displayDeconnexionSuccess(){
          $this->router->PostRedirect($this->router->getConnexionURL(),"Vous êtes maintenant deconnecter");
        }

        /**
         * Redirige vers la page courante , en cas d'echec de deconnexion
         */
        public function displayDeConnexionfailure(){
          $this->router->PostRedirect(".","Echec de la deconnexion");
        }

        public function displayAccessDenied($id){
          $this->router->PostRedirect($this->router->getChansonUrl($id),"Action Impossible. Vous n'êtes pas propriétaire de cet élément donc, 
          Vous n'avez pas les droit suffisant pour le modifier ou le supprimer ");
        }

        /**
         * Permet de rediriger sur la page de connexion avec un feed back;
         * @param String correspond au feedback à renvoyer;
         */
        public function displayConnexionFeedback($feedback){
          $this->router->PostRedirect($this->router->getConnexionURL(),$feedback);
        }

        public function displayAdminPageFeedBack($feedback){
          $this->router->PostRedirect($this->router->rootUrl(),$feedback);
        }

         
    }


?>