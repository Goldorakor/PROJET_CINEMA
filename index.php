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
    // en fonction de l'action détectée dans l'URL via la propriété "action", on interagit avec la bonne méthode du controller.
    switch ($_GET["action"]) {

        // si je détecte cette action, j'appelle directement view/home.php
        case "home" : require"view/home.php"; break;

        // si je détecte cette action, j'appelle la méthode ListFilms() du controller $ctrlCinema
        case "listFilms" : $ctrlCinema->ListFilms(); break;
        // si je détecte cette action, j'appelle la méthode ListActeurs() du controller $ctrlCinema
        case "listActeurs" : $ctrlCinema->ListActeurs(); break;
        // si je détecte cette action, j'appelle la méthode ListRealisateurs() du controller $ctrlCinema
        case "listRealisateurs" : $ctrlCinema->ListRealisateurs(); break;


        case "detailsFilm" : 

        //vérification de l'id du film
        if (!isset($_GET['id'])) {
            die("erreur : l'id du film est manquant");
        }
    
        // on récupère l'id du film choisi dans la liste de films
        // $idFilmChoisi = $_GET['id']; -> syntaxe classique que j'utilise
        $idFilmChoisi = (isset($_GET['id'])) ? $_GET['id'] : null;  // syntaxe du formateur

        $ctrlCinema->detailsFilm($idFilmChoisi); break;


        case "detailsActeur" : 

        //vérification de l'id de l'acteur
        if (!isset($_GET['id'])) {
            die("erreur : l'id de l'acteur est manquant");
        }
    
        // on récupère l'id de l'acteur choisi dans la liste d'acteurs
        // $idActeurChoisi = $_GET['id']; -> syntaxe classique que j'utilise
        $idActeurChoisi = (isset($_GET['id'])) ? $_GET['id'] : null;  // syntaxe du formateur

        $ctrlCinema->detailsActeur($idActeurChoisi); break;


        case "detailsRealisateur" : 

        //vérification de l'id du réalisateur
        if (!isset($_GET['id'])) {
            die("erreur : l'id du réalisateur est manquant");
        }
    
        // on récupère l'id du réalisateur choisi dans la liste de réalisateurs
        // $idRealisateurChoisi = $_GET['id']; -> syntaxe classique que j'utilise
        $idRealisateurChoisi = (isset($_GET['id'])) ? $_GET['id'] : null;  // syntaxe du formateur
        
        $ctrlCinema->detailsRealisateur($idRealisateurChoisi); break;





        // etc

    }
}

// ici, on devra renvoyer sur une autre location, si on n'a pas récupéré d'actions


?>