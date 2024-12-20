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

        // si je détecte cette action, j'appelle directement view/home.php -> case "home" : require"view/home.php"; break; -> EN FAIT NON !!!
        // pour uniformiser notre code, il est plus propre d'appeler la méthode home() qui est définie comme suit :
        // public function home() {require "view/home.php";}
        case "home" : $ctrlCinema->home(); break;

        // si je détecte cette action, j'appelle la méthode ListFilms() du controller $ctrlCinema
        case "listFilms" : $ctrlCinema->ListFilms(); break;
        
        // si je détecte cette action, j'appelle la méthode ListActeurs() du controller $ctrlCinema
        case "listActeurs" : $ctrlCinema->ListActeurs(); break;
        
        // si je détecte cette action, j'appelle la méthode ListRealisateurs() du controller $ctrlCinema
        case "listRealisateurs" : $ctrlCinema->ListRealisateurs(); break;

        // si je détecte cette action, j'appelle la méthode ListGenres() du controller $ctrlCinema : ajout personnel :-)
        case "listGenres" : $ctrlCinema->ListGenres(); break;

        // les vérifications sur $idFilmChoisi ont été transférées au CinemaController.php
        case "detailsFilm" : $ctrlCinema->detailsFilm($id); break;

        // les vérifications sur $idActeurChoisi ont été transférées au CinemaController.php
        case "detailsActeur" : $ctrlCinema->detailsActeur($id); break;

        // les vérifications sur $idRealisateurChoisi ont été transférées au CinemaController.php
        case "detailsRealisateur" : $ctrlCinema->detailsRealisateur($id); break;

        // Cette méthode doit renseigner sur le nombre de films qui appartiennent au genre sélectionné et aux détails des films corespondants : ajout personnel :-)
        case "detailsGenre" : $ctrlCinema->detailsGenre($id); break;

        // les vérifications sur la variable $_POST['libelle'] dans la superglobale $_POST ont été transférées au CinemaController.php
        case "ajoutGenreBase" : $ctrlCinema->ajoutGenreBase(); break;

        // Ce cas de figure est tout à fait similaire à case "ajoutGenreBase"
        case "ajoutPersonnageBase" : $ctrlCinema->ajoutPersonnageBase(); break;

        // Ce cas de figure est différent des cas "ajoutGenreBase" et "ajoutPersonnageBase" : il faut réussir à traiter le fait qu'une personne est acteur, réalisateur ou les deux.
        // Cette méthode est donc utilisée pour ajouter une personne qui est acteur ou réalisateur ou les deux ou ni l'un ni l'autre.
        case "ajoutPersonneBase" : $ctrlCinema->ajoutPersonneBase(); break;






        // etc

    }
} else {
    $ctrlCinema->home();
}

// ici, on devra renvoyer sur une autre location, si on n'a pas récupéré d'actions


/* 

remarques intéressantes : 

!empty($variable) -> Vérifie si la variable n'est pas vide, c'est-à-dire qu'elle contient une valeur "non vide" comme une chaîne, un nombre non nul, ou un tableau non vide.

($variable) -> Vérifie si la variable est "vraie" dans un contexte booléen. Si elle contient une valeur équivalente à false (comme false, null, 0, ou une chaîne vide), la condition sera fausse.

isset($variable) -> vérifie si une variable a été définie et si elle n'est pas 'null'. Elle renvoie 'true' si la variable est définie et non 'null'. Elle renvoie 'false' si la variable n'est pas définie ou si elle est 'null'.

*/


?>
