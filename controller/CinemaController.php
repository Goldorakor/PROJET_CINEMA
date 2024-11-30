<?php

// on choisit comme nom de namespace le nom Controller (c'est le nom du namespace où la classe CinemaController est rangée)
namespace Controller;

// on use la classe Connect qui est rangée dans Model (dans le namespace)
use Model\Connect;

class CinemaController {

    /*
    * accéder à la page d'accueil
    */
    
    public function home() {
        require "view/home.php";
    }

    
    /*
    * lister les films
    */

    public function listFilms () {

        $pdo = Connect::seConnecter();

        // on peut poser $sql1 = "SELECT titre, annee_sortie FROM film" -> présentation plus propre
        $sql1 = "
            SELECT film.idFilm, film.titre, DATE_FORMAT(film.dateSortie, '%Y') AS anneeSortie
            FROM film
            ORDER BY dateSortie DESC
        ";


        $requete = $pdo->query($sql1);

        // on relie par un "require" la vue qui nous intéresse (située dans le dossier "view")
        require "view/listeFilms.php";
    }

    
    /*
    * lister les acteurs
    */

    public function listActeurs () {

        $pdo = Connect::seConnecter();

        $sql2 = "
            SELECT acteur.idActeur, personne.idPersonne, personne.prenom, UPPER(personne.nom) AS nom
            FROM personne
            INNER JOIN acteur ON personne.idPersonne = acteur.idPersonne
            ORDER BY nom
        ";


        $requete = $pdo->query($sql2);

        // on relie par un "require" la vue qui nous intéresse (située dans le dossier "view")
        require "view/listeActeurs.php";
    }

    
    /*
    * lister les réalisateurs
    */

    public function listRealisateurs () {

        $pdo = Connect::seConnecter();

        $sql3 = "
            SELECT realisateur.idRealisateur, personne.idPersonne, personne.prenom, UPPER(personne.nom) AS nom
            FROM personne
            INNER JOIN realisateur ON personne.idPersonne = realisateur.idPersonne
            ORDER BY nom
        ";

        // prépare et exécute une requête SQL en un seul appel de fonction
        $requete = $pdo->query($sql3);

        // on relie par un "require" la vue qui nous intéresse (située dans le dossier "view")
        require "view/listeRealisateurs.php";
    }

    
    /*
    * détailler un film
    */

    // public function detailsFilm ($blabla) -> dans index, on appelera cette méthode, en lui donnant l'attribut $idFilmChoisi à la place de $blabla
    // -> je dis une bêtise : dans l'index, à chaque cas, on appelle une méthode correspondante ... on étudie le cas général, sans se soucier de quels attributs on appliquera à nos méthodes
    public function detailsFilm ($idFilmChoisi) {

        //vérification de l'id du film
        if (!isset($_GET['id'])) {
            die("erreur : l'id du film est manquant");
        }

        $pdo = Connect::seConnecter();
    
        // on récupère l'id du film choisi dans la liste de films
        // $idFilmChoisi = $_GET['id']; -> syntaxe classique que j'utilise
        $idFilmChoisi = (isset($_GET['id'])) ? $_GET['id'] : null;  // syntaxe du formateur


        $sql4 = "
            SELECT film.idRealisateur, film.idFilm, film.titre, film.synopsis, film.duree, film.note,  DATE_FORMAT(film.dateSortie, '%Y') AS anneeSortie, personne.prenom, UPPER(personne.nom) AS nom
            FROM film
            INNER JOIN realisateur ON film.idRealisateur = realisateur.idRealisateur
            INNER JOIN personne ON realisateur.idPersonne = personne.idPersonne
            WHERE film.idFilm = :id
        ";

        $requete1 = $pdo->prepare($sql4);
        $requete1->execute(["id" => $idFilmChoisi]);

        
        $sql5 = "
            SELECT acteur.idActeur, film.idFilm, UPPER(personne.nom) AS nom, personne.prenom, personne.sexe, personnage.nom AS role
            FROM casting
            INNER JOIN film ON casting.idFilm = film.idFilm
            INNER JOIN personnage ON casting.idPersonnage = personnage.idPersonnage
            INNER JOIN acteur ON casting.idActeur = acteur.idActeur
            INNER JOIN personne ON acteur.idPersonne = personne.idPersonne
            WHERE film.idFilm = :id
        ";

        $requete2 = $pdo->prepare($sql5);
        $requete2->execute(["id" => $idFilmChoisi]);

        
        // requête pour lister les genres d'un film
        $sql6 = "
            SELECT genre.libelle
            FROM classer_par_genre
            INNER JOIN genre ON classer_par_genre.idGenre = genre.idGenre
            INNER JOIN film ON classer_par_genre.idFilm = film.idFilm
            WHERE film.idFilm = :id
        ";

        $requete3 = $pdo->prepare($sql6);
        $requete3->execute(["id" => $idFilmChoisi]);

        
        // on relie par un "require" la vue qui nous intéresse (située dans le dossier "view")
        require "view/detailsFilm.php";
    }


