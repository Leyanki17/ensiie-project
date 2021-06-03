<?php
    namespace model;
    
    interface AccountStorage{


           /**
         * Affiche la account qui possede l'id  passé en paramètre
         * @param String identifiant d'une account
         * retourne une account;
         */
        public function read($id);
        /**
         * Permert de creer une account dans notre base;
         * @param Account Account à ajouter dans notre base
         */
        public function create(Account $a);


        /**
         * Permert de modifier une account dans notre base;
         * @param Account Account à ajouter dans notre base
         */
        public function update($id,Account $a);


        /**
         * Permet de  supprimer la account ayant cet id
         * @param String chaine representant l'id de la account à supprimer
         */

         
        public function delete($id);

        public function exists($id);

        /**
         * Affiche tous les accounts
         * retourne tous les  accounts;
         */
        public function readAll();
    }


?>