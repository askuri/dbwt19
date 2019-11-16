-- SQL DDL Intro aus der Übung

-- TODO
-- dann bei den späteren aufgaben weiter. es gibt noch einen foreign key fehler, der durcj die bennenung leichter zu fixen sein soltle

-- KONVENTIONEN
-- Relationen: Entität1VerbEntität2
-- Constraint namen beginnen immer mit dem namen der tabelle in der sie geschrieben stehen

-- FRAGEN
-- - named constraints inkl keys wirklich überall durchsetzen? syntax: https://www.w3schools.com/sql/sql_primarykey.asp
	-- - ne. nur auf unique, fk und check
-- - in wie fern datentypen optimieren? auch PKs optimieren?


-- Ihre Datenbank auswählen, ändern Sie den Namen entsprechend...
-- USE `db3187679`;
USE `db3188047`;
-- Empfohlen ist, zuerst die Attribute der Tabellen anzulegen und die Relationen 
-- anschließend vorzunehmen. dabei werden Sie erkennen, dass nicht jede Lösch-
-- reihenfolge (DROP) funktioniert.

-- Relationen löschen
DROP TABLE IF EXISTS BenutzerBefreundetMit;
DROP TABLE IF EXISTS BestellungenEnthältMahlzeiten;
DROP TABLE IF EXISTS MahlzeitenBrauchtDeklarationen;
DROP TABLE IF EXISTS MahlzeitenEnthältZutaten;
DROP TABLE IF EXISTS MahlzeitenHatBilder;
DROP TABLE IF EXISTS `FH AngehörigeGehörtZuFachbereiche`;


-- Entitäten löschen
-- Entität "an den rändern"
DROP TABLE IF EXISTS `Fachbreiche`;
DROP TABLE IF EXISTS `Zutaten`;
DROP TABLE IF EXISTS `Deklarationen`;
DROP TABLE IF EXISTS `Preise`;
DROP TABLE IF EXISTS `Kommentare`;

-- Entität wo vorsicht geboten ist
DROP TABLE IF EXISTS `Mitarbeiter`;
DROP TABLE IF EXISTS `Studenten`;
DROP TABLE IF EXISTS Bestellungen; -- Foreign key auf benutzer
DROP TABLE IF EXISTS `Gäste`; -- Foreign key von Bestellungen
DROP TABLE IF EXISTS `FH Angehörige`; -- Foreign key von Bestellungen
DROP TABLE IF EXISTS Benutzer; -- Foreign key von Bestellungen
DROP TABLE IF EXISTS Mahlzeiten; -- Foreign key von ... ner menge. also ans ende
DROP TABLE IF EXISTS `Kategorien`;
DROP TABLE IF EXISTS `Bilder`;

-- -----------------
CREATE TABLE Benutzer (
	Nummer INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`E-Mail` VARCHAR(255) NOT NULL, -- Backticks wegen Minus im namen
	Bild VARBINARY(1000) NOT NULL, -- verbessern Sie die Datentypen, wenn nötig
	Nutzername VARCHAR(50) NOT NULL, -- NOT NULL weil nicht optional
	
	-- Auth
	`Hash` CHAR(60) NOT NULL, -- immer 60 zeichen lang
	LetzterLogin DATETIME DEFAULT NULL,
	
	Anlegedatum DATETIME NOT NULL,
	Aktiv BOOL NOT NULL,
	
	-- Name
	Vorname VARCHAR(50) NOT NULL,
	Nachname VARCHAR(50) NOT NULL,
	
	Geburtsdatum DATE,
	
	CONSTRAINT Benutzer_PK PRIMARY KEY (`Nummer`),
	CONSTRAINT Benutzer_Unique_email UNIQUE(`E-Mail`),
	CONSTRAINT Benutzer_Unique_Nutzername UNIQUE(`Nutzername`)
);


-- -----------------
-- Verwende Vertikale Positionierung
-- Fremdschlüssel definieren?
CREATE TABLE `Gäste` (
	`Nummer` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`Grund` VARCHAR(254) NOT NULL,
	`Ablaufdatum` DATE NOT NULL DEFAULT DATE_ADD(NOW(), INTERVAL 1 WEEK),
	PRIMARY KEY (Nummer),
	CONSTRAINT Gäste_FK_Benutzer FOREIGN KEY (Nummer) REFERENCES Benutzer(Nummer)
		ON DELETE CASCADE -- kaskadiertes löschen aus 2.3
);