    /*
    * détailler un acteur
    */

    public function detailsActeur ($idActeurChoisi) {

        //vérification de l'id de l'acteur
        if (!isset($_GET['id'])) {
            die("erreur : l'id de l'acteur est manquant");
        }

        $pdo = Connect::seConnecter();
    
        // on récupère l'id de l'acteur choisi dans la liste d'acteurs
        // $idActeurChoisi = $_GET['id']; -> syntaxe classique que j'utilise
        $idActeurChoisi = (isset($_GET['id'])) ? $_GET['id'] : null;  // syntaxe du formateur


        $sql7 = "
            SELECT prenom, UPPER(personne.nom) AS nom, sexe, (YEAR(NOW()) - YEAR(personne.dateNaissance)) AS ageActeur
            FROM personne
            INNER JOIN acteur ON personne.idPersonne = acteur.idPersonne
            WHERE acteur.idActeur = :id
        "; /* WHERE personne.idPersonne = :id ou WHERE acteur.idActeur = :id -> deux choix possibles */
        /* FAUX -> il faut prendre WHERE acteur.idActeur = :id et rien d'autre */

        $requete1 = $pdo->prepare($sql7);
        $requete1->execute(["id" => $idActeurChoisi]);

        
        $sql8 = "
            SELECT film.idFilm, film.titre, personnage.nom
            FROM casting
            INNER JOIN film ON casting.idFilm = film.idFilm
            INNER JOIN personnage ON casting.idPersonnage = personnage.idPersonnage
            INNER JOIN acteur ON casting.idActeur = acteur.idActeur
            WHERE acteur.idActeur = :id
        "; /* WHERE personne.idPersonne = :id ou WHERE acteur.idActeur = :id -> deux choix possibles */
        /* FAUX -> il faut prendre WHERE acteur.idActeur = :id et rien d'autre */

        $requete2 = $pdo->prepare($sql8);
        $requete2->execute(["id" => $idActeurChoisi]);

        
        // on relie par un "require" la vue qui nous intéresse (située dans le dossier "view")
        require "view/detailsActeur.php";
    }

    
    /*
    * détailler un réalisateur
    */

    public function detailsRealisateur ($idRealisateurChoisi) {

        //vérification de l'id du réalisateur
        if (!isset($_GET['id'])) {
            die("erreur : l'id du réalisateur est manquant");
        }

        $pdo = Connect::seConnecter();
    
        // on récupère l'id du réalisateur choisi dans la liste de réalisateurs
        // $idRealisateurChoisi = $_GET['id']; -> syntaxe classique que j'utilise
        $idRealisateurChoisi = (isset($_GET['id'])) ? $_GET['id'] : null;  // syntaxe du formateur


        $sql9 = "
            SELECT prenom, UPPER(personne.nom) AS nom, sexe, (YEAR(NOW()) - YEAR(personne.dateNaissance)) AS ageRealisateur
            FROM personne
            INNER JOIN realisateur ON personne.idPersonne = realisateur.idPersonne
            WHERE realisateur.idRealisateur = :id
        "; /* WHERE personne.idPersonne = :id ou WHERE realisateur.idRealisateur = :id -> deux choix possibles */

        $requete1 = $pdo->prepare($sql9);
        $requete1->execute(["id" => $idRealisateurChoisi]);


        $sql10 = "
            SELECT film.idFilm, film.titre, DATE_FORMAT(film.dateSortie, '%Y') AS anneeSortie
            FROM film
            INNER JOIN realisateur ON film.idRealisateur = realisateur.idRealisateur
            INNER JOIN personne ON realisateur.idPersonne = personne.idPersonne
            WHERE realisateur.idRealisateur = :id  
        "; /* WHERE personne.idPersonne = :id ou WHERE realisateur.idRealisateur = :id -> deux choix possibles */ 

        $requete2 = $pdo->prepare($sql10);
        $requete2->execute(["id" => $idRealisateurChoisi]);


        // on relie par un "require" la vue qui nous intéresse (située dans le dossier "view")
        require "view/detailsRealisateur.php";
    }

