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

        private $data;
        private $errors;
        /**
         * construit un builder 
         * $data contient les informations sur l'objet à construit
         */
        public function __construct($data){
            $this->data=$data;
            $this->errors=array();
        }

        // accesseur 
        public function getData(){
            return $this->data;
        }

        public function getError(){
            return $this->errors;
        }

        public function isValid(){
            // var_dump($this->data);
            // die("ok");
            // controle sur le titre 
            if($this->data[self::TITRE_REF]==="" || strlen($this->data[self::TITRE_REF])<3){
                $this->errors[self::TITRE_REF]="Le titre ne dois pas etre vide et contenir mois de 4 charactère";
            }

            if($this->data[self::STYLE_REF]===""){
                $this->errors[self::STYLE_REF]= "Vous devez enter un style ";
            }

            if($this->data[self::ARTISTES_REF]==="" || strlen($this->data[self::ARTISTES_REF])<4){
                $this->errors[self::ARTISTES_REF]= "vous devez entrer un artiste avec au moins 4 charactère";
            }

            if(intval($this->data[self::DATE_REF])<1970 || intval($this->data[self::DATE_REF])> 2020){
                $this->errors[self::DATE_REF]= "entrer une date valide 1970-2020 ";
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
            return new \model\Chanson($titre,$artiste,$annee,$album,$style);
        }
    }


?>