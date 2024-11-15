question a :

J'ai cherché MIN_TO_TIME(film.duree) mais j'ai finalement contourné le problème.
Le deuxième INNER JOIN est une jointure secondaire (ou indirecte) sur la table realisateur. La table personne ne va pas se lier à la table film mais à la table realisateur.

SELECT film.titre, DATE_FORMAT(film.dateSortie, '%Y') AS anneeSortie, SUBSTR(SEC_TO_TIME(film.duree * 60), 1, 5) AS dureeHeuresMinutes, personne.prenom AS prenomRealisateur, personne.nom AS nomRealisateur
FROM film
INNER JOIN realisateur ON film.idRealisateur = realisateur.idRealisateur
INNER JOIN personne ON realisateur.idPersonne = personne.idPersonne
WHERE film.idFilm = $idFilmChoisi

DATE_FORMAT(film.dateSortie, '%Y') et non DATE_FORMAT(film.dateSortie, %Y)
SUBSTR(nom_colonne, 3, 10) -> on ne garde pas toute la chaine de caractères : on change nom_colonne, en partant du 3eme sur 10 caractères.



question b : 

Pour plus de pertinence, j'ai pris une durée de film de 2h30.

Je transforme mes 2h30 en 150 (pour signifier les 150 minutes)
SELECT film.titre
FROM film
WHERE film.duree > 150
ORDER BY film.duree DESC

Tentaive pour garder le format proposé de l'énoncé --> échec ! 
SELECT film.titre
FROM film
WHERE ((SEC_TO_TIME(film.duree * 60)) - 02:30:00) > 0
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

on copie colle la réponse d et on adapte à la situation présente (demande très similaire)

SELECT COUNT(film.idRealisateur) AS nbFilms, personne.prenom, personne.nom
FROM film
INNER JOIN realisateur ON film.idRealisateur = realisateur.idRealisateur
INNER JOIN personne ON realisateur.idPersonne = personne.idPersonne
GROUP BY film.idRealisateur
ORDER BY COUNT(film.idRealisateur) DESC

on reprend les INNER JOIN en cascade de la question c.
on récupère le nom et prénom du réalisateur pour notre affichage futur.



question f : 

SELECT personne.prenom, personne.nom, personne.sexe
FROM casting
INNER JOIN acteur ON casting.idActeur = acteur.idActeur
INNER JOIN personne ON acteur.idPersonne = personne.idPersonne
WHERE casting.idFilm = $idFilmChoisi

même principe de cascade que pour les réalisateurs.



question g : 

chatGPT n'a pas pensé à permettre à un acteur de jouer dans plusieurs films .... :-(

SELECT film.titre, personnage.nom, DATE_FORMAT(film.dateSortie, '%Y') AS anneeSortie
FROM casting
INNER JOIN film ON casting.idFilm = film.idFilm
INNER JOIN personnage ON casting.idPersonnage = personnage.idPersonnage
WHERE casting.idActeur = $idActeurChoisi
ORDER BY DATE_FORMAT(film.dateSortie, '%Y') DESC



question h : 

J'ai demandé à chatGPT de ne pas avoir de personnes qui soient acteurs et réalisateurs ! 



question i : 

Liste des films qui ont moins de dix ans.

SELECT film.titre
FROM film
WHERE DATEDIFF (NOW(), film.dateSortie) < 3600
ORDER BY film.dateSortie DESC



question j : 

SELECT personne.sexe, COUNT(acteur.idPersonne) AS nombre
FROM acteur
INNER JOIN personne ON acteur.idPersonne = personne.idPersonne
GROUP BY personne.sexe



question k : 




question l : 





