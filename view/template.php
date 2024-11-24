<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="public/css/style.css">

    <!-- je remplis mon modèle de vues avec les variables souhaitées, indispensable à la souplesse du modèle -->
    <title><?= $titre ?></title>

</head>
<body>
    <nav>
        <ul>
            <li>
                <a href="index.php?action=home">Home</a>
            </li>
            <li>
                <a href="index.php?action=listFilms">Films</a>
            </li>
            <li>
                <a href="index.php?action=listActeurs">Acteurs</a>
            </li>
            <li>
                <a href="index.php?action=listRealisateurs">Réalisateurs</a>
            </li>
        </ul>
    </nav>
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