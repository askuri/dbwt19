# Dossier - Leonhard Kipp
# 3188047

#Teampartner
Name: Martin Weber
E-Mail: martin.weber1@alumni.fh-aachen.de
Matrikelnummer: 3187679

# Meilenstein 2 Paket 2
## Abspeicherung Studiengang
- Als Enum:
    -Vorteil: DB überprüft richtigkeit v. Studiengang bei Eingabe
    -Nachteil: Schwerer erweiterbar --> neuer Studiengang --> DB ändern.
- Als String:
    -Vorteile und Nachteile von Enum aber umgekehrt

## Darstellung von Relation
- M zu N --> Eigene Tabelle mit 2 FK. PK ist (FK1, FK2)
- 1 zu N --> FK in Entität das nur mit 1 anderer Entität in Beziehg. steht

## Spezialisierung 
- Spezialiserte Entität erhält FK zu Oberentität
- Keine Umsetzung von Kardinalitäten (Ein Benutzer kann Gast u. Fh Angehöriger sein). 

## Semikolon
- Beendet ein Statement

## Tabellen vs Spalten Constraints
- Tabellen constraint immer gecheckt, wenn Änderung an einer Zeile und Änderung in Zusammenhang mit anderen Spaltenwerten stimmen muss.
- Spalten constraint gecheckt, wenn Wert in Spalte sich ändert und nur Wert ohne Beachtung anderer Spalten geprüft werden muss.
- Spalten constraint benutzen, wenn nur eine Spalte für Constraint überprüft werden muss
- Table constraint wenn Check über mehrere Attribute

## Enumemulation
- Datentyp: Char
- Check(wert = 'value1' OR wert = 'value2' ...)

## Constraints
- Primary Key --> Primary key festlegen
- Foreign Key --> Spalte zu foreign key machen und Referenz festlegen
- Unique --> Spalte(n)-Werte dürfen maximal 1 mal vorkommen.
- Check --> Überprüft einen Wert (Gleichheit, Ungleichheit, Kleiner...)

## Information Schema
- Speicher metadaten zu Tablen (Attribute, Constraints, Funktionen)/ Datenbank

## Verschiedenes
Bei Foreign Key
ON UPDATE RESTRICT --> Nur änderungen des referencierten primary keys restrikted
PRIMARY KEY (kurz einfach KEY) impliziert NOT NULL

DATETIME == Datum mit Uhrzeit (Abgelesen aus Calender + Uhr)
TIMESTAMP == UNIX Timestamp 
DATETIME bevorzugen, weil native und in TIMESTAMP überführbar!

Phone number --> International standard 15 digits
## DATETIME Timezone abhängig!!!!!!!! TIMESTAMP nicht

## Schwache Entität
ID INT UNSIGNED PRIMARY KEY REFERENCES Mahlzeit (ID)
           ON DELETE CASCADE,

# Meilenstein 2 Paket 3
## Erstellen von Snippets
- Navigation oben und unten gleich.
- Html header auch immer gleich, da jede Seite bootstrap + Font awesome
- Html ende immer gleich

## Anzeigen von Anzahl Elemente in Zutaten Tabell
- SQL Query "Select COUNT(ID) FROM Zutaten"
- oder Result Klasse hat attribut "num_rows"

## Kopieren der Zutaten Tabelle
-- copy from public
INSERT INTO Zutaten(ID, Name, Bio, Vegan, Vegetarisch, Glutenfrei)
	SELECT pz.ID + 10004, pz.Name, pz.Bio, pz.Vegan, pz.Vegetarisch, pz.Glutenfrei
	FROM public.zutaten pz;
    
## Diverses
- PHP ist kein JavaScript
    -Ausführen von Querys bei Klick auf Button funktioniert nicht.

# Meilenstein 3 Paket 1
## Mahlzeiten filtern
- Momentane Implementierung erlaubt nur Oberkategorie - mehrere Unterelemente --> Keine tiefere Verschachtelung
- hat ist sehr schlechter Bezeichner
- Frage: Wie Query abändern, sodass nur Kategorien mit Gerichten auftauchen:
SELECT k.ID, k.Bezeichnung, k.hat FROM Kategorien k
WHERE 1 = EXISTS(SELECT * FROM Mahlzeiten m 
					WHERE m.KategorieID = k.ID)
ORDER BY CASE WHEN k.hat IS NULL THEN k.ID ELSE k.hat END, k.hat;
 --> WHERE Exists hinzufügen
 
## Benutzeranmeldung
- verify hasht passwort und vergleicht hash mit gegebenem Hash.
- Nicht möglich passwort mit hash zu vergleichen, da per se unterschiedlich

## Ins Dossier
- Cookie gesetzt nachdem man in Session schreibt --> Damit Webserver client wiedererkennen kann. 
- Meiner war: 7e56p1mtgqtl99apiso5h3illf
- Bei löschen des Cookies und neuer Request --> Neue Session zugewiesen und damit neuer Cookie-Value
- Wie Anmeldung ohne Sessions: 
   Benutzerdaten in Datenbank abspeichern
- Procedure für preis für BenutzerID + MahlzeitId 
CREATE PROCEDURE price_for_user
(IN userID INT, IN productID INT)

 BEGIN
	DECLARE  
	 SELECT 
	 	CASE SELECT Rolle FROM Nutzerrolle n WHERE n.Nummer = userID
	 	WHEN 'Student' THEN
	 		BEGIN
		 	SELECT p.Studentpreis FROM Preise p WHERE p.MahlzeitenID = productID;
			END;
		WHEN 'Mitarbeiter' THEN
			BEGIN
		 	SELECT p.`MA-Preis` FROM Preise p WHERE p.MahlzeitenID = productID;
		 	END
		ELSE 
			BEGIN
			SELECT p.Gastpreis FROM Preise p WHERE p.MahlzeitenID = productID;
			END
		END CASE;
 END;

# Meilenstein 3 Paket 2
## Probleme bei MVC
- Wo kommt die Logik der Datenbankabfrage hin?
    - Models sollte mMn nur DB Tabelle wiederspiegeln
    - Evtl Repository Pattern ?
- Function already defined Probleme
    - Gleiche Datei mehrmals inkludiert --> require_once statt require
- Produkte.php leiten teils noch _GET etc weiter. Nötig? Sind die Dateien im projekt root Ordner überhaupt noch nötig?


## Registrierung
- Fehlermeldungen: 
Doppelter Benutzername:
Error occurred during SQL script execution
Reason:
SQL Error [1062] [23000]: (conn=279535) Duplicate entry 'askuri' for key 'Benutzer_Unique_Nutzername'

Doppelter E-Mail Eintrag:
Error occurred during SQL script execution
Reason:
SQL Error [1062] [23000]: (conn=279535) Duplicate entry 'leg@liiize.it' for key 'Benutzer_Unique_email'

Doppelter Matrikelnummer:
Error occurred during SQL query execution
Reason:
SQL Error [1062] [23000]: (conn=279535) Duplicate entry '12345678' for key 'Studenten_unique_Matrikelnummer'

Falsche Matrikelnummer:
Error occurred during SQL query execution
Reason:
SQL Error [4025] [23000]: (conn=279535) CONSTRAINT `Studenten_check_Matrikelnummer` failed for `db3188047`.`Studenten`

* Problem bei vielen gleichzeitigen Registrierungen: Viele einzelne Queries mit einzelnen Transaktionen, die evtl Rollback haben --> Hohe Last viel 

## Php diverses
- Namespaces \ statt / 