-- -----------------
-- Verwende Vertikale Positionierung
CREATE TABLE `FH Angehörige` (
	`Nummer` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (Nummer),
	CONSTRAINT FH_FK_Benutzer FOREIGN KEY (Nummer) REFERENCES Benutzer(Nummer)
		ON DELETE CASCADE -- kaskadiertes löschen aus 2.3
);


-- -----------------
CREATE TABLE `Fachbreiche` (
	`ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`Website` VARCHAR(255) NOT NULL,
	`Name` VARCHAR(50) NOT NULL,
	
	PRIMARY KEY(`ID`)
);

-- ----------------
CREATE TABLE `Mitarbeiter` (
	`Nummer` INT UNSIGNED NOT NULL,
	`Büro` VARCHAR(20),
	`Telefon` VARCHAR(20),
	
	PRIMARY KEY (Nummer),
	CONSTRAINT Mitarbeiter_FK_FH_Angehörige FOREIGN KEY (Nummer) REFERENCES `FH Angehörige`(Nummer)
		ON DELETE CASCADE -- kaskadiertes löschen aus 2.3
);


CREATE TABLE `Studenten` (
	`Nummer` INT UNSIGNED NOT NULL,
	`Studiengang` ENUM('ET', 'INF', 'ISE', 'MCD', 'WI') NOT NULL,
	`Matrikelnummer` MEDIUMINT UNSIGNED NOT NULL,
	
 	PRIMARY KEY (Matrikelnummer),
	CONSTRAINT Studenten_check_Matrikelnummer CHECK(Matrikelnummer >= 10000000 AND Matrikelnummer < 1000000000),
	CONSTRAINT Studenten_FK_FH_Angehörige FOREIGN KEY (Nummer) REFERENCES `FH Angehörige`(Nummer)
		ON DELETE CASCADE -- kaskadiertes löschen aus 2.3
);


-- --------
CREATE TABLE `Bestellungen` (
	`Nummer` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	BenutzerNummer INT UNSIGNED,
	`BestellZeitpunkt` DATETIME NOT NULL DEFAULT(NOW()),
	`AbholZeitpunkt` DATETIME,
	-- Endpreis?
	
	PRIMARY KEY (`Nummer`),
	CONSTRAINT Bestellungen_FK_Bestellungen FOREIGN KEY (BenutzerNummer) REFERENCES Benutzer(Nummer), -- "Benutzer tätigt Bestellungen"
	CONSTRAINT Bestellungen_check CHECK(AbholZeitpunkt > BestellZeitpunkt)
);

-- -----------------
CREATE TABLE `Bilder` (
	`ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`Alt-Text` VARCHAR(50) NOT NULL,
	`Titel` VARCHAR(50),
	`Binärdaten` BLOB(1000) NOT NULL,
	
	PRIMARY KEY (`ID`)
);

-- -----------------
-- Muss vor Mahlzeiten, da Foreign key
CREATE TABLE `Kategorien` (
	`ID` INT UNSIGNED NOT NULL AUTO_INCREMENT, -- pk
	`BilderID` INT UNSIGNED, -- fk
	`Bezeichnung` VARCHAR(50) NOT NULL,
	hat INT UNSIGNED, -- für rekursive beziehung
	
	PRIMARY KEY (`ID`),
	CONSTRAINT Kategorien_FK_Kategorien FOREIGN KEY (hat) REFERENCES Kategorien(ID), -- "Kategorie hat Kategorien"
	CONSTRAINT Kategorien_FK_Bilder FOREIGN KEY (BilderID) REFERENCES Bilder(ID)
);

