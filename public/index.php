<?php


require_once "../src/Bootstrap.php";

    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    
    /**
     * Connexion à la base de donnéé 
     */
    try{
        $bd= \Db\Connection::get();
        $bd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch(PDOEXCEPTION $e){
        die($e->getMessage());
    }
    
   
    
    // instanciation de notre router
    $router= new Router();
    
// var_dump($router);
    
    // passe la base de donnée en paramétre de main
    $router->main(new \model\ChansonStoragePgsql($bd),new \model\AccountStoragePgsql($bd));
     
?>
