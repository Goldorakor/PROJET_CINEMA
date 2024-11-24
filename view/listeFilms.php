
<!-- on commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<p class="uk-label uk-label-warning">Il y a actuellement <?= $requete->rowCount() ?> films dans notre base de données.</p>


<table class="uk-table uk-table-striped">
    <thead>
        <tr>
            <th>
                TITRE
            </th>
            <th>
                ANNEE SORTIE
            </th>
            <th>
                DETAILS
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        // on construit une boucle dont le tableau est le 'tableau associatif' récupéré sur la requête
            foreach($requete->fetchALL() as $film) { ?>
                <tr>
                    <td>
                    <?= $film["titre"] ?>
                    </td>
                    <td>
                    <?= $film["anneeSortie"] ?>
                    </td>
                    <td>
                        <a href="index.php?action=detailsFilm&id=<?= $film['idFilm'] ?>">
                            voir +
                        </a>
                    </td>
                </tr>
        <?php   } ?>
    </tbody>
</table>

<?php

// il nous faut remplir ces variables pour donner 'à manger' à notre fichier template.php !
// DANS CHAQUE VUE, il faudra !!!toujours!!! donner une valeur à $titre, $contenu et $titre_secondaire
$titre = "Liste des films";
$titre_secondaire = "Liste des films de notre BDD";

// on commence et on termine la vue par "ob_start()" et "ob_get_clean()"
// on aspire tout ce qui se trouve entre ces 2 fonctions (temporisation de sortie) pour stocker le contenu dans une variable $contenu
$contenu = ob_get_clean();

// le require de fin permet d'injecter le contenu dans le template "squelette" -> template.php
// en effet, dans notre "template.php" on aura des variables qui vont accueillir les éléments provenant des vues
require "view/template.php";