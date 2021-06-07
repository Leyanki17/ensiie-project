<?
    namespace model;
    
    class Chanson{
        private $id;
        private $titre;
        private $artistes;
        private $dates;
        private $album;
        private $style;
        private $user;
        private $musique;
        private $ext;

        public function __construct($titre,$artistes,$dates,$album,$style,$musique,$user=null,$ext=null){
            $this->titre=$titre;
            $this->artistes=$artistes;
            $this->dates=$dates;
            $this->album=$album;
            $this->style=$style;
            $this->user=$user;
            $this->musique=$musique;
            $this->ext=$ext;
        }

        public function getId(){
            return $this->user;
        }
        public function getUser(){
            return $this->user;
        }
        public function getTitre(){
            return $this->titre;
        }
        public function getArtistes(){
            return $this->artistes;
        }
        public function getDates(){
            return $this->dates;
        }
        public function getAlbum(){
            return $this->album;
        }
        public function getStyle(){
            return $this->style;
        }

        public function getMusique(){
            return $this->musique;
        }
        public function getExt(){
            return $this->ext;
        }


        public function setId($id){
            $this->id= $id;
        }

        public function setTitre($titre){
            $this->titre= $titre;
        }
        public function setArtistes($artistes){
            $this->artistes=$artistes;
        }
        public function setDates($dates){
            $this->dates= $dates;
        }
        public function setAlbum($album){
            $this->album= $album;
        }
        public function setStyle($style){
            $this->style= $tyle;
        }
        public function setUser($user){
            $this->user=$user;
        }
        public function getArray(){
            return get_object_vars($this);
        }



    }


?>