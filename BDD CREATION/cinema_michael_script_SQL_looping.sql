CREATE TABLE Personne(
   idPersonne INT,
   nom VARCHAR(50),
   prenom VARCHAR(50),
   sexe VARCHAR(50),
   dateNaissance DATE,
   PRIMARY KEY(idPersonne)
);

CREATE TABLE Personnage(
   idPersonnage INT,
   nom VARCHAR(50),
   PRIMARY KEY(idPersonnage)
);

CREATE TABLE Genre(
   idGenre INT,
   libelle VARCHAR(50),
   PRIMARY KEY(idGenre)
);

CREATE TABLE Realisateur(
   idRealisateur INT,
   idPersonne INT NOT NULL,
   PRIMARY KEY(idRealisateur),
   UNIQUE(idPersonne),
   FOREIGN KEY(idPersonne) REFERENCES Personne(idPersonne)
);

CREATE TABLE Acteur(
   idActeur INT,
   idPersonne INT NOT NULL,
   PRIMARY KEY(idActeur),
   UNIQUE(idPersonne),
   FOREIGN KEY(idPersonne) REFERENCES Personne(idPersonne)
);

CREATE TABLE Film(
   idFilm INT,
   titre VARCHAR(200),
   dateSortie DATE,
   duree INT,
   synopsis TEXT,
   note INT,
   affiche_url VARCHAR(100),
   idRealisateur INT NOT NULL,
   PRIMARY KEY(idFilm),
   FOREIGN KEY(idRealisateur) REFERENCES Realisateur(idRealisateur)
);

CREATE TABLE classer_par_genre(
   idFilm INT,
   idGenre INT,
   PRIMARY KEY(idFilm, idGenre),
   FOREIGN KEY(idFilm) REFERENCES Film(idFilm),
   FOREIGN KEY(idGenre) REFERENCES Genre(idGenre)
);

CREATE TABLE casting(
   idFilm INT,
   idPersonnage INT,
   idActeur INT,
   PRIMARY KEY(idFilm, idPersonnage, idActeur),
   FOREIGN KEY(idFilm) REFERENCES Film(idFilm),
   FOREIGN KEY(idPersonnage) REFERENCES Personnage(idPersonnage),
   FOREIGN KEY(idActeur) REFERENCES Acteur(idActeur)
);