-- -----------------
CREATE TABLE `Mahlzeiten` (
	`ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  -- Name ist selber hinzugefügt
	KategorieID INT UNSIGNED,
  Name Varchar(30),
	`Beschreibung` VARCHAR(200) NOT NULL,
	`Vorrat` INT NOT NULL DEFAULT 0,
	
	PRIMARY KEY (`ID`),
	CONSTRAINT Mahlzeiten_FK_Kategorie FOREIGN KEY (KategorieID) REFERENCES Kategorien(ID) -- "Mahlzeiten in Kategorie"
);

-- -----------------
CREATE TABLE `Deklarationen` (
	`Zeichen` VARCHAR(2) NOT NULL,
	`Beschriftung` VARCHAR(32),
	
	PRIMARY KEY(`Zeichen`)
);


-- -----------------
CREATE TABLE `Preise` (
	`ID` INT UNSIGNED NOT NULL AUTO_INCREMENT, -- übernommen aus mahlzeiten da schwache entität
	MahlzeitenID INT UNSIGNED,
	`Jahr` YEAR NOT NULL, -- TODO reference
	`Gastpreis` FLOAT(4,2) UNSIGNED NOT NULL, -- (4,2) = 4 stellen insgesamt, 2 dezimal
	`Studentpreis` FLOAT(4,2) UNSIGNED,
	`MA-Preis` FLOAT(4,2) UNSIGNED,
	
	PRIMARY KEY (ID, Jahr), -- ID übernommen aus mahlzeiten
	CONSTRAINT Preise_FK_Mahlzeiten FOREIGN KEY (MahlzeitenID) REFERENCES Mahlzeiten(ID), -- "kostet"
	CONSTRAINT Preise_check CHECK(`Studentpreis` < `MA-Preis`)
);

-- -----------------
CREATE TABLE `Zutaten` (
-- max 5 lang definiert im Datentyp
`ID` MEDIUMINT(5) UNSIGNED  CHECK (ID > 9999 && ID < 100000), 
	`Name` VARCHAR(50) NOT NULL,
	`Bio` BOOL NOT NULL,
	`Vegan` BOOL NOT NULL,
	`Glutenfrei` BOOL NOT NULL,
	`Vegetarisch` BOOL NOT NULL,
	
	PRIMARY KEY (`ID`)
);


-- -----------------
CREATE TABLE `Kommentare` (
	`ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	MahlzeitenID INT UNSIGNED,
	StudentenID INT UNSIGNED,
	`Bemerkung` VARCHAR(500),
	`Bewertung` TINYINT UNSIGNED NOT NULL,
	
	PRIMARY KEY(`ID`),
	CONSTRAINT Kommentare_FK_Mahlzeiten FOREIGN KEY (MahlzeitenID) REFERENCES Mahlzeiten(ID), -- "Kommentare zu Mahlzeiten"
	CONSTRAINT Kommentare_FK_Studenten FOREIGN KEY (StudentenID) REFERENCES Studenten(Nummer) -- Studenten schreibt Kommentare"
);



-- RELATIONEN


CREATE TABLE BenutzerBefreundetMit (
	Nummer1 INT UNSIGNED NOT NULL,
	Nummer2 INT UNSIGNED NOT NULL,
	
	PRIMARY KEY (Nummer1, Nummer2),
	CONSTRAINT BenutzerBefreundetMit_FK_Benutzer1 FOREIGN KEY (Nummer1) REFERENCES Benutzer(Nummer),
	CONSTRAINT BenutzerBefreundetMit_FK_Benutzer2 FOREIGN KEY (Nummer2) REFERENCES Benutzer(Nummer)
);

CREATE TABLE BestellungenEnthältMahlzeiten (
	Nummer INT UNSIGNED NOT NULL,
	ID INT UNSIGNED NOT NULL,
	Anzahl TINYINT UNSIGNED NOT NULL,
	
	PRIMARY KEY (Nummer, ID),
	CONSTRAINT BestellungenEnthältMahlzeiten_FK_Bestellungen FOREIGN KEY (Nummer) REFERENCES Bestellungen(Nummer),
	CONSTRAINT BestellungenEnthältMahlzeiten_FK_Mahlzeiten FOREIGN KEY (ID) REFERENCES Mahlzeiten(ID)
);

CREATE TABLE MahlzeitenBrauchtDeklarationen (
	ID INT UNSIGNED NOT NULL,
	Zeichen VARCHAR(2) NOT NULL,
	
	PRIMARY KEY (ID, Zeichen),
	CONSTRAINT MahlzeitenBrauchtDeklarationen_FK_Mahlzeiten FOREIGN KEY (ID) REFERENCES Mahlzeiten(ID),
	CONSTRAINT MahlzeitenBrauchtDeklarationen_FK_Deklarationen FOREIGN KEY (Zeichen) REFERENCES Deklarationen(Zeichen)
);

