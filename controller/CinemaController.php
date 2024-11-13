<?php

// on choisit comme nom de namespace le nom Controller (c'est le nom du namespace où la classe CinemaController est rangée)
namespace Controller;

// on use la classe Connect qui est rangée dans Model (dans le namespace)
use Model\Connect;

class CinemaController {

    /*
    * lister les films
    */

    //
    public function listFilms () {

        $pdo = Connect::seConnecter();

        // on peut poser $sql1 = "SELECT titre, annee_sortie FROM film"
        $requete = $pdo->query("
            SELECT titre, annee_sortie
            FROM film
        ");

        // on relie par un "require" la vue qui nous intéresse (située dans le dossier "view")
        require "view/listeFilms.php";
    }
}



?>