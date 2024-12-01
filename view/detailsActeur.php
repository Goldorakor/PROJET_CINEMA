
<!-- on commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<p class="uk-label uk-label-warning">Cet acteur a joué dans <?= $requete2->rowCount() ?> film(s) de notre liste de films.</p>





<?php
$identite = $requete1->fetch() // tableau associatif récupéré sur la requête1, possédant 4 paires clés-valeurs. cette requête n'envoie qu'une seule ligne.
?>

<table class="uk-table uk-table-striped">
    <thead>
        <tr>
            <th>
                IDENTITE
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?= $identite["prenom"] ?> <?= $identite["nom"] ?>
            </td>
        </tr>
        <tr>
            <td>
                civilité : <?= $identite["sexe"] ?>
            </td>
        </tr>
        <tr>
            <td>
                âge : <?= $identite["ageActeur"] ?>
            </td>
        </tr>
    </tbody>
</table>



<table class="uk-table uk-table-striped">
    <thead>
        <tr>
            <th>
                TITRE DU FILM
            </th>
            <th>
                ROLE
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        // on construit une boucle dont le tableau est le tableau associatif récupéré sur la requête
            foreach($requete2->fetchALL() as $filmographie) { ?>
                <tr>
                    <td>
                    <a href="index.php?action=detailsFilm&id=<?= $filmographie['idFilm'] ?>"><?= $filmographie["titre"] ?></a>
                    </td>
                    <td>
                    <?= $filmographie["nom"] ?>
                    </td>  
                </tr>
        <?php   } ?>
    </tbody>
</table>



<?php

// il nous faut remplir ces variables !
// DANS CHAQUE VUE, il faudra !!!toujours!!! donner une valeur à $titre, $contenu et $titre_secondaire
$titre = "Détails d'un acteur";
$titre_secondaire = "Détails d'un acteur";

// on commence et on termine la vue par "ob_start()" et "ob_get_clean()"
// on aspire tout ce qui se trouve entre ces 2 fonctions (temporisation de sortie) pour stocker le contenu dans une variable $contenu
$contenu = ob_get_clean();

// le require de fin permet d'injecter le contenu dans le template "squelette" -> template.php
// en effet, dans notre "template.php" on aura des variables qui vont accueillir les éléments provenant des vues
require "view/template.php";

?>