CREATE TABLE MahlzeitenEnthältZutaten (
	`MID` INT UNSIGNED, -- nullable damit on delete set null funktioniert
	`ZID` MEDIUMINT(5) UNSIGNED NOT NULL,
	
	PRIMARY KEY (`ZID`),
	CONSTRAINT MahlzeitenEnthältZutaten_FK_Mahlzeiten FOREIGN KEY (`MID`) REFERENCES Mahlzeiten(ID),
	CONSTRAINT MahlzeitenEnthältZutaten_FK_Zuaten FOREIGN KEY (`ZID`) REFERENCES Zutaten(ID)
);

CREATE TABLE MahlzeitenHatBilder (
	`MID` INT UNSIGNED NOT NULL,
	`BID` INT UNSIGNED NOT NULL,
	
	PRIMARY KEY (`MID`, `BID`),
	CONSTRAINT MahlzeitenHatBilder_FK_Mahlzeiten FOREIGN KEY (`MID`) REFERENCES Mahlzeiten(ID),
	CONSTRAINT MahlzeitenHatBilder_FK_Bilder FOREIGN KEY (`BID`) REFERENCES Bilder(ID)
);

CREATE TABLE `FH AngehörigeGehörtZuFachbereiche` (
	AngehörigenID INT UNSIGNED NOT NULL,
	FbID INT UNSIGNED NOT NULL,
	
	PRIMARY KEY (AngehörigenID, FbID),
	CONSTRAINT FH_AngehörigeGehörtZuFachbereiche_FK_FH_Angehörige FOREIGN KEY (AngehörigenID) REFERENCES `FH Angehörige`(Nummer),
	CONSTRAINT FH_AngehörigeGehörtZuFachbereiche_FK_Fachbereiche FOREIGN KEY (FbID) REFERENCES Fachbreiche(ID)
);


-- Aufgabe 2.3 - Kaskaden
-- Nutzer 1
INSERT INTO Benutzer VALUES (NULL, 'leg@lize.it', '', 'askuri',
	'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
	NULL, NOW(), TRUE, 'Martin', 'Weber', '1997-08-06');

-- Mitarbeiter 1
INSERT INTO Benutzer VALUES (NULL, 'leg@liize.it', '', 'askurii',
	'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
	NULL, NOW(), TRUE, 'Martin', 'Weber', '1997-08-06');
INSERT INTO `FH Angehörige` VALUES (LAST_INSERT_ID());
INSERT INTO Mitarbeiter VALUES (LAST_INSERT_ID(), NULL, NULL);


-- Student 1
INSERT INTO Benutzer VALUES (NULL, 'leg@liiize.it', '', 'askuriii',
	'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
	NULL, NOW(), TRUE, 'Martin', 'Weber', '1997-08-06');
INSERT INTO `FH Angehörige` VALUES (LAST_INSERT_ID());
INSERT INTO Studenten VALUES (LAST_INSERT_ID(), 'INF', 12345678);

-- Student 2
INSERT INTO Benutzer VALUES (NULL, 'leg@liiiize.it', '', 'askuriiii',
	'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
	NULL, NOW(), TRUE, 'Martin', 'Weber', '1997-08-06');
INSERT INTO `FH Angehörige` VALUES (LAST_INSERT_ID());
INSERT INTO Studenten VALUES (LAST_INSERT_ID(), 'INF', 12345679);


-- Weitere Business Rules
-- Punkt 1
ALTER TABLE Preise DROP CONSTRAINT Preise_FK_Mahlzeiten;
ALTER TABLE Preise ADD CONSTRAINT Preise_FK_Mahlzeiten FOREIGN KEY (MahlzeitenID) REFERENCES Mahlzeiten(ID)
	ON DELETE CASCADE;
ALTER TABLE MahlzeitenEnthältZutaten DROP CONSTRAINT MahlzeitenEnthältZutaten_FK_Mahlzeiten;
ALTER TABLE MahlzeitenEnthältZutaten ADD CONSTRAINT MahlzeitenEnthältZutaten_FK_Mahlzeiten FOREIGN KEY (`MID`) REFERENCES Mahlzeiten(ID)
	ON DELETE SET NULL;
