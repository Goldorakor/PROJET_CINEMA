
<!-- on commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<p class="uk-label uk-label-warning">Cet acteur a joué dans <?= $requete2->rowCount() ?> film(s).</p>

<?php
$identite = $requete1->fetch() // tableau associatif récupéré sur la requête1, possédant 8 paires clés-valeurs. cette requête n'envoie qu'une seule ligne.
?>

<h2>
    rrrrrrrrrrr<?= $identite["titre"] ?>
</h2>

<p>
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
    Ce film a été réalisé par <?= $identite["prenom"] ?> <?= $identite["nom"] ?>.
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
                    <?= casting[1] ?> <?= casting[0] ?> / <?= casting[2] ?>
                    </td>
                    <td>
                    <?= $casting[3] ?>
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
                    <?= $genre["libelle"] ?>
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