<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="public/css/style.css">  <!-- ../public/css/style.css ou /public/css/style.css ou le chemin absolu en cas de souci -->

    <!-- je remplis mon modèle de vues avec les variables souhaitées, indispensable à la souplesse du modèle -->
    <title><?= $titre ?></title>

</head>
<body>
    <div id='container'>
        <header>
            <nav>
                <ul>
                    <li>
                        <a class='moyen' href="index.php?action=home">Home</a>
                    </li>
                    <li>
                        <a class='moyen' href="index.php?action=listFilms">Films</a>
                    </li>
                    <li>
                        <a class='moyen' href="index.php?action=listActeurs">Acteurs</a>
                    </li>
                    <li>
                        <a class='moyen' href="index.php?action=listRealisateurs">Réalisateurs</a>
                    </li>
                    <li>
                        <a class='moyen' href="index.php?action=listGenres">Genres</a>
                    </li>
                </ul>

                <!-- menu hamburger récupéré sur le travail Projet_Simpson, que j'adapte à mon projet actuel -->
                <div class="sandwich">
                    <ul class="menu" id="menu" aria-label="Menu principal"> <!-- aria-label="Menu principal" -> pour indiquer que c’est un menu de navigation. Cela aide les lecteurs d’écran à mieux interpréter les éléments -->
                        <li class="smart-menu">
                            <a href="index.php?action=home">Home</a>
                        </li>
                        <li class="smart-menu">
                            <a href="index.php?action=listFilms">Films</a>
                        </li>
                        <li class="smart-menu">
                            <a href="index.php?action=listActeurs">Acteurs</a>
                        </li>
                        <li class="smart-menu">
                            <a href="index.php?action=listRealisateurs">Realisateurs</a>
                        </li>
                        <li class="smart-menu">
                            <a href="index.php?action=listGenres">Genres</a>
                        </li>
                        <li class="smart-menu">
                            <a href="#">Contact</a>
                        </li>
                        <li class="smart-menu">
                            <a href="#">Confidentialité</a>
                        </li>

                        <!-- on ajoute une icône croix pour fermer le menu hamburger -->
                        <a class="close" href="#" role="button" aria-label="Fermer le menu"> <!-- role="button" aria-label="Fermer le menu"  -> pour indiquer que c’est un bouton pour fermer le menu. Cela aide les lecteurs d’écran à mieux interpréter les éléments -->
                        <span class="material-icons">
                            close
                        </span>
                        </a>

                        <!-- 
                        Pour la fermeture, on utilise un lien <a href="#">. Si le menu doit disparaître dynamiquement (avec JavaScript), il vaut mieux éviter l’attribut href="#" qui rafraîchit la page.
                        On peut remplacer par un bouton <button> :

                        <button class="close" aria-label="Fermer le menu">
                            <span class="material-icons">close</span>
                        </button>
                        -->

                    </ul>

                    <a class="hamburger" href="#menu" role="button" aria-label="Ouvrir le menu"> <!-- role="button" aria-label="Ouvrir le menu"  -> pour indiquer que c’est un bouton pour ouvrir le menu. Cela aide les lecteurs d’écran à mieux interpréter les éléments -->
                        <span class="material-icons">
                            menu
                        </span>
                    </a>

                    <!-- 
                    Pour l'ouverture, on utilise un lien <a href="#">. Si le menu doit disparaître dynamiquement (avec JavaScript), il vaut mieux éviter l’attribut href="#" qui rafraîchit la page.
                    On peut remplacer par un bouton <button> :

                    <button class="hamburger" aria-label="Ouvrir le menu">
                        <span class="material-icons">menu</span>
                    </button>
                    -->

                </div>
            </nav>
        </header>
    </div>
    
    <div id="wrapper" class="uk-container uk-container-expand">
        <main>
            <div id="contenu">
                <h1 class="uk-heading-divider">
                    PDO Cinéma
                </h1>
                <h2 class="uk-heading-bullet">
                    
                    <!-- je remplis mon modèle de vues avec les variables souhaitées -->
                    <?= $titre_secondaire ?>
                </h2>

                <!-- je remplis mon modèle de vues avec les variables souhaitées -->
                <?= $contenu ?>
            </div>
        </main>
    </div>
</body>
</html>