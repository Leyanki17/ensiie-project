<?
    namespace model;
    require_once '/var/www/html/src/Bootstrap.php';
    use PDO;

    class AccountStoragePgsql implements AccountStorage{
        private $bd;
        public function getBd(){   
            return $this->bd;
        }
         public function __construct($bd){
              $this->bd=$bd;
        }
        public function getNumberOfElement(){
            if($this->bd){
                 $req= "SELECT COUNT(*) as nbelement  FROM users";
                 $statement=$this->bd->query($req);
                 $data=$statement->fetch(PDO::FETCH_OBJ);   
               return $data->nbelement;
             }else{
                echo "Pas de connection à la base de donnée";
             }
          } 
        
          public function isLoginAlreadyUser($log){
            if($this->bd){
                 $req= "SELECT COUNT(*) as nbelement  FROM users Where login='$log'";
                 $statement=$this->bd->query($req);
                 $data=$statement->fetch(PDO::FETCH_OBJ);   
               return $data->nbelement;
             }else{
                echo "Pas de connection à la base de donnée";
             }
          } 
      
        /**
         * Affiche la user qui possede l'id  passé en paramètre
         * @param String identifiant d'une user
         * retourne une user;
         */
        public function read($id){
            if($this->bd){
                $req= "SELECT *,count(id) as nb FROM users WHERE id= :id";
                $statement= $this->bd->prepare($req);
                $statement->bindValue(":id", $id);
                $statement->execute();
                $resultat=$statement->fetch(PDO::FETCH_OBJ);
                if($resultat->nb>0){
                    return  new \model\Account($resultat->id, $resultat->nom,
                    $resultat->login, $resultat->password,null, $resultat->statut);
                }
            }
            return null;

        }
        /**
         * Permert de creer une user dans notre base;
         * @param Account  à ajouter dans notre base
         */
        public function create(Account $a){

            if($this->bd){
                
                $id = $this->getNumberOfElement()+1;
                $req="INSERT INTO users (nom,login,statut,password,avatar) values(:nom,:login,:statut,:password,:avatar)"; 
                $statement= $this->bd->prepare($req);
                $statement->bindValue(":nom",$a->getNom());
                $statement->bindValue(":login",$a->getLogin());
                $statement->bindValue(":statut","user");
                $statement->bindValue(":password", $a->getPassword());
               if(move_uploaded_file($a->getAvatar(), "/var/www/html/public/avatars_img/".$id.".".$a->getExt())){
                $statement->bindValue(":avatar", "avatars_img/".$id.".".$a->getExt());
               }
               $statement->execute();
               return $id;
            }else{
                return null;
            }

        }


        /**
         * Permert de modifier une user dans notre base;
         * @param Account Account à ajouter dans notre base
         */
        public function update($id,Account $a){
            if($this->bd && $this->exists($id)){
                
           }

        }


        /**
         * Permet de  supprimer la users ayant cet id
         * @param String chaine representant l'id de la users à supprimer
         */ 
        public function delete($id){
            if($this->bd && $this->exists($id)){
                $req = "DELETE FROM users WHERE id=:id";
                $statement= $this->bd->prepare($req);
                $statement->bindParam(":id",$id);
                $statement->execute();
             }
        }
        public function deleteAll(){
            if($this->bd){
             
            }
        }

        public function exists($id){
            if($this->bd){
               
                $req= "SELECT count(id) as nb FROM users WHERE id= :id";
                $statement= $this->bd->prepare($req);
                $statement->bindParam(":id",$id);
                $statement->execute();
                $occurence= $statement->fetch(PDO::FETCH_OBJ);
                if($occurence->nb>0){
                        return true;
                }             
            }
            return false;

        }

        /**
         * Affiche tous les users
         * retourne tous les  users;
         */
        public function readAll(){
            if($this->bd){
                $req = "SELECT * FROM users";
                $statement = $this->bd->prepare($req);
                $statement->execute();
                $data=array();
                while($resultat= $statement->fetch(PDO::FETCH_OBJ)){
                   
                    // on met l'id de l'objet qui est dans notre se comme indice du tableau
                    $data[$resultat->id]= new \model\Account($resultat->id, $resultat->nom,
                    $resultat->login, $resultat->password,$resultat->avatar,null,$resultat->statut);
                     
                }
            
               if(count($data)>0){
                 return $data;  
               }    
            }

            return null;
        }


    }

?>