    /*
    * ajouter un genre dans la BDD
    */

    public function ajoutGenreBase () {
        
        if(isset($_POST['submit'])) {
            // var_dump("ok");die;
            $libelleGenreRecup = filter_input(INPUT_POST, "libelle", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if($libelleGenreRecup) {

                $pdo = Connect::seConnecter();
                
                $sql11 = "
                    INSERT INTO genre (libelle)
                    VALUES (:libelle)
                ";
                    
                $requete = $pdo->prepare($sql11);
                $requete->execute(["libelle" => $libelleGenreRecup]);
        
                // on crée une variable success, qui confirmera le bon enregistrement du produit
                $_SESSION['success'] = "Le libellé a été enregistré avec succès";
                header("Location: index.php?action=home");
    
            }
        } else {
                // on crée une variable erreur, qui avertira d'un problème à l'enregistrement du libellé
                $_SESSION['error'] = "Erreur : veuillez saisir le libellé de la table 'genre'";
                header("Location: index.php?action=home");
            }
    }

    
    
}

/* 
Si query contient des marqueurs de substitution, la requête doit être préparé et exécuté séparément en utilisant les méthodes PDO::prepare() et PDOStatement::execute(). 


1. Qu'est-ce qu'un marqueur de substitution ?

Ce sont des placeholders (ou "emplacements réservés") dans une requête SQL, utilisés pour insérer des données de manière sécurisée. Les marqueurs peuvent être :

    Positionnels : Utilisent ? comme emplacement réservé.
    Nommés : Utilisent des noms précédés d'un : (ex. :nom).

Exemple :

SELECT * FROM users WHERE username = :username AND age > ?;


2. Pourquoi les requêtes doivent être préparées et exécutées séparément ?

Quand une requête SQL contient des marqueurs de substitution, elle ne peut pas être exécutée directement avec PDO::query(). Il faut :

    Préparer la requête avec PDO::prepare() : Cela "enregistre" la requête SQL avec ses marqueurs.
    Exécuter la requête avec PDOStatement::execute() : Cela remplit les marqueurs avec des données sécurisées.


3. Pourquoi utiliser cette méthode ?

    Protection contre les injections SQL : Les requêtes préparées "échappent" automatiquement les valeurs des marqueurs.
    Lisibilité et réutilisabilité : On peut réutiliser la requête préparée plusieurs fois avec des données différentes.


4. Exemple pratique
Sans requêtes préparées (dangereux) :

$username = $_POST['username'];
$age = $_POST['age'];

$sql = "SELECT * FROM users WHERE username = '$username' AND age > $age";
$result = $pdo->query($sql); // Potentiellement vulnérable aux injections SQL

Avec requêtes préparées (sécurisé) :

$username = $_POST['username'];
$age = $_POST['age'];

$sql = "SELECT * FROM users WHERE username = :username AND age > ?";
$stmt = $pdo->prepare($sql); // Étape 1 : Préparation
$stmt->execute([':username' => $username, 1 => $age]); // Étape 2 : Exécution

// Récupération des résultats
$users = $stmt->fetchAll();


5. Résumé

    Utilise PDO::prepare() pour créer un plan de requête.
    Utilise PDOStatement::execute() pour y insérer des données.
    Cette méthode est essentielle pour la sécurité et la fiabilité des requêtes SQL.

*/

?>
