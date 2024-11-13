<!-- ce fichier sert à accueillir l'action transmise par l'URL en GET -->

<?php

// Controller est un namespace : permet de "use" une classe sans connaitre son emplacement physique mais juste dans quel namespace cette classe se trouve
// CinemaController est une classe = controller Cinema
// use nom_du_namespace\nom_de_la_classe  --> ce nom de namespace est choisi à la création de la classe
use Controller\CinemaController;

// on autocharge les classes du projet (syntaxe à respecter)
spl_autoload_register (function ($class_name) {
    include $class_name . '.php';
});

// $ctrlCinema est un objet de la classe CinemaController (une instanciation)
$ctrlCinema = new CinemaController();


if(isset($_GET["action"])) {
    // en fonction de l'action détectée dans l'URL via la propriété "action" on interagit avec la bonne méthode du controller
    switch ($_GET["action"]) {

        // si je détecte cette action, je fais appelle la méthode ListFilms() du controller $ctrlCinema
        case "" : $ctrlCinema->ListFilms(); break;
        // si je détecte cette action, je fais appelle la méthode ListActeurs() du controller $ctrlCinema
        case "" : $ctrlCinema->ListActeurs(); break;

        // etc

    }
}

// ici, on devra renvoyer sur une autre location, si on n'a pas récupéré d'actions


?>