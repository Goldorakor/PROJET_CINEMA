INSERT INTO Personne (idPersonne, nom, prenom, sexe, dateNaissance)
VALUES 
(1, 'Dupont', 'Jean', 'Homme', '1980-04-15'),
(2, 'Martin', 'Claire', 'Femme', '1990-06-22'),
(3, 'Durand', 'Michel', 'Homme', '1975-11-30'),
(4, 'Lemoine', 'Sophie', 'Femme', '1985-07-05'),
(5, 'Roche', 'David', 'Homme', '1983-02-12'),
(6, 'Petit', 'Alice', 'Femme', '1992-03-19'),
(7, 'Leclerc', 'Julien', 'Homme', '1988-09-10'),
(8, 'Benoit', 'Isabelle', 'Femme', '1978-01-25'),
(9, 'Giraud', 'Paul', 'Homme', '1990-04-18'),
(10, 'Faure', 'Marie', 'Femme', '1984-11-03'),
(11, 'Pires', 'Pierre', 'Homme', '1979-12-14'),
(12, 'Dufresne', 'Caroline', 'Femme', '1995-06-02'),
(13, 'Marchand', 'Louis', 'Homme', '1991-09-22'),
(14, 'Garcia', 'Evelyne', 'Femme', '1986-05-28'),
(15, 'Lemoine', 'Pierre', 'Homme', '1982-08-12'),
(16, 'Tanguy', 'Mathilde', 'Femme', '1993-10-01'),
(17, 'Muller', 'Jean-Claude', 'Homme', '1972-01-30'),
(18, 'Vidal', 'Nathalie', 'Femme', '1994-02-17'),
(19, 'Dupuis', 'Frédéric', 'Homme', '1987-11-11'),
(20, 'Lemoine', 'Laura', 'Femme', '1990-05-07');


INSERT INTO Personnage (idPersonnage, nom)
VALUES 
(1, 'Harry Potter'),
(2, 'Hermione Granger'),
(3, 'Ron Weasley'),
(4, 'Frodon Sacquet'),
(5, 'Gandalf'),
(6, 'Aragorn'),
(7, 'Legolas'),
(8, 'Gollum'),
(9, 'Batman'),
(10, 'Joker'),
(11, 'Superman'),
(12, 'Lois Lane'),
(13, 'Iron Man'),
(14, 'Captain America'),
(15, 'Black Widow'),
(16, 'Thor'),
(17, 'Wonder Woman'),
(18, 'Flash'),
(19, 'Aquaman'),
(20, 'Green Lantern');


INSERT INTO Genre (idGenre, libelle)
VALUES 
(1, 'Fantasy'),
(2, 'Action'),
(3, 'Drama'),
(4, 'Comédie'),
(5, 'Science Fiction');


INSERT INTO Realisateur (idRealisateur, idPersonne)
VALUES 
(1, 1),  -- Jean Dupont (réalisateur)
(2, 2);  -- Claire Martin (réalisatrice)


INSERT INTO Acteur (idActeur, idPersonne)
VALUES 
(1, 3),  -- Michel Durand (acteur)
(2, 4),  -- Sophie Lemoine (actrice)
(3, 5),  -- David Roche (acteur)
(4, 6),  -- Alice Petit (actrice)
(5, 7),  -- Julien Leclerc (acteur)
(6, 8),  -- Isabelle Benoit (actrice)
(7, 9),  -- Paul Giraud (acteur)
(8, 10), -- Marie Faure (actrice)
(9, 11), -- Pierre Pires (acteur)
(10, 12),-- Caroline Dufresne (actrice)
(11, 13),-- Louis Marchand (acteur)
(12, 14),-- Evelyne Garcia (actrice)
(13, 15),-- Pierre Lemoine (acteur)
(14, 16),-- Mathilde Tanguy (actrice)
(15, 17),-- Jean-Claude Muller (acteur)
(16, 18),-- Nathalie Vidal (actrice)
(17, 19),-- Frédéric Dupuis (acteur)
(18, 20);-- Laura Lemoine (actrice)


INSERT INTO Film (idFilm, titre, dateSortie, duree, synopsis, note, affiche_url, idRealisateur)
VALUES 
(1, 'Harry Potter et la Pierre Philosophale', '2001-11-10', 152, 'Un jeune sorcier découvre ses pouvoirs magiques.', 8, 'http://example.com/affiche1.jpg', 1),
(2, 'Le Seigneur des Anneaux : La Communauté de l\'Anneau', '2001-12-19', 178, 'Un hobbit doit détruire un anneau magique pour sauver le monde.', 9, 'http://example.com/affiche2.jpg', 2),
(3, 'Batman Begins', '2005-06-15', 140, 'L\'origine de Batman et sa lutte contre le crime à Gotham City.', 7, 'http://example.com/affiche3.jpg', 1),
(4, 'Avengers: Endgame', '2019-04-26', 181, 'Les Avengers tentent de renverser les actes de Thanos.', 10, 'http://example.com/affiche4.jpg', 1),
(5, 'Wonder Woman', '2017-06-02', 141, 'Une guerrière Amazone doit sauver le monde lors de la Première Guerre mondiale.', 8, 'http://example.com/affiche5.jpg', 2);


INSERT INTO classer_par_genre (idFilm, idGenre)
VALUES 
(1, 1),  -- Harry Potter et la Pierre Philosophale (Fantasy)
(1, 3),  -- Harry Potter et la Pierre Philosophale (Drama)
(2, 1),  -- Le Seigneur des Anneaux (Fantasy)
(2, 3),  -- Le Seigneur des Anneaux (Drama)
(3, 2),  -- Batman Begins (Action)
(4, 2),  -- Avengers: Endgame (Action)
(4, 5),  -- Avengers: Endgame (Science Fiction)
(5, 3);  -- Wonder Woman (Drama)


INSERT INTO casting (idFilm, idPersonnage, idActeur)
VALUES 
(1, 1, 1),  -- Harry Potter interprété par Michel Durand
(1, 2, 2),  -- Hermione Granger interprétée par Sophie Lemoine
(1, 3, 3),  -- Ron Weasley interprété par David Roche

(2, 4, 4),  -- Frodon Sacquet interprété par Alice Petit
(2, 5, 5),  -- Gandalf interprété par Julien Leclerc
(2, 6, 6),  -- Aragorn interprété par Isabelle Benoit
(2, 7, 7),  -- Legolas interprété par Paul Giraud
(2, 8, 8),  -- Gollum interprété par Marie Faure

(3, 9, 9),  -- Batman interprété par Pierre Pires
(3, 10, 10),-- Joker interprété par Caroline Dufresne

(4, 13, 11),-- Iron Man interprété par Louis Marchand
(4, 14, 12),-- Captain America interprété par Evelyne Garcia
(4, 15, 13),-- Black Widow interprétée par Pierre Lemoine
(4, 16, 14),-- Thor interprété par Mathilde Tanguy

(5, 17, 15),-- Wonder Woman interprétée par Jean-Claude Muller
(5, 18, 16),-- Flash interprété par Nathalie Vidal
(5, 19, 17),-- Aquaman interprété par Frédéric Dupuis
(5, 20, 18);-- Green Lantern interprété par Laura Lemoine