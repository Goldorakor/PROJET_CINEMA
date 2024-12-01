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
    * lister les genres
    */

    public function listGenres () {

        $pdo = Connect::seConnecter();

        $sql13 = "
            SELECT genre.idGenre, genre.libelle
            FROM genre
            ORDER BY genre.libelle
        ";

        // prépare et exécute une requête SQL en un seul appel de fonction
        $requete = $pdo->query($sql13);

        // on relie par un "require" la vue qui nous intéresse (située dans le dossier "view")
        require "view/listeGenres.php";
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
        $requete1->execute([":id" => $idFilmChoisi]);

        
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
        $requete2->execute([":id" => $idFilmChoisi]);

        
        // requête pour lister les genres d'un film
        $sql6 = "
            SELECT genre.libelle
            FROM classer_par_genre
            INNER JOIN genre ON classer_par_genre.idGenre = genre.idGenre
            INNER JOIN film ON classer_par_genre.idFilm = film.idFilm
            WHERE film.idFilm = :id
        ";

        $requete3 = $pdo->prepare($sql6);
        $requete3->execute([":id" => $idFilmChoisi]);

        
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
        $requete1->execute([":id" => $idActeurChoisi]);

        
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
        $requete2->execute([":id" => $idActeurChoisi]);

        
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
        $requete1->execute([":id" => $idRealisateurChoisi]);


        $sql10 = "
            SELECT film.idFilm, film.titre, DATE_FORMAT(film.dateSortie, '%Y') AS anneeSortie
            FROM film
            INNER JOIN realisateur ON film.idRealisateur = realisateur.idRealisateur
            INNER JOIN personne ON realisateur.idPersonne = personne.idPersonne
            WHERE realisateur.idRealisateur = :id  
        "; /* WHERE personne.idPersonne = :id ou WHERE realisateur.idRealisateur = :id -> deux choix possibles */ 

        $requete2 = $pdo->prepare($sql10);
        $requete2->execute([":id" => $idRealisateurChoisi]);


        // on relie par un "require" la vue qui nous intéresse (située dans le dossier "view")
        require "view/detailsRealisateur.php";
    }



    /*
    * détailler un genre
    */

    public function detailsGenre ($idGenreChoisi) {

        //vérification de l'id du genre
        if (!isset($_GET['id'])) {
            die("erreur : l'id du genre est manquant");
        }

        $pdo = Connect::seConnecter();
    
        // on récupère l'id du genre choisi dans la liste de genres
        // $idGenreChoisi = $_GET['id']; -> syntaxe classique que j'utilise
        $idGenreChoisi = (isset($_GET['id'])) ? $_GET['id'] : null;  // syntaxe du formateur (opérateur ternaire)


        $sql14 = "
            SELECT genre.idGenre, genre.libelle
            FROM genre
            WHERE genre.idGenre = :id
        ";

        $requete1 = $pdo->prepare($sql14);
        $requete1->execute([":id" => $idGenreChoisi]);


        $sql15 = "
            SELECT film.idFilm, realisateur.idRealisateur, film.titre, DATE_FORMAT(film.dateSortie, '%Y') AS anneeSortie, personne.prenom, UPPER(personne.nom) AS nom
            FROM film
            INNER JOIN classer_par_genre ON film.idFilm = classer_par_genre.idFilm
            INNER JOIN genre ON classer_par_genre.idGenre = genre.idGenre
            INNER JOIN realisateur ON film.idRealisateur = realisateur.idRealisateur
            INNER JOIN personne ON realisateur.idPersonne = personne.idPersonne
            WHERE genre.idGenre = :id  
        ";

        $requete2 = $pdo->prepare($sql15);
        $requete2->execute([":id" => $idGenreChoisi]);


        // on relie par un "require" la vue qui nous intéresse (située dans le dossier "view")
        require "view/detailsGenre.php";
    }


    /*
    * ajouter un genre dans la BDD
    */

    public function ajoutGenreBase () {
        
        if(isset($_POST['submit'])) {
            // var_dump("ok");die;
            // $libelleGenreRecup -> colonne 'libelle' de la table 'genre' 'recup' d'un formulaire
            $libelleGenreRecup = filter_input(INPUT_POST, "libelle", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if($libelleGenreRecup) {

                $pdo = Connect::seConnecter();
                
                $sql11 = "
                    INSERT INTO genre (libelle)
                    VALUES (:libelle)
                ";
                    
                $requete = $pdo->prepare($sql11);
                $requete->execute([":libelle" => $libelleGenreRecup]);
        
                // on crée une variable success, qui confirmera le bon enregistrement du genre
                $_SESSION['success'] = "Le libellé a été enregistré avec succès";
                header("Location: index.php?action=home");
    
            }
        } else {
                // on crée une variable erreur, qui avertira d'un problème à l'enregistrement du libellé
                $_SESSION['error'] = "Erreur : veuillez saisir le libellé de la table 'genre'";
                header("Location: index.php?action=home");
                // exit : pour arrêter immédiatement l'exécution du script PHP.
                exit;
            }
    }


    /*
    * ajouter un personnage dans la BDD
    */

    // on s'inspire entièrement de public function ajoutGenreBase ()
    public function ajoutPersonnageBase () {
        
        if(isset($_POST['submit'])) {
            // var_dump("ok");die;
            // $nomPersonnageRecup -> colonne 'nom' de la table 'personnage' 'recup' d'un formulaire
            $nomPersonnageRecup = filter_input(INPUT_POST, "nomPersonnage", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if($nomPersonnageRecup) {

                $pdo = Connect::seConnecter();
                
                $sql12 = "
                    INSERT INTO personnage (nom)
                    VALUES (:nom)
                ";
                    
                $requete = $pdo->prepare($sql12);
                $requete->execute([":nom" => $nomPersonnageRecup]);
        
                // on crée une variable success, qui confirmera le bon enregistrement du personnage
                $_SESSION['success'] = "Le nom (du personnage) a été enregistré avec succès";
                header("Location: index.php?action=home");
                // exit : pour arrêter immédiatement l'exécution du script PHP.
                exit;
    
            }
        } else {
                // on crée une variable erreur, qui avertira d'un problème à l'enregistrement du nom du personnage
                $_SESSION['error'] = "Erreur : veuillez saisir le nom (du personnage) de la table 'personnage'";
                header("Location: index.php?action=home");
                // exit : pour arrêter immédiatement l'exécution du script PHP.
                exit;
            }
    }


    /*
    * ajouter une personne dans la BDD
    */

    // on s'inspire en partie de public function ajoutGenreBase ()
    // mon idée : des cases à cocher dans le formulaire pour savoir si la personne est :
        // acteur : on doit injecter son idPersonne dans la table 'acteur' 
        // réalisateur : on doit injecter son idPersonne dans la table 'realisateur' 
        // les deux : on doit injecter son idPersonne dans la table 'acteur' et dans la table 'realisateur'
        // rien du tout : on n'injecte rien du tout -> cas un peu idiot puisque cette personne n'a pas d'intérêt à être dans notre BDD
    public function ajoutPersonneBase () {
        
        if(isset($_POST['submit'])) {
            // var_dump("ok");die;
            // $nomPersonnageRecup -> colonne 'nom' de la table 'personnage' 'recup' d'un formulaire
            // INPUT_POST, "nomPersonne" -> récupère la valeur envoyée via une requête HTTP POST avec le champ 'nomPersonne'.
            $nomPersonneRecup = filter_input(INPUT_POST, "nomPersonne", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $prenomPersonneRecup = filter_input(INPUT_POST, "prenomPersonne", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // $sexePersonneRecup = filter_input(INPUT_POST, "sexePersonne", FILTER_SANITIZE_STRING); -> déprécié !
            $sexePersonneRecup = filter_input(INPUT_POST, 'sexePersonne');
            $sexePersonneRecup = htmlspecialchars($sexePersonneRecup, ENT_QUOTES, 'UTF-8');

            // $dateNaissancePersonneRecup = filter_input(INPUT_POST, "dateNaissancePersonne", FILTER_SANITIZE_STRING); -> déprécié
            $dateNaissancePersonneRecup = filter_input(INPUT_POST, 'dateNaissancePersonne');
            $dateNaissancePersonneRecup = htmlspecialchars($dateNaissancePersonneRecup, ENT_QUOTES, 'UTF-8');


            // Récupération des valeurs des checkboxes
            // $acteur = filter_input(INPUT_POST, 'acteur', FILTER_SANITIZE_STRING); -> déprécié
            $acteur = isset($_POST['acteur']) ? 1 : 0; // 1 si cochée, sinon 0
            

            // $realisateur = filter_input(INPUT_POST, 'realisateur', FILTER_SANITIZE_STRING); -> déprécié
            $realisateur = isset($_POST['realisateur']) ? 1 : 0; // 1 si cochée, sinon 0 


            // FILTER_SANITIZE_FULL_SPECIAL_CHARS : nettoie la chaîne en convertissant les caractères spéciaux (comme <, >, &) en entités HTML pour éviter des attaques XSS (Cross-Site Scripting). Exemple : <script> devient &lt;script&gt;.
            // FILTER_SANITIZE_STRING : supprime les caractères indésirables (par exemple, les balises HTML, certains caractères spéciaux). Cela nettoie la chaîne brute avant de l'analyser. -> déprécié

            // pour le filtre concernant la date de naissance , merci de lire le commentaire 'Filtre date de naissance' tout en bas de page.

            // on valide la date de naissance -> explications des fonctions en bas de page
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateNaissancePersonneRecup)) {
                $dateParts = explode('-', $dateNaissancePersonneRecup);
                if (checkdate($dateParts[1], $dateParts[2], $dateParts[0])) {

     
                    // Validation des autres champs
                    if (($sexePersonneRecup === 'Homme' || $sexePersonneRecup === 'Femme') AND (!empty($nomPersonneRecup) AND !empty($prenomPersonneRecup))) {
                        

                        $pdo = Connect::seConnecter();
                            
                        $sql15 = "
                            INSERT INTO personne (nom, prenom, sexe, dateNaissance)
                            VALUES (:nom, :prenom, :sexe, :dateNaissance )
                        ";
                                
                        $requete = $pdo->prepare($sql15);
                        $requete->execute([":nom" => $nomPersonneRecup, ":prenom" => $prenomPersonneRecup, ":sexe" => $sexePersonneRecup, ":dateNaissance" => $dateNaissancePersonneRecup]);
                    

                        // Récupération de l'idPersonne généré
                        $idPersonne = $pdo->lastInsertId();

                        // 
                        if ($idPersonne) {
                            
        
                            // Si $acteur est défini, cela signifie que la checkbox "acteur" a été cochée.
                            if ($acteur) {

                                // requête pour ajouter un acteur à la table 'acteur'
                                $sql30 = "
                                    INSERT INTO acteur (idPersonne)
                                    VALUES (:idPersonne)
                                ";

                                // Requête pour le cas où la checkbox "acteur" est cochée
                                $stmt = $pdo->prepare($sql30);
                                $stmt->execute([':idPersonne' => $idPersonne]);
                            }

                            // Si $realisateur est défini, cela signifie que la checkbox "réalisateur" a été cochée.
                            if ($realisateur) {


                                // requête pour ajouter un réalisateur à la table 'realisateur'
                                $sql31 = "
                                    INSERT INTO realisateur (idPersonne)
                                    VALUES (:idPersonne)
                                ";


                                // Requête pour le cas où la checkbox "réalisateur" est cochée
                                $stmt = $pdo->prepare($sql31);
                                $stmt->execute([':idPersonne' => $idPersonne]);
                            }

                        }


                        // Confirmation de l'enregistrement
                        $_SESSION['success'] = "La personne a été ajoutée avec succès.";
                        header("Location: index.php?action=home");
                        // exit : pour arrêter immédiatement l'exécution du script PHP.
                        exit;      
                        
                    }

                }

            } 

            // on crée une variable erreur, qui avertira d'un problème à l'enregistrement de la personne
            $_SESSION['error'] = "Erreur : veuillez saisir les informations de manière correcte";
            header("Location: index.php?action=home");
            // exit : pour arrêter immédiatement l'exécution du script PHP.
            exit;

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



/* 
fonction preg_match() en PHP
preg_match est une fonction PHP qui permet de vérifier si une chaîne de caractères correspond à un modèle (ou pattern) défini par une expression régulière (regex).

syntaxe de preg_match()
int preg_match ( string $pattern , string $subject [, array &$matches [, int $flags [, int $offset ]]] )
-> $pattern : l'expression régulière qu'on veut utiliser pour décrire ce que tu cherches. Elle doit être encadrée par des délimiteurs (souvent /). Exemple : /^\d{4}-\d{2}-\d{2}$/
-> $subject : la chaîne qu'on veut vérifier.
-> $matches (optionnel), $flags (optionnel), $offset (optionnel)

Retourne quoi ? : 1 si une correspondance est trouvée. 0 si aucune correspondance n'est trouvée. false en cas d'erreur.

exemple : vérification d'une date au format YYYY-MM-DD
$date = "1978-12-03";
$pattern = '/^\d{4}-\d{2}-\d{2}$/'; // Regex pour le format YYYY-MM-DD

if (preg_match($pattern, $date)) {
    echo "Date valide au format YYYY-MM-DD.";
} else {
    echo "Format incorrect.";
}

Décryptage de la regex /^\d{4}-\d{2}-\d{2}$/ : (les regex doivent être entourées de délimiteurs ('/' ou autres comme '#'). exemple correct : /pattern/.)
-> ^ : Début de la chaîne.
-> \d{4} : Exactement 4 chiffres (l'année).
-> - : Un tiret littéral.
-> \d{2} : Exactement 2 chiffres (le mois ou le jour).
-> $ : Fin de la chaîne.

Exemple 2 : Extraire une partie de la chaîne. (si tu veux récupérer des parties spécifiques de la chaîne, utilise l'argument $matches) :

$email = "john.doe@example.com";
$pattern = '/^([\w\.]+)@([\w\.]+)\.([a-z]{2,})$/'; // Regex pour valider une adresse email

if (preg_match($pattern, $email, $matches)) {
    echo "Email valide : $email\n";
    print_r($matches); // Affiche les parties de l'email
}

Résultat de $matches :
Array
(
    [0] => john.doe@example.com   // La chaîne complète qui matche
    [1] => john.doe              // Le nom d'utilisateur (avant le @)
    [2] => example               // Le domaine (avant le .)
    [3] => com                   // L'extension (après le .)
)

Quand utiliser preg_match ?
-> Validation : vérifier que les données correspondent à un format précis (exemple : date, email, numéro de téléphone).
-> Extraction : récupérer des parties spécifiques d'une chaîne.
*/



/* 
fonction explode() en PHP :
fonction PHP qui permet de diviser une chaîne de caractères en plusieurs morceaux en se basant sur un délimiteur. Elle retourne un tableau contenant ces morceaux.

syntaxe de explode()
array explode ( string $separator , string $string [, int $limit ] )
-> $separator : le délimiteur utilisé pour diviser la chaîne (exemple : une virgule ',', un espace ' ', un point-virgule ';' ...).
-> $string : la chaîne qu'on veut découper.
-> $limit (optionnel) : nombre maximum de morceaux à retourner. Si spécifié, le dernier élément du tableau contient le reste de la chaîne, même si le délimiteur est encore présent.

exemple :
$liste = "pomme,banane,cerise";
$fruits = explode(",", $liste);

print_r($fruits);

résultats :
Array
[
    [0] => "pomme",
    [1] => "banane",
    [2] => "cerise",
]

exemple :
$phrase = "PHP est puissant mais parfois complexe";
$morceaux = explode(" ", $phrase, 3);

print_r($morceaux);

résultats :
Array
[
    [0] => "PHP",
    [1] => "est",
    [2] => "puissant mais parfois complexe",
]
*/



/*  
fonction checkdate() en PHP
La fonction checkdate en PHP est utilisée pour vérifier si une date est valide. Elle est pratique pour s'assurer qu'une combinaison de jour, mois et année correspond à une date réelle du calendrier.

syntaxe de checkdate()
checkdate(int $month, int $day, int $year): bool -> attention à l'ordre des éléments : mois, jour, année

Paramètres : $month : un entier représentant le mois (1 à 12). $day : un entier représentant le jour du mois. $year : un entier représentant l'année (doit être un nombre compris entre 1 et 32767).

Valeur retournée : Renvoie true si la date est valide. Renvoie false si la date n'est pas valide.

Exemple 1 : Date valide
if (checkdate(12, 25, 2024)) {
    echo "La date est valide.";
} else {
    echo "La date est invalide.";
}
// Résultat : La date est valide.

Exemple 2 : Date invalide
if (checkdate(2, 30, 2023)) {
    echo "La date est valide.";
} else {
    echo "La date est invalide.";
}
// Résultat : La date est invalide (février n'a pas 30 jours).

Exemple 3 : Année bissextile
if (checkdate(2, 29, 2024)) {
    echo "La date est valide.";
} else {
    echo "La date est invalide.";
}
// Résultat : La date est valide (2024 est une année bissextile).

Exemple 4 : Année hors plage
if (checkdate(12, 25, -2023)) {
    echo "La date est valide.";
} else {
    echo "La date est invalide.";
}
// Résultat : La date est invalide (l'année doit être positive).

Utilité principale : 
-> Validation de formulaires : si tu récupères une date de naissance, une date d'événement ou toute autre date via un formulaire, tu peux utiliser checkdate pour vérifier qu'elle est valide.
-> Sécurité : empêche les erreurs ou les bugs dus à des dates impossibles (comme le 31 février).
-> Précision : gère automatiquement les spécificités du calendrier, comme les années bissextiles.

Cas d'utilisation dans un formulaire : (Supposons qu'un utilisateur saisisse une date via un formulaire)
$day = $_POST['day'];    // Exemple : 31
$month = $_POST['month']; // Exemple : 2
$year = $_POST['year'];  // Exemple : 2024

if (checkdate($month, $day, $year)) {
    echo "La date est valide.";
} else {
    echo "La date est invalide.";
}
// Résultat : La date est invalide (février n'a pas 31 jours).
*/



/*
Filtre date de naissance
Pour s'assurer que la date de naissance est bien au format YYYY-MM-DD (par exemple, 1978-12-03), il est recommandé de combiner validation et sanitisation avec filter_input. Cependant, PHP ne propose pas de filtre natif pour les dates au format exact ISO 8601. On peut utiliser une validation personnalisée en complément. Voici une approche :

1. Utilisation de FILTER_SANITIZE_STRING et validation personnalisée :
$dateNaissancePersonneRecup = filter_input(INPUT_POST, "dateNaissance", FILTER_SANITIZE_STRING);

if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateNaissancePersonneRecup)) {
    $dateParts = explode('-', $dateNaissancePersonneRecup);
    if (checkdate($dateParts[1], $dateParts[2], $dateParts[0])) {
        // La date est valide
        echo "Date valide : $dateNaissancePersonneRecup";
    } else {
        // La date est invalide
        echo "Date invalide : $dateNaissancePersonneRecup";
    }
} else {
    // Le format est incorrect
    echo "Format incorrect pour la date.";
}


2. Explications détaillées

    -> Sanitisation avec FILTER_SANITIZE_STRING :
        Supprime les caractères indésirables (par exemple, les balises HTML, certains caractères spéciaux).
        Cela nettoie la chaîne brute avant de l'analyser.

    -> Validation avec preg_match :
        La regex ^\d{4}-\d{2}-\d{2}$ vérifie que :
            La chaîne commence par 4 chiffres (\d{4}) pour l'année.
            Est suivie d'un tiret (-).
            Puis 2 chiffres pour le mois (\d{2}), encore un tiret (-).
            Enfin, 2 chiffres pour le jour (\d{2}).
        Cela garantit que le format est strictement YYYY-MM-DD.

    -> Validation avec checkdate :
        PHP fournit la fonction checkdate pour vérifier que :
            Le mois est entre 1 et 12.
            Le jour est valide pour le mois donné (y compris les années bissextiles).


3. En résumé : Utilise FILTER_SANITIZE_STRING pour nettoyer la chaîne. Vérifie le format avec une regex stricte. Valide la date avec checkdate.
*/



/*  sql 13  */

?>