ALTER TABLE Kommentare DROP CONSTRAINT Kommentare_FK_Mahlzeiten;
ALTER TABLE Kommentare ADD CONSTRAINT Kommentare_FK_Mahlzeiten FOREIGN KEY (MahlzeitenID) REFERENCES Mahlzeiten(ID)
	ON DELETE SET NULL;

-- Punkt 2
ALTER TABLE Kategorien DROP CONSTRAINT Kategorien_FK_Kategorien;
ALTER TABLE Kategorien ADD CONSTRAINT Kategorien_FK_Kategorien FOREIGN KEY (hat) REFERENCES Kategorien(ID)
	ON DELETE SET NULL;

-- Punkt 3
ALTER TABLE Kategorien DROP CONSTRAINT Kategorien_FK_Bilder;
ALTER TABLE Kategorien ADD CONSTRAINT Kategorien_FK_Bilder FOREIGN KEY (BilderID) REFERENCES Bilder(ID);

-- Zutaten hinzufügen; PK, Name, Bio, Vegan, Glutenfrei, Vegetarisch
INSERT INTO Zutaten VALUES (10000, 'Isombe', TRUE, TRUE, TRUE, TRUE);
INSERT INTO Zutaten VALUES (10001, 'Ibirayi', TRUE, TRUE, FALSE, TRUE);
INSERT INTO Zutaten VALUES (10002, 'Umunyu', FALSE, TRUE, TRUE, TRUE);
INSERT INTO Zutaten VALUES (10003, 'Ifi', TRUE, FALSE, TRUE, FALSE);
INSERT INTO Zutaten VALUES (10004, 'Maismehl', FALSE, TRUE, FALSE, TRUE);

-- Mahlzeiten einfügen
INSERT INTO Kategorien VALUES (NULL, NULL, 'Ruandische Küche', NULL);
INSERT INTO Mahlzeiten VALUES (NULL, LAST_INSERT_ID(), 'Kawunga','Ein Gericht aus Ruanda', 1);
INSERT INTO Preise VALUES (NULL, LAST_INSERT_ID(), 2019, 3.60, 2.10, 99);

INSERT INTO Mahlzeiten VALUES (NULL, NULL, 'Pommes','Frisch aus der Fritteuse', 1);
INSERT INTO Preise VALUES (NULL, LAST_INSERT_ID(), 2019, 3.60, 2.10, 99);

INSERT INTO Mahlzeiten VALUES (NULL, NULL,'Döner', 'Vegetarischer Döner', 1);
INSERT INTO Preise VALUES (NULL, LAST_INSERT_ID(), 2019, 3.60, 2.10, 99);

INSERT INTO Mahlzeiten VALUES (NULL, NULL,'Lasagne', 'Martin kennt nur Fastfood', 1);
INSERT INTO Preise VALUES (NULL, LAST_INSERT_ID(), 2019, 4.10, 2.60, 99);

INSERT INTO Mahlzeiten VALUES (NULL,NULL, 'Pizza', 'Nur Mittwochs!', 1);
INSERT INTO Preise VALUES (NULL, LAST_INSERT_ID(), 2019, 3.60, 2.10, 99);


-- copy zutaten from public
INSERT INTO Zutaten(ID, Name, Bio, Vegan, Vegetarisch, Glutenfrei)
SELECT pz.ID + 10004, pz.Name, pz.Bio, pz.Vegan, pz.Vegetarisch, pz.Glutenfrei
FROM public.zutaten pz;

INSERT INTO MahlzeitenEnthältZutaten(MID, ZID) VALUES
(1, 10000),
(1, 10001),
(1, 10002),
(1, 10003),
(1, 10004),
(2, 10085),
(2, 10086),
(2, 10087),
(2, 10088),
(2, 10089),
(2, 10090),
(3, 10224),
(3, 10274),
(3, 10326),
(3, 10334);

-- Querys
DELETE FROM `Benutzer` WHERE Nummer=4;

SELECT m.Name, m.ID, m.Beschreibung, m.Vorrat, b.`Alt-Text`, b.Binärdaten FROM Mahlzeiten m
	LEFT JOIN MahlzeitenHatBilder mhb ON m.ID = mhb.`MID` -- left join damit Mahlzeiten ohne Bild auch rein kommen
	LEFT JOIN Bilder b ON mhb.BID = b.ID;













