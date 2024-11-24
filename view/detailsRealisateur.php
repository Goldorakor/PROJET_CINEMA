
<!-- on commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<p class="uk-label uk-label-warning">Ce réalisateur a réalisé <?= $requete2->rowCount() ?> films.</p>

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
            <?= $identite["prenom"] ?>
            </td>
            <td>
            <?= $identite["nom"] ?>
            </td>
            <td>
            <?= $identite["sexe"] ?>
            </td>
            <td>
            <?= $identite["ageRealisateur"] ?>
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
                ANNEE SORTIE
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        // on construit une boucle dont le tableau est le tableau associatif récupéré sur la requête
            foreach($requete2->fetchALL() as $filmographie) { ?>
                <tr>
                    <td>
                    <?= $filmographie["titre"] ?>
                    </td>
                    <td>
                    <?= $filmographie["anneeSortie"] ?>
                    </td>  
                </tr>
        <?php   } ?>
    </tbody>
</table>


<?php

// il nous faut remplir ces variables !
// DANS CHAQUE VUE, il faudra !!!toujours!!! donner une valeur à $titre, $contenu et $titre_secondaire
$titre = "Détails d'un réalisateur";
$titre_secondaire = "Détails d'un réalisateur";

// on commence et on termine la vue par "ob_start()" et "ob_get_clean()"
// on aspire tout ce qui se trouve entre ces 2 fonctions (temporisation de sortie) pour stocker le contenu dans une variable $contenu
$contenu = ob_get_clean();

// le require de fin permet d'injecter le contenu dans le template "squelette" -> template.php
// en effet, dans notre "template.php" on aura des variables qui vont accueillir les éléments provenant des vues
require "view/template.php";