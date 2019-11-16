-- SQL DDL Intro aus der Übung

-- Ihre Datenbank auswählen, ändern Sie den Namen entsprechend...
USE `db3188047`;

-- Tabelle löschen, falls Sie existiert
-- Zuerst die M zu N Tabellen
DROP TABLE IF EXISTS `Enthält`;
DROP TABLE IF EXISTS `Freundschaft`;
DROP TABLE IF EXISTS `Hat_Bilder`;
DROP TABLE IF EXISTS `Mahlzeiten_Enthält_Zutaten`;
DROP TABLE IF EXISTS `Deklaration_Braucht_Mahlzeit`;


-- Dann in richtiger Reihenfolge andere Tabellen

DROP TABLE IF EXISTS `Kommentar`;

DROP TABLE IF EXISTS `Mitarbeiter`;
DROP TABLE IF EXISTS `Student`;
DROP TABLE IF EXISTS `Gast`;
DROP TABLE IF EXISTS `FH_Angehöriger`;
DROP TABLE IF EXISTS `Bestellung`;
DROP TABLE IF EXISTS `Benutzer`;
DROP TABLE IF EXISTS `Preis`;
DROP TABLE IF EXISTS `Mahlzeit`;
DROP TABLE IF EXISTS `Zutat`;

DROP TABLE IF EXISTS `Kategorie`;
DROP TABLE IF EXISTS `Bild`;

DROP TABLE IF EXISTS `Deklaration`;



-- Empfohlen ist, zuerst die Attribute der Tabellen anzulegen und die Relationen 
-- anschließend vorzunehmen. dabei werden Sie erkennen, dass nicht jede Lösch-
-- reihenfolge (DROP) funktioniert.

CREATE TABLE Bild(
ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`Alt-Text` VARCHAR (255) DEFAULT ('Could not display the image'),
Titel CHAR (255),
Binärdaten BLOB NOT NULL
);

CREATE TABLE Benutzer (
Nummer INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`E-Mail` VARCHAR(255) NOT NULL UNIQUE, -- Backticks wegen Minus im namen
Bild BLOB , -- NOT NULL aber wegen Insert befehle null
Nutzername VARCHAR(50) NOT NULL UNIQUE, -- NOT NULL weil nicht optional
Hash VARCHAR(60) NOT NULL,
LetzterLogin DATETIME DEFAULT (NULL),
Anlegedatum DATETIME DEFAULT (CURDATE()),
Aktiv BOOL,
Vorname VARCHAR(15) NOT NULL,
Nachname VARCHAR(15) NOT NULL,
Geburtsdatum DATE
);

-- befreundet mit - Relation
CREATE TABLE Freundschaft(
benutzer_id_1 INT UNSIGNED,
benutzer_id_2 INT UNSIGNED,
PRIMARY KEY (benutzer_id_1, benutzer_id_2),
FOREIGN KEY (benutzer_id_1) REFERENCES Benutzer (Nummer)
ON DELETE CASCADE
ON UPDATE RESTRICT,
FOREIGN KEY (benutzer_id_2) REFERENCES Benutzer (Nummer)
        ON DELETE CASCADE
        ON UPDATE RESTRICT
);

CREATE TABLE Gast(
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
Benutzer_id INT UNSIGNED NOT NULL,
Grund Varchar(254),
Ablaufdatum Date DEFAULT(CURDATE() + INTERVAL 7 DAY),
CONSTRAINT `fk_Gast_Benutzer`
FOREIGN KEY (Benutzer_id) REFERENCES Benutzer (Nummer)
        ON DELETE CASCADE
        ON UPDATE RESTRICT
);

CREATE TABLE FH_Angehöriger(
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
Benutzer_id INT UNSIGNED NOT NULL,
CONSTRAINT `fk_FHAngehöriger_Benutzer`
FOREIGN KEY (Benutzer_id) REFERENCES Benutzer (Nummer)
        ON DELETE CASCADE
        ON UPDATE RESTRICT
);

CREATE TABLE Mitarbeiter(
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
Büro VARCHAR (30),
Telefon VARCHAR (15),
FH_Angehöriger_id INT UNSIGNED NOT NULL,
CONSTRAINT `fk_Mitarbeiter_FHAngehöriger`
FOREIGN KEY (FH_Angehöriger_id) REFERENCES FH_Angehöriger (id)
      ON DELETE CASCADE
      ON UPDATE RESTRICT
);

CREATE TABLE Student(
Matrikelnummer CHAR (9) PRIMARY KEY CHECK (CHAR_LENGTH(Matrikelnummer) = 8 OR CHAR_LENGTH(Matrikelnummer) = 9),
Studiengang ENUM ('ET', 'INF', 'ISE', 'MCD', 'WI') NOT NULL,
FH_Angehöriger_id INT UNSIGNED NOT NULL,
CONSTRAINT `fk_Student_FHAngehöriger`
FOREIGN KEY (FH_Angehöriger_id) REFERENCES FH_Angehöriger (id)
ON DELETE CASCADE
ON UPDATE RESTRICT
);

CREATE TABLE Bestellung(
Nummer INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
Bestellzeitpunkt DATETIME DEFAULT (NOW()),
Abholzeitpunkt DATETIME CHECK (Abholzeitpunkt > Bestellzeitpunkt),
Benutzer_id INT UNSIGNED NOT NULL,
CONSTRAINT `fk_Bestellung_Benutzer`
FOREIGN KEY (Benutzer_id) REFERENCES Benutzer (Nummer)
ON DELETE RESTRICT -- Don't delete a user if he made a order
ON UPDATE RESTRICT
);

CREATE TABLE Kategorie(
ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
Bezeichnung TINYTEXT NOT NULL,

Parent_category_id INT UNSIGNED,
Constraint `Parent_category_id_constraint`
FOREIGN KEY (PARENT_category_id) REFERENCES Kategorie (ID)
ON DELETE SET NULL -- Don't delete subcategories
ON UPDATE RESTRICT,

Image_id INT UNSIGNED,
Constraint `Image_id_constraint`
FOREIGN KEY (Image_id) REFERENCES Bild (ID)
ON DELETE SET NULL -- Losing only the image is okay
ON UPDATE RESTRICT
);

CREATE TABLE Mahlzeit(
ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
Beschreibung TINYTEXT DEFAULT ("Eine sehr leckere Speise"),
Vorrat SMALLINT UNSIGNED DEFAULT (0),
Verfügbar BOOLEAN DEFAULT (0), -- Is this meal orderable?
Name VARCHAR(30),

Kategorie_id INT UNSIGNED NOT NULL,
CONSTRAINT `kategorie_id_constraint`
FOREIGN KEY (Kategorie_id) REFERENCES Kategorie (ID)
ON DELETE CASCADE -- Delete the meal if the whole kategory gets deleted
ON UPDATE RESTRICT
);

CREATE TABLE Preis(
-- ID INT UNSIGNED PRIMARY KEY REFERENCES Mahlzeit (ID)
-- ON DELETE CASCADE,
Mahlzeit_id INT UNSIGNED,
Jahr YEAR,
Gastpreis DOUBLE UNSIGNED NOT NULL,
`MA-Preis` DOUBLE UNSIGNED,
Studentenpreis DOUBLE UNSIGNED,

PRIMARY KEY (Mahlzeit_id, Jahr),
CHECK (Studentenpreis < `MA-Preis`),
CHECK (Gastpreis < 100),
CHECK (`MA-Preis` < 100),
CHECK (Studentenpreis < 100),
CONSTRAINT `Preis_MahlzeitID_Constraint`
FOREIGN KEY (Mahlzeit_id) REFERENCES Mahlzeit (ID)
ON DELETE CASCADE
ON UPDATE RESTRICT
);

CREATE TABLE Enthält(
Bestellung_id INT UNSIGNED NOT NULL,
Mahlzeit_id INT UNSIGNED NOT NULL,
Anzahl INT UNSIGNED DEFAULT (1),

PRIMARY KEY (Bestellung_id, Mahlzeit_id),
FOREIGN KEY (Bestellung_id) REFERENCES Bestellung (Nummer)
ON DELETE CASCADE
ON UPDATE RESTRICT,
FOREIGN KEY (Mahlzeit_id) REFERENCES Mahlzeit (ID)
ON DELETE CASCADE
ON UPDATE RESTRICT
);

CREATE TABLE Hat_Bilder(
Bild_id INT UNSIGNED NOT NULL,
Mahlzeit_id INT UNSIGNED NOT NULL,

PRIMARY KEY (Bild_id, Mahlzeit_id),
FOREIGN KEY (Bild_id) REFERENCES Bild (ID)
ON DELETE CASCADE
ON UPDATE RESTRICT,
FOREIGN KEY (Mahlzeit_id) REFERENCES Mahlzeit (ID)
ON DELETE CASCADE
ON UPDATE RESTRICT
);

CREATE TABLE Zutat(
ID INT UNSIGNED PRIMARY KEY CHECK (ID > 9999 && ID < 100000),
Name VARCHAR (30),
Bio BOOLEAN,
Vegetarisch BOOLEAN,
Vegan BOOLEAN,
Glutenfrei BOOLEAN,
-- Boolean ist ein Tinyint kann also auch >1 werden.
CHECK (Bio = 1 OR Bio = 0)
);

CREATE TABLE Mahlzeiten_Enthält_Zutaten(
ID INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
Zutat_id INT UNSIGNED NOT NULL,
Mahlzeit_id INT UNSIGNED,

CONSTRAINT `Mahlzeit_Zutat_ZutatID_Constraint`
FOREIGN KEY (Zutat_id) REFERENCES Zutat (ID)
ON DELETE CASCADE
ON UPDATE RESTRICT,
CONSTRAINT `Mahlzeit_Zutat_MahlzeitID_Constraint`
FOREIGN KEY (Mahlzeit_id) REFERENCES Mahlzeit (ID)
ON DELETE SET NULL
ON UPDATE RESTRICT
);

CREATE TABLE Deklaration(
Zeichen CHAR (2), -- Right Padded with spaces, removed when retrieved
Beschriftung CHAR (32),
PRIMARY KEY (Zeichen)
);

CREATE TABLE Deklaration_Braucht_Mahlzeit(
Deklaration_zeichen CHAR (2) NOT NULL,
Mahlzeit_id INT UNSIGNED NOT NULL,

PRIMARY KEY (Deklaration_zeichen, Mahlzeit_id),
FOREIGN KEY (Deklaration_zeichen) REFERENCES Deklaration (Zeichen)
          ON DELETE CASCADE
          ON UPDATE RESTRICT,
FOREIGN KEY (Mahlzeit_id) REFERENCES Mahlzeit (ID)
          ON DELETE CASCADE
          ON UPDATE RESTRICT
);

CREATE TABLE Kommentar(
ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
Bemerkung VARCHAR (256),
Bewertung TINYINT UNSIGNED,

Mahlzeit_id INT UNSIGNED,
CONSTRAINT `Kommentar_MahlzeitID_constraint`
FOREIGN KEY (Mahlzeit_id) REFERENCES Mahlzeit (ID)
         ON DELETE SET NULL
         ON UPDATE RESTRICT
);

INSERT INTO Benutzer (`E-Mail`, Nutzername, Hash, Vorname, Nachname)
VALUES
('leo@gmail.de', 'Fred', '1ABC1', 'Leonhard', 'Kipp'),
('super@gmail.de', 'Hulk', '2ABC2', 'Super', 'Man'),
('spider@gmail.de', 'Superman', '3ABC3', 'Spider', 'Man'),
('stark@gmail.de', 'Superwoman', '4ABC4', 'Tony', 'Stark');

INSERT INTO FH_Angehöriger(Benutzer_id)
VALUES
(1),
(2),
(3);

INSERT INTO Mitarbeiter(FH_Angehöriger_id)
VALUES
(1);

INSERT INTO Student(Matrikelnummer, Studiengang, FH_Angehöriger_id)
VALUES
(11111111, 'ET', 2),
(22222222, 'INF', 3);

-- SELECT * FROM Benutzer;
-- SELECT * FROM FH_Angehöriger;
-- SELECT * FROM Mitarbeiter;
-- SELECT * FROM Student;

-- DELETE FROM Benutzer WHERE NUMMER=1;
-- DELETE FROM Benutzer WHERE NUMMER=2;

-- SELECT * FROM Benutzer;
-- SELECT * FROM FH_Angehöriger;
-- SELECT * FROM Mitarbeiter;
-- SELECT * FROM Student;

ALTER TABLE Preis DROP CONSTRAINT `Preis_MahlzeitID_Constraint`;
ALTER TABLE Preis Add CONSTRAINT `Preis_MahlzeitID_Constraint`
          FOREIGN KEY (Mahlzeit_id) REFERENCES Mahlzeit (ID)
          ON DELETE CASCADE
          ON UPDATE RESTRICT;

ALTER TABLE Mahlzeiten_Enthält_Zutaten DROP CONSTRAINT `Mahlzeit_Zutat_MahlzeitID_Constraint`;
ALTER TABLE Mahlzeiten_Enthält_Zutaten Add CONSTRAINT `Mahlzeit_Zutat_MahlzeitID_Constraint`
FOREIGN KEY (Mahlzeit_id) REFERENCES Mahlzeit (ID)
ON DELETE SET NULL
ON UPDATE RESTRICT;


ALTER TABLE Kommentar DROP CONSTRAINT `Kommentar_MahlzeitID_constraint`;
ALTER TABLE Kommentar ADD CONSTRAINT `Kommentar_MahlzeitID_constraint`
FOREIGN KEY (Mahlzeit_id) REFERENCES Mahlzeit (ID)
ON DELETE SET NULL
ON UPDATE RESTRICT;

ALTER TABLE Kategorie DROP CONSTRAINT `Parent_category_id_constraint`;
ALTER TABLE Kategorie ADD CONSTRAINT `Parent_category_id_constraint`
FOREIGN KEY (PARENT_category_id) REFERENCES Kategorie (ID)
ON DELETE SET NULL -- Don't delete subcategories
ON UPDATE RESTRICT;

ALTER TABLE Kategorie DROP CONSTRAINT `Image_id_constraint`;
ALTER TABLE Kategorie ADD CONSTRAINT `Image_id_constraint`
FOREIGN KEY (Image_id) REFERENCES Bild (ID)
ON DELETE SET NULL
ON UPDATE RESTRICT;

-- Create table zutaten
INSERT INTO Zutaten(ID, Name, Bio, Vegan, Vegetarisch, Glutenfrei)
SELECT pz.ID + 10004, pz.Name, pz.Bio, pz.Vegan, pz.Vegetarisch, pz.Glutenfrei
FROM public.zutaten pz;
