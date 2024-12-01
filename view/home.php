
<!-- on commence et on termine la vue par "ob_start()" et "ob_get_clean()" -->
<?php ob_start(); ?>

<h3>Formulaire d'ajout d'un genre à la base de données</h3>
<!-- formulaire pour ajouter un genre à notre BDD -->
<form action="index.php?action=ajoutGenreBase" method="post">
    <label for="libelle">Libellé du genre à ajouter :</label><br>
    <input type="text" id="libelle" name="libelle"><br><br>
    <input type="submit" name="submit" value="Submit">
</form>


<br><br><br><br>


<h3>Formulaire d'ajout d'un personnage (héros de film) à la base de données</h3>
<!-- formulaire pour ajouter un personnage (héros de film) à notre BDD -->
<form action="index.php?action=ajoutPersonnageBase" method="post">
    <label for="nomPersonnage">Nom du personnage à ajouter :</label><br>
    <input type="text" id="nomPersonnage" name="nomPersonnage"><br><br>
    <input type="submit" name="submit" value="Submit">
</form>


<br><br><br><br>


<h3>Formulaire d'ajout d'une personne à la base de données</h3>
<!-- formulaire pour ajouter une personne à notre BDD et préciser s'il est acteur et/ou réalisateur -->
<form action="index.php?action=ajoutPersonneBase" method="post">

    <label for="nomPersonne">Nom de la personne à ajouter :</label><br>
    <input type="text" id="nomPersonne" name="nomPersonne"><br><br>

    <label for="prenomPersonne">Prénom de la personne à ajouter :</label><br>
    <input type="text" id="prenomPersonne" name="prenomPersonne"><br><br>

    <label for="choixSexePersonne">Choisissez la civilité de la personne à ajouter :<br></label>
    <select name="sexePersonne" id="choixSexePersonne">
        <option value="">   Faites votre choix   </option>
        <option value="Homme">Homme</option>
        <option value="Femme">Femme</option>
    </select><br><br>

    <label for="dateNaissancePersonne">Date de naissance de la personne à ajouter :</label><br>
    <input type="date" id="dateNaissancePersonne" name="dateNaissancePersonne"><br><br>

    <label for="acteur">Cette personne est-elle 'acteur' ? :</label><br>
    <input type="checkbox" id="acteur" name="acteur"><br><br>

    <label for="realisateur">Cette personne est-elle 'réalisateur' ? :</label><br>
    <input type="checkbox" id="realisateur" name="realisateur"><br><br>

    <input type="submit" name="submit" value="Submit">

</form>


<br><br><br><br>




<!-- 

 LISTE DEROULANTE
 petit travail préparatoire pour bien créer notre liste déroulante en HTML
<label for="choixCivilite">Choisissez votre civilité:<br></label>
<select name="civilite" id="choixCivilite">
  <option value="">   Faites votre choix   </option>
  <option value="monsieur">Monsieur</option>
  <option value="madame">Madame</option>
  <option value="mademoiselle">Mademoiselle</option>
</select><br> 


CASES A COCHER
<form>
<div>
    <input type="checkbox" id="scales" name="scales" checked />
    <label for="scales">Scales</label>
</div>

<div>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Horns</label>
</div>

<div>
    <input type="checkbox" id="scales" name="scales" unchecked />
    <label for="scales">Scales</label>
</div>

<div>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Horns</label>
</div>
</form>


BOUTONS RADIO
<fieldset>
  <legend>Select a maintenance drone:</legend>

  <div>
    <input type="radio" id="huey" name="drone" value="huey" checked />
    <label for="huey">Huey</label>
  </div>

  <div>
    <input type="radio" id="dewey" name="drone" value="dewey" />
    <label for="dewey">Dewey</label>
  </div>

  <div>
    <input type="radio" id="louie" name="drone" value="louie" />
    <label for="louie">Louie</label>
  </div>
</fieldset>

Algo_PHP_Partie_02/exercice10.php -> on reprend tout !

-->


 
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

?>



