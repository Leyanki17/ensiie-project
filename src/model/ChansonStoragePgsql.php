<?php

    namespace model;
    
    require_once("/var/www/html/src/Bootstrap.php");
    // require_once ("ChansonStorage.php");
    use PDO;
    
    class ChansonStoragePgsql implements ChansonStorage{
        private $bd;
        public function getBd(){   
            return $this->bd;
        }
         public function __construct($bd){
              $this->bd=$bd;
        }


        public function reinit(){
          echo "Je suis bien entre dans mon fichier cette fois";
          $this->deleteAll();
          $this->create(new \model\Chanson("Here","Lucas Graham","2019"));
        }
        public function getNumberOfElement(){
            if($this->bd){
                 $req= "SELECT COUNT(*) as nbElement  FROM chansons";
                 $statement=$this->bd->query($req);
                 $data=$statement->fetch(PDO::FETCH_OBJ);
               return $data->nbelement;
             }else{
                echo "Pas de connection à la base de donnée";
             }
        }   
      
        /**
         * Affiche la chanson qui possede l'id  passé en paramètre
         * @param String identifiant d'une chanson
         * retourne une chanson;
         */
        public function read($id){
            if($this->bd){
                $req= "SELECT * FROM chansons WHERE id= :id";
                $statement= $this->bd->prepare($req);
                $statement->bindParam(":id", $id);
                $statement->execute();
                $resultat=$statement->fetch(PDO::FETCH_OBJ);
                if($resultat !=  NULL){
                    $current= new \model\Chanson($resultat->titre, $resultat->artistes,
                    $resultat->dates,$resultat->album, $resultat->style,$resultat->link,$resultat->id_user);
                    $current->setVues($this->nbLike($resultat->id));
                    return $current;
                }
            }
            return null;

        }
        /**
         * Permert de creer une chanson dans notre base;
         * @param Chanson  à ajouter dans notre base
         */
        public function create(Chanson $a){
            if($this->bd){
                $id = $this->getNumberOfElement()+1;
                $req= "INSERT INTO chansons (titre,album,dates,style, link, artistes
                 ,id_user) VALUES(:titre,:album,
                :dates, :style , :link, :artistes,:id_user) RETURNING id";
                $statement=$this->bd->prepare($req);
                $statement->bindValue(':titre', $a->getTitre());
                $statement->bindValue(':artistes' ,$a->getArtistes());
                $statement->bindValue(':album',$a->getAlbum());
                $statement->bindValue(':dates', $a->getDates());
                $statement->bindValue(':style' ,$a->getStyle());
                $statement->bindValue(':id_user' ,$a->getUser());
                if(move_uploaded_file($a->getMusique(), "/var/www/html/public/musics/".$id.".".$a->getExt())){
                    $statement->bindValue(':link', "musics/".$id.".".$a->getExt());
                }
                if($statement->execute()){
                    return $id;
                }else{
                    return -1;
                }
            }else{
                return null;
            }

        }


        /**
         * Permert de modifier une chanson dans notre base;
         * @param Chanson Chanson à ajouter dans notre base
         */
        public function update($id,Chanson $a){
            if($this->bd && $this->exists($id)){
                $req= "UPDATE chansons set 
                 titre= :titre,
                 album= :album,
                 dates= :dates,
                 style= :style,
                 artistes= :artistes
                WHERE id=:id"  ;
                $statement=$this->bd->prepare($req);
               $statement->bindValue(':titre', $a->getTitre());
               $statement->bindValue(':artistes' ,$a->getArtistes());
               $statement->bindValue(':album',$a->getAlbum());
               $statement->bindValue(':dates', $a->getDates());
               $statement->bindValue(':style' ,$a->getStyle());
               $statement->bindValue(':id', $id);
                $statement->execute();
           }

        }


        /**
         * Permet de  supprimer la chansons ayant cet id
         * @param String chaine representant l'id de la chansons à supprimer
         */ 
        public function delete($id){
            if($this->bd && $this->exists($id)){
               $req = "DELETE FROM chansons WHERE id=:id";// AND id_user=: id_user";
               $statement= $this->bd->prepare($req);
               $statement->bindParam(":id",$id);
            //    $statement->bindParam(":id",$id);
               $statement->execute();
            }
        }
        public function deleteAll(){
            if($this->bd){
                $req = "DELETE FROM chansons ";
                $statement= $this->bd->prepare($req);
                $statement->execute();
            }
        }

        public function exists($id){
            if($this->bd){
                if($this->bd){
                    $req= "SELECT count(id) as nb FROM chansons WHERE id= :id";
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

        }

        public function isOwner($id,$id_user){
            if($this->bd){
                $req= "SELECT count(*) as nb FROM chansons WHERE id=:id AND id_user=:id_user";
                $statement= $this->bd->prepare($req);
                $statement->bindParam(":id",$id);
                $statement->bindParam(":id_user",$id_user);
                $statement->execute();
                $occurence= $statement->fetch(PDO::FETCH_OBJ);
                if($occurence->nb>0){
                        return true;
                } 
            }
            return false;
        }

        /**
         * Affiche tous les chansons
         * retourne tous les  chansons;
         */
        public function readAll(){
            if($this->bd){
                $req = "SELECT chansons.*, count(id) AS nb FROM  chansons LEFT JOIN likes on chansons.id = likes.id_chanson GROUP BY id order by nb Desc";
                $statement = $this->bd->prepare($req);
                $statement->execute();
                $data=array();
                while($resultat= $statement->fetch(PDO::FETCH_OBJ)){
                    $current= new \model\Chanson($resultat->titre, $resultat->artistes,
                    $resultat->dates,$resultat->album, $resultat->style,$resultat->link,$resultat->id_user);
                    $current->setVues($this->nbLike($resultat->id));
                    $data[$resultat->id]=$current;
              }

               if(count($data)>0){
                 return $data;  
               }    
            }

            return null;
        }

        
        /**
         * Affiche tous mes chansons
         * retourne tous mes  chansons;
         */
        public function readAllFromUser($id){
            if($this->bd){
                $req= "SELECT * FROM chansons WHERE id_user =:id_user";
                $statement = $this->bd->prepare($req);
                $statement->bindValue(':id_user', $id);
                $statement->execute();
            }  
            $data=array();
            while($resultat= $statement->fetch(PDO::FETCH_OBJ)){
                $current= new \model\Chanson($resultat->titre, $resultat->artistes,
                $resultat->dates,$resultat->album, $resultat->style,$resultat->link,$resultat->id_user);
                $current->setVues($this->nbLike($resultat->id));
                $data[$resultat->id]=$current;
            }

            if(count($data) > 0) {
                return $data;
            }

            return null;
        }

        /**
         * nombre de likes
         * retourne nombre de like d'une musique;
         */
        public function nbLike($id){
           
            if($this->bd){
                $req= "SELECT COUNT(*) as nbElement  FROM likes WHERE id_chanson=:id";
                $statement = $this->bd->prepare($req);
                $statement->bindValue(':id', $id);
                $statement->execute();
                $data=$statement->fetch(PDO::FETCH_OBJ);
                return $data->nbelement;
            }else{
                echo "Pas de connection à la base de donnée";
            }
              
        }


         /**
         * Ajout dans les liked;
         */
        public function like(\model\Likes $a){
            if($this->bd){
              if($this->alReadylike($a) <= 0){

                $req= "INSERT INTO likes(id_user
                ,id_chanson) VALUES(:id_user,:id_chanson)";
               $statement=$this->bd->prepare($req);
               $statement->bindValue(':id_chanson', $a->get_id_chanson());
               $statement->bindValue(':id_user' ,$a->get_id_user());
               return $statement->execute();  
              }else{
                  return "déja";
              }                
            }else{
                return null;
            }
        }


        public function alReadylike(\model\Likes $a){
            if($this->bd){
                $req= "SELECT count(*) as nb FROM likes WHERE id_user=:id_user AND id_chanson=:id_chanson";
                $statement=$this->bd->prepare($req);
                $statement->bindValue(':id_chanson', $a->get_id_chanson());
                $statement->bindValue(':id_user' ,$a->get_id_user());
                $statement->execute();  
                $data=$statement->fetch(PDO::FETCH_OBJ);
               return $data->nb;   
            }else{
                return null;
            }
        }

        /**
         * Ajout dans les liked;
         */
        public function dislike(\model\Likes $a){
            if($this->bd){
                if($this->alReadylike($a) > 0){
  
                  $req= "DELETE FROM likes WHERE id_user=:id_user AND id_chanson=:id_chanson";
                  $statement=$this->bd->prepare($req);
                  $statement->bindValue(':id_chanson', $a->get_id_chanson());
                  $statement->bindValue(':id_user' ,$a->get_id_user());
                  return $statement->execute();  
                }else{
                    return "déja";
                }                
              }else{
                  return null;
              }
        }

        /**
        * Affiche tous mes chansons
        * retourne tous mes  chansons;
        */
        public function readPlaylistOfUser($id){
          
            if($this->bd){
               
                $req = "SELECT * FROM (select chansons.*,likes.id_user as user, likes.id_chanson from chansons INNER join likes on chansons.id = likes.id_chanson) as ta WHERE  ta.user=:user";
                $statement = $this->bd->prepare($req);
                $statement->bindValue(':user' , $id);
                $statement->execute();
                $data=array();
                while($resultat= $statement->fetch(PDO::FETCH_OBJ)){
                    $current= new \model\Chanson($resultat->titre, $resultat->artistes,
                    $resultat->dates,$resultat->album, $resultat->style,$resultat->link,$resultat->id_user);
                    $current->setVues($this->nbLike($resultat->id));
                    $data[$resultat->id]=$current;
                }

                if(count($data)>0){
                    return $data;  
                }    
            }

            return null;
        }

    }


?>
