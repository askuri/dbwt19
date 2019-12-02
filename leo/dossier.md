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

# Meilenstein 3 Paket 2
## Php diverses
- Namespaces \ statt / 
