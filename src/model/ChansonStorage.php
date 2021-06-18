<?php

    namespace model;

    interface ChansonStorage{


           /**
         * Affiche la chanson qui possede l'id  passé en paramètre
         * @param String identifiant d'une chanson
         * retourne une chanson;
         */
        public function read($id);
        /**
         * Permert de creer une chanson dans notre base;
         * @param Chanson Chanson à ajouter dans notre base
         */
        public function create(Chanson $a);


        /**
         * Permert de modifier une chanson dans notre base;
         * @param Chanson Chanson à ajouter dans notre base
         */
        public function update($id,Chanson $a);


        /**
         * Permet de  supprimer la chanson ayant cet id
         * @param String chaine representant l'id de la chanson à supprimer
         */

         
        public function delete($id);

        public function exists($id);

        /**
         * Affiche tous les chansons
         * retourne tous les  chansons;
         */
        public function readAll();

        /**
         * Affiche tous mes chansons
         * retourne tous mes  chansons;
         */
        public function readAllFromUser($id);

        /**
         * nombre de likes
         * retourne nombre de like d'une musique;
         */
        public function nbLike($id);


        /**
         * Affiche tous mes chansons
         * retourne tous mes  chansons;
         */
        public function readPlaylistOfUser($id);


        /**
         * Ajout dans les liked;
         */
        public function like(\model\Likes $a);

        /**
         * Ajout dans les liked;
         */
        public function dislike(\model\Likes $a);
    }


?>