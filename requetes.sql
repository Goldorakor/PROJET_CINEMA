question a :

J'ai cherché MIN_TO_TIME(film.duree) mais j'ai finalement contourné le problème.
Le deuxième INNER JOIN est une jointure secondaire (ou indirecte) sur la table realisateur. La table personne ne va pas se lier à la table film mais à la table realisateur.

SELECT film.titre, DATE_FORMAT(film.dateSortie, %Y) AS anneeSortie, SEC_TO_TIME(film.duree * 60) AS dureeHeuresMinutes, personne.prenom, personne.nom
FROM film
INNER JOIN realisateur ON film.idRealisateur = realisateur.idRealisateur
INNER JOIN personne ON realisateur.idPersonne = personne.idPersonne
WHERE film.idFilm = $id_filmChoisi


question b : 
Pour plus de pertinence, j'ai pris une durée de film de 2h30.

SELECT film.titre
FROM film
WHERE film.duree > 150
ORDER BY film.duree DESC

tentaive pour garder le format proposé de l'énoncé
SELECT film.titre
FROM film
WHERE (SEC_TO_TIME(film.duree * 60) - 02:30:00) > 0
ORDER BY film.duree DESC


question c : 

SELECT film.titre, DATE_FORMAT(film.dateSortie, %Y) AS anneeSortie
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

question f : 

question g : 

question h : 

question i : 

question j : 

question k : 

question l : 


