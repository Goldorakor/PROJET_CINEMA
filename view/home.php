
<!-- on commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>


<form action="index.php?action=ajoutGenreBase" method="post">
    <label for="libelle">Genre à ajouter à ma BDD :</label><br>
    <input type="text" id="libelle" name="libelle"><br><br>
    <input type="submit" name="submit" value="Submit">
</form>
 
<!-- ?php
// Affiche tout le contenu de la superglobale $_POST
var_dump($_POST);
? -->

<?php

// il nous faut remplir ces variables !
// DANS CHAQUE VUE, il faudra !!!toujours!!! donner une valeur à $titre, $contenu et $titre_secondaire
$titre = "Home";
$titre_secondaire = "Home - page d'accueil";

// on commence et on termine la vue par "ob_start()" et "ob_get_clean()"
// on aspire tout ce qui se trouve entre ces 2 fonctions (temporisation de sortie) pour stocker le contenu dans une variable $contenu
$contenu = ob_get_clean();

// le require de fin permet d'injecter le contenu dans le template "squelette" -> template.php
// en effet, dans notre "template.php" on aura des variables qui vont accueillir les éléments provenant des vues
require "view/template.php";



