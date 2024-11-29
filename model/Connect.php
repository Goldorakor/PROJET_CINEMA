<?php

// on choisit comme nom de namespace le nom Model
namespace Model;

// classe abstraite car elle n'est pas instanciée, elle est utilisée pour la méthode seConnecter()
abstract class Connect {

    // les 4 attributs de la classe Connect

    // constante qui définit le nom du serveur.
    const HOST = "localhost";
    // constante qui définit le nom de la base de données.
    const DB = "cinema_michael";
    // constante qui définit l'identifiant.
    const USER = "root";
    // constante qui définit le mot de passe ou "" s'il n'y a pas de mot de passe.
    const PASS = "";


    // la méthode de la class Connect
    // méthode statique car cette méthode se réfère à la classe plutôt qu'aux objets de cette classe
    public static function seConnecter() {
        try {
            // "\" devant PDO indique au framework que PDO est une classe native et non une classe du projet
            return new \PDO(
                "mysql:host=".self::HOST."; dbname=".self::DB."; charset=utf8", self::USER, self::PASS
            );
        } catch(\PDOException $ex) {
            return $ex->getMessage();
        }
    }

}



?>