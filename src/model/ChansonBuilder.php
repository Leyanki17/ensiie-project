<?

    namespace model;

    require_once '/var/www/html/src/Bootstrap.php';
    //constante representan les champs name des formulaires
    
    // const ANNNE_REF= "annee";

    /**
     * Permet de creer un builder pour une chanson
     * $data correspond au tableau contenant les eventuelle champs d'une chanson 
     * $errors tableau en cas d'erreur 
     */
    class ChansonBuilder{
        const ID_REF="id";
        const TITRE_REF ="titre";
        const STYLE_REF= "style";
        const DATE_REF= "dates";
        const ARTISTES_REF ="artistes";
        const ALBUM_REF="album";
        const AUTEUR_REF= "auteur";
        const FILE_REF ="musique";
        const EXT ="ext";
        Const MAX_SIZE = 7999999;
        private $exts = array('mp3','ogg','acc');

        private $data;
        private $errors;
        private $file;
        /**
         * construit un builder 
         * $data contient les informations sur l'objet à construit
         */
        public function __construct($data,$file=null){
            $this->data=$data;
            $this->errors=array();
            $this->file = $file;
        }

        // accesseur 
        public function getData(){
            return $this->data;
        }

        public function getErrors(){
            return $this->errors;
        }

        public function isValidForUpdate(){
            if($this->data[self::TITRE_REF]==="" || strlen($this->data[self::TITRE_REF])<3){
                $this->errors[self::TITRE_REF]="Le titre ne dois pas etre vide et contenir mois de 4 charactère";
            }

            if($this->data[self::STYLE_REF]===""){
                $this->errors[self::STYLE_REF]= "Vous devez enter un style ";
            }

            if($this->data[self::ARTISTES_REF]==="" || strlen($this->data[self::ARTISTES_REF])<4){
                $this->errors[self::ARTISTES_REF]= "vous devez entrer un artiste avec au moins 4 charactère";
            }

            if(intval($this->data[self::DATE_REF])> 2021){
                $this->errors[self::DATE_REF]= "entrer une année valide (inférieur à 2021). ";
            }
            return empty($this->errors) ? true :false;
        }

        public function isValid(){
            // var_dump($this->data);
            // die("ok");
            // controle sur le titre 
            $this->isValidForUpdate();

            if(key_exists(self::FILE_REF,$this->file) ){
                
                if($this->file[self::FILE_REF]["size"] < self::MAX_SIZE){
                    $infos = pathinfo($this->file[self::FILE_REF]["name"]);
                    $ext = $infos["extension"];
                    if(in_array(strtolower($ext), $this->exts)){
                        $this->data[self::EXT] =  $ext;
                        $this->data[self::FILE_REF]= $this->file[self::FILE_REF]["tmp_name"];
                    }else{
                        $this->errors[self::FILE_REF]="Le format de la fichier doit être: mp3,acc ou ogg."; 
                    }
                }else{
                    $this->errors[self::FILE_REF]="Taille du fichier trop grande"; 
                }
            }else{
                echo "<pre>";
                var_dump($this->file);
                echo "</pre>";
                die("".$this->file[self::FILE_REF]["error"]);
                $this->errors[self::FILE_REF]="Vous devez uploader un fichier";
            }

            return empty($this->errors) ? true :false;
        }


        /**
         * Permet de creer une chanson 
         */
        public function  createChanson(){  
            $titre= htmlspecialchars($this->data[self::TITRE_REF]);
            $artiste=htmlspecialchars($this->data[self::ARTISTES_REF]);
            $style= htmlspecialchars($this->data[self::STYLE_REF]);
            $album= $this->data[self::STYLE_REF]==="" ? "album inconnu" :  htmlspecialchars($this->data[self::ALBUM_REF]);
            $annee=htmlspecialchars($this->data[self::DATE_REF]);
            $link= key_exists(self::FILE_REF,$this->data) ? $this->data[self::FILE_REF] : null;
            $ext = key_exists(self::EXT, $this->data) ? $this->data[self::EXT] : null;

            return new \model\Chanson($titre,$artiste,$annee,$album,$style,$link,$_SESSION["user"]->getId(),$ext);
        }
    }


?>