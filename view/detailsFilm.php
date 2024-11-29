
<!-- on commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<p class="uk-label uk-label-warning">Le casting de ce film compte <?= $requete2->rowCount() ?> acteur(s) de notre liste d'acteurs.</p>


<?php 
$identite = $requete1->fetch() // tableau associatif récupéré sur la requête1, possédant 8 paires clés-valeurs. cette requête n'envoie qu'une seule ligne.
?>



<h2>
    Titre : <?= $identite["titre"] ?>
</h2>

<p>
résumé :<br>
<?= $identite["synopsis"] ?>
</p>

<div>
    durée : <?= $identite["duree"] ?> minutes
</div>

<div>
    note : <?= $identite["note"] ?>/10
</div>

<div>
    année : <?= $identite["anneeSortie"] ?>
</div>

<div>

    Ce film a été réalisé par <a href="index.php?action=detailsRealisateur&id=<?= $identite['idRealisateur'] ?>"><?= $identite["prenom"] ?> <?= $identite["nom"] ?></a>.
</div>




<table class="uk-table uk-table-striped">
    <thead>
        <tr>
            <th>
                ACTEUR
            </th>
            <th>
                ROLE
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        // on construit une boucle dont le tableau est le tableau associatif récupéré sur la requête
            foreach($requete2->fetchALL() as $casting) { ?>
                <tr>
                    <td>
                    <a href="index.php?action=detailsActeur&id=<?= $casting['idActeur'] ?>"><?=  $casting['prenom'] ?> <?=  $casting['nom'] ?></a> / <?=  $casting['sexe'] ?>
                    </td>
                    <td>
                    <?= $casting['role'] ?>
                    </td>  
                </tr>
        <?php   } ?>
    </tbody>
</table>




<table class="uk-table uk-table-striped">
    <thead>
        <tr>
            <th>
                GENRE
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        // on construit une boucle dont le tableau est le tableau associatif récupéré sur la requête
            foreach($requete3->fetchALL() as $genre) { ?>
                <tr>
                    <td>
                    <?= $genre['libelle'] ?>
                    </td> 
                </tr>
        <?php   } ?>
    </tbody>
</table>


<?php

// il nous faut remplir ces variables !
// DANS CHAQUE VUE, il faudra !!!toujours!!! donner une valeur à $titre, $contenu et $titre_secondaire
$titre = "Détails d'un film";
$titre_secondaire = "Détails d'un film";

// on commence et on termine la vue par "ob_start()" et "ob_get_clean()"
// on aspire tout ce qui se trouve entre ces 2 fonctions (temporisation de sortie) pour stocker le contenu dans une variable $contenu
$contenu = ob_get_clean();

// le require de fin permet d'injecter le contenu dans le template "squelette" -> template.php
// en effet, dans notre "template.php" on aura des variables qui vont accueillir les éléments provenant des vues
require "view/template.php";