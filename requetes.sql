question a :

-- J'ai cherché MIN_TO_TIME(film.duree) mais j'ai finalement contourné le problème.
-- Le deuxième INNER JOIN est une jointure secondaire (ou indirecte) sur la table realisateur. La table personne ne va pas se lier à la table film mais à la table realisateur.

SELECT film.titre, DATE_FORMAT(film.dateSortie, '%Y') AS anneeSortie, DATE_FORMAT(SEC_TO_TIME(film.duree * 60), '%H:%i') AS dureeHeuresMinutes, personne.prenom AS prenomRealisateur, personne.nom AS nomRealisateur
FROM film
INNER JOIN realisateur ON film.idRealisateur = realisateur.idRealisateur
INNER JOIN personne ON realisateur.idPersonne = personne.idPersonne
WHERE film.idFilm = $idFilmChoisi

-- DATE_FORMAT(film.dateSortie, '%Y') et non DATE_FORMAT(film.dateSortie, %Y)

-- SUBSTR(nom_colonne, 3, 10) -> on ne garde pas toute la chaine de caractères : on change nom_colonne, en partant du 3eme sur 10 caractères. --> c'est du bricolage ! on préfère prendre DATE_FORMAT(..., '%H:%i')

-- DATE_FORMAT(..., '%H:%i') : Cette fonction formate le résultat pour ne montrer que l'heure et les minutes, en omettant les secondes.



question b : 

-- Pour plus de pertinence, j'ai pris une durée de film de 2h30.

Je transforme mes 2h30 en 150 (pour signifier les 150 minutes)
SELECT film.titre
FROM film
WHERE film.duree > 150
ORDER BY film.duree DESC



question c : 

SELECT film.titre, DATE_FORMAT(film.dateSortie, '%Y') AS anneeSortie
FROM film
INNER JOIN realisateur ON film.idRealisateur = realisateur.idRealisateur
INNER JOIN personne ON realisateur.idPersonne = personne.idPersonne
WHERE personne.idPersonne = $idRealisateurChoisi



question d : 

SELECT COUNT(classer_par_genre.idGenre) AS nbFilms, genre.libelle
FROM classer_par_genre
INNER JOIN genre ON classer_par_genre.idGenre = genre.idGenre
GROUP BY classer_par_genre.idGenre
ORDER BY COUNT(classer_par_genre.idGenre) DESC



question e : 

-- on copie colle la réponse d et on adapte à la situation présente (demande très similaire)

SELECT COUNT(film.idRealisateur) AS nbFilms, personne.prenom, personne.nom
FROM film
INNER JOIN realisateur ON film.idRealisateur = realisateur.idRealisateur
INNER JOIN personne ON realisateur.idPersonne = personne.idPersonne
GROUP BY film.idRealisateur
ORDER BY COUNT(film.idRealisateur) DESC

-- on reprend les INNER JOIN en cascade de la question c.
-- on récupère le nom et prénom du réalisateur pour notre affichage futur.



question f : 

SELECT personne.prenom, personne.nom, personne.sexe
FROM casting
INNER JOIN acteur ON casting.idActeur = acteur.idActeur
INNER JOIN personne ON acteur.idPersonne = personne.idPersonne
WHERE casting.idFilm = $idFilmChoisi

-- même principe de cascade que pour les réalisateurs.



question g : 

-- chatGPT n'a pas pensé à permettre à un acteur de jouer dans plusieurs films .... :-( 

SELECT film.titre, personnage.nom, DATE_FORMAT(film.dateSortie, '%Y') AS anneeSortie
FROM casting
INNER JOIN film ON casting.idFilm = film.idFilm
INNER JOIN personnage ON casting.idPersonnage = personnage.idPersonnage
WHERE casting.idActeur = $idActeurChoisi
ORDER BY DATE_FORMAT(film.dateSortie, '%Y') DESC



question h : 

-- je pensais avoir besoin de plus de lignes ... finalement, on a pris l'intersection de 3 ensembles, à savoir les personnes, les réalisateurs et les acteurs. Cette intersection est un singleton dans notre base de données.

SELECT personne.prenom, personne.nom
FROM personne
INNER JOIN acteur ON personne.idPersonne = acteur.idPersonne
INNER JOIN realisateur ON personne.idPersonne = realisateur.idPersonne



question i : 

-- Liste des films qui ont moins de dix ans.

SELECT film.titre, YEAR(NOW()) - YEAR(film.dateSortie) AS ancienneteFilm
FROM film
WHERE (YEAR(NOW()) - YEAR(film.dateSortie)) < 10
ORDER BY film.dateSortie DESC

-- je ne veux pas les films qui vont sortir prochainement ! 

SELECT film.titre, YEAR(NOW()) - YEAR(film.dateSortie) AS ancienneteFilm
FROM film
WHERE ((YEAR(NOW()) - YEAR(film.dateSortie)) < 10 AND (YEAR(NOW()) - YEAR(film.dateSortie)) >= 0)
ORDER BY film.dateSortie DESC

-- ancienne méthode :

SELECT film.titre
FROM film
WHERE DATEDIFF(NOW(), film.dateSortie) < 3650
ORDER BY film.dateSortie DESC

-- 10 ans correspondent à 3650 jours
-- DATEDIFF(NOW(), film.dateSortie) : ressort un intervalle exprimé en jours.
-- YEAR(date) : ressort une chaine de 4 caractères.

question j : 

SELECT personne.sexe, COUNT(acteur.idPersonne) AS nombre
FROM acteur
INNER JOIN personne ON acteur.idPersonne = personne.idPersonne
GROUP BY personne.sexe



question k : 

-- liste des acteurs ayant plus de 40 ans (âge révolu et non révolu)


-- Sont distingués :

-- l'âge par génération ou âge atteint dans l'année : différence entre l'année considérée et l'année de naissance de l'individu,
-- l'âge en années révolues ou âge au dernier anniversaire. Dans une même génération, l'âge en années révolues n'est pas le même pour toutes les personnes.

-- Par exemple, un individu né le 10 octobre 1925 décède le 18 avril 1999. Il a 74 ans en âge atteint dans l'année : 1999 - 1925 = 74. Mais il a 73 ans en années révolues : 18 avril 1999 - 10 octobre 1925 = 73 ans 6 mois et 8 jours.

-- Ainsi, pour un individu ayant x ans en âge atteint dans l'année, si l'événement a eu lieu à la date d :

-- l'individu ayant son anniversaire après la date d aura comme âge en années révolues (x-1) ;
-- l'individu ayant son anniversaire à la date d ou avant aura comme âge en années révolues (x).

-- Seule exception : l'événement a lieu le 31 décembre. À cette date, le classement par âge atteint dans l'année et par âge en années révolues sont identiques. Et au 1er janvier, l'âge atteint dans l'année est égal à l'âge en années révolues plus un.


-- cas de l'âge par génération ou âge atteint dans l'année
-- strictement plus de 40 ans, on veut au minimum 41 ans.
SELECT personne.prenom, personne.nom, (YEAR(NOW()) - YEAR(personne.dateNaissance)) AS ageActeur
FROM personne
INNER JOIN acteur ON personne.idPersonne = acteur.idPersonne
WHERE (YEAR(NOW()) - YEAR(personne.dateNaissance)) > 40
ORDER BY (YEAR(NOW()) - YEAR(personne.dateNaissance))


-- cas de l'âge en années révolues ou âge au dernier anniversaire

-- date d'anniversaire avant la date now ou le même jour que la date now
(((MONTH(NOW()) - MONTH(personne.dateNaissance)) > 0)
OR 
(((MONTH(NOW()) - MONTH(personne.dateNaissance)) = 0)
AND
((DAY(NOW()) - DAY(personne.dateNaissance)) >= 0)))

-- date d'anniversaire après la date now
(((MONTH(NOW()) - MONTH(personne.dateNaissance)) < 0)
OR 
(((MONTH(NOW()) - MONTH(personne.dateNaissance)) = 0)
AND
((DAY(NOW()) - DAY(personne.dateNaissance)) < 0)))


SELECT personne.prenom, personne.nom
FROM personne
INNER JOIN acteur ON personne.idPersonne = acteur.idPersonne
WHERE (YEAR(NOW()) - YEAR(personne.dateNaissance)) > 40 
    OR 
    (YEAR(NOW()) - YEAR(personne.dateNaissance)) = 40 AND 
    (
        (MONTH(NOW()) - MONTH(personne.dateNaissance) > 0) 
        OR 
        (MONTH(NOW()) - MONTH(personne.dateNaissance) = 0 AND DAY(NOW()) - DAY(personne.dateNaissance) >= 0)
    )

ORDER BY (YEAR(NOW()) - YEAR(personne.dateNaissance))

-- on affiche les acteurs qui ont strictement plus de 40 ans (ils ont déjà dépassé l'année calendaire de leur 40ème année)
-- on affiche les acteurs qui sont dans leur 40ème année mais qui sont nés dans un mois qui précède le mois en cours
-- on affiche les acteurs qui sont dans leur 40ème année et qui sont nés durant le mois en cours mais qui sont nés un jour qui précede le jour en cours (ou qui est égal au jour en cours). 



question l : 

SELECT personne.prenom, personne.nom, COUNT()
FROM personne
INNER JOIN acteur ON personne.idPersonne = acteur.idPersonne
INNER JOIN casting ON acteur.idActeur = casting.idActeur


SELECT personne.prenom, personne.nom, COUNT(casting.idFilm) AS nbFilmActeur
FROM casting
INNER JOIN acteur ON casting.idActeur = acteur.idActeur
INNER JOIN personne ON acteur.idPersonne = personne.idPersonne
GROUP BY casting.idActeur
HAVING COUNT(casting.idFilm) > 3

On notera qu'on utilise des INNER JOIN en cascade.
Explication du COUNT : je suis dans la table casting, je compte le nombre de lignes idFilm pour un même numéro de idActeur (et je répète l'opération pour tous les idActeur présents).
Je ne garde que les COUNT > 3 pour l'affichage.


oooooooooooooooooooooooooooooooooooooooooooooooooooooooooo
oooooooooooooooooooooooooooooooooooooooooooooooooooooooooo
oooooooooooooooooooooooooooooooooooooooooooooooooooooooooo


Bonjour, je vais te donner un fichier .sql qui correspond à la base de données sur laquelle je travaille. Tu vas me créer une requête pour créer une personne qui sera à la fois acteur et réalisateur d'un film que tu auras aussi créé. Merci à toi !

Étapes :
1. Ajouter une nouvelle personne (qui sera acteur et réalisateur).
2. Ajouter cette personne dans la table Acteur et Realisateur.
3. Créer un film dans lequel cette personne réalisera et jouera un rôle.
4. Associer cette personne au rôle d'acteur dans ce film.


-- 1. Créer une nouvelle personne (acteur et réalisateur)
INSERT INTO Personne (idPersonne, nom, prenom, sexe, dateNaissance)
VALUES (21, 'Dupuis', 'Frédéric', 'Homme', '1987-11-11');

-- 2. Ajouter cette personne dans la table des réalisateurs
INSERT INTO Realisateur (idRealisateur, idPersonne)
VALUES (3, 21);

-- 3. Ajouter cette personne dans la table des acteurs
INSERT INTO Acteur (idActeur, idPersonne)
VALUES (19, 21);

-- 4. Créer un nouveau film (où cette personne sera à la fois réalisateur et acteur)
INSERT INTO Film (idFilm, titre, dateSortie, duree, synopsis, note, affiche_url, idRealisateur)
VALUES (6, 'L\'Étoile du Destin', '2025-05-10', 130, 'Un héros solitaire lutte contre des forces mystérieuses pour sauver le monde.', 8, 'http://example.com/affiche6.jpg', 3);

-- 5. Créer un personnage pour le film (celui que l'acteur jouera)
INSERT INTO Personnage (idPersonnage, nom)
VALUES (21, 'Le Héros');

-- 6. Associer cet acteur au personnage qu'il interprétera dans le film
INSERT INTO casting (idFilm, idPersonnage, idActeur)
VALUES (6, 21, 19);


Explications :
Étape 1 : Nous insérons une nouvelle personne, ici Frédéric Dupuis, avec un idPersonne unique (21).
Étape 2 : Nous ajoutons cette personne à la table des réalisateurs en utilisant son idPersonne (21).
Étape 3 : Nous ajoutons également cette personne à la table des acteurs.
Étape 4 : Nous créons un nouveau film intitulé "L'Étoile du Destin" avec cette personne comme réalisateur.
Étape 5 : Un nouveau personnage est créé pour ce film, appelé "Le Héros".
Étape 6 : Nous associons l'acteur à ce personnage dans le film créé.


oooooooooooooooooooooooooooooooooooooooooooooooooooooo


Bonjour, j'aimerais que tu me donnes une requête pour créer 3 acteurs qui auront joué chacun dans 4 films. Tu peux leur créer des nouveaux personnages qui tu ajouteras à des films existants.

-- 1. Créer trois nouveaux acteurs
-- Acteur 1 : Alain Dupuis
INSERT INTO Personne (idPersonne, nom, prenom, sexe, dateNaissance)
VALUES (22, 'Dupuis', 'Alain', 'Homme', '1985-08-10');

-- Acteur 2 : Lucien Bernard
INSERT INTO Personne (idPersonne, nom, prenom, sexe, dateNaissance)
VALUES (23, 'Bernard', 'Lucien', 'Homme', '1992-03-25');

-- Acteur 3 : Éric Lefevre
INSERT INTO Personne (idPersonne, nom, prenom, sexe, dateNaissance)
VALUES (24, 'Lefevre', 'Éric', 'Homme', '1980-07-14');

-- Ajouter ces personnes dans la table des acteurs
INSERT INTO Acteur (idActeur, idPersonne)
VALUES (20, 22), (21, 23), (22, 24);

-- 2. Créer des personnages pour ces acteurs
-- Personnage pour Alain Dupuis
INSERT INTO Personnage (idPersonnage, nom)
VALUES (22, 'Le Magicien'), (23, 'Le Soldat'), (24, 'Le Docteur'), (25, 'Le Voleur');

-- Personnage pour Lucien Bernard
INSERT INTO Personnage (idPersonnage, nom)
VALUES (26, 'Le Pirate'), (27, 'L\'Explorateur'), (28, 'Le Médecin'), (29, 'Le Comédien');

-- Personnage pour Éric Lefevre
INSERT INTO Personnage (idPersonnage, nom)
VALUES (30, 'Le Voyageur'), (31, 'Le Prince'), (32, 'Le Géant'), (33, 'L\'Espion');

-- 3. Associer ces acteurs à des personnages dans des films existants
-- Acteur Alain Dupuis (idActeur 20)
INSERT INTO casting (idFilm, idPersonnage, idActeur)
VALUES 
(1, 22, 20),  -- Alain Dupuis joue Le Magicien dans Harry Potter et la Pierre Philosophale
(3, 23, 20),  -- Alain Dupuis joue Le Soldat dans Batman Begins
(4, 24, 20),  -- Alain Dupuis joue Le Docteur dans Avengers: Endgame
(5, 25, 20);  -- Alain Dupuis joue Le Voleur dans Wonder Woman

-- Acteur Lucien Bernard (idActeur 21)
INSERT INTO casting (idFilm, idPersonnage, idActeur)
VALUES 
(2, 26, 21),  -- Lucien Bernard joue Le Pirate dans Le Seigneur des Anneaux
(3, 27, 21),  -- Lucien Bernard joue L'Explorateur dans Batman Begins
(4, 28, 21),  -- Lucien Bernard joue Le Médecin dans Avengers: Endgame
(5, 29, 21);  -- Lucien Bernard joue Le Comédien dans Wonder Woman

-- Acteur Éric Lefevre (idActeur 22)
INSERT INTO casting (idFilm, idPersonnage, idActeur)
VALUES 
(1, 30, 22),  -- Éric Lefevre joue Le Voyageur dans Harry Potter et la Pierre Philosophale
(2, 31, 22),  -- Éric Lefevre joue Le Prince dans Le Seigneur des Anneaux
(3, 32, 22),  -- Éric Lefevre joue Le Géant dans Batman Begins
(4, 33, 22);  -- Éric Lefevre joue L'Espion dans Avengers: Endgame
