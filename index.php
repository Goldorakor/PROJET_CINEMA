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

$id = (isset($_GET['id'])) ? $_GET['id'] : null;

if(isset($_GET["action"])) {
    // en fonction de l'action détectée dans l'URL via la propriété "action", on interagit avec la bonne méthode du controller.
    switch ($_GET["action"]) {

        // si je détecte cette action, j'appelle directement view/home.php -> NON !!!
        // pour uniformiser notre code, il est plus propre d'appeler la méthode home() qui est définie comme suit :
        // public function home() {require "view/home.php";}
        case "home" : $ctrlCinema->home(); break;

        // si je détecte cette action, j'appelle la méthode ListFilms() du controller $ctrlCinema
        case "listFilms" : $ctrlCinema->ListFilms(); break;
        // si je détecte cette action, j'appelle la méthode ListActeurs() du controller $ctrlCinema
        case "listActeurs" : $ctrlCinema->ListActeurs(); break;
        // si je détecte cette action, j'appelle la méthode ListRealisateurs() du controller $ctrlCinema
        case "listRealisateurs" : $ctrlCinema->ListRealisateurs(); break;

        // les vérifications sur $idFilmChoisi ont été transférées au CinemaController.php
        case "detailsFilm" : $ctrlCinema->detailsFilm($id); break;

        // les vérifications sur $idActeurChoisi ont été transférées au CinemaController.php
        case "detailsActeur" : $ctrlCinema->detailsActeur($id); break;

        // les vérifications sur $idActeurChoisi ont été transférées au CinemaController.php
        case "detailsRealisateur" : $ctrlCinema->detailsRealisateur($id); break;

        // les vérifications sur la variable $_POST['libelle'] dans la superglobale $_POST ont été transférées au CinemaController.php
        case "ajoutGenreBase" : $ctrlCinema->ajoutGenreBase(); break;




        // etc

    }
} else {
    $ctrlCinema->home();
}

// ici, on devra renvoyer sur une autre location, si on n'a pas récupéré d'actions


?>