# Dossier - Leonhard Kipp
# 3188047

#Teampartner
Name: Martin Weber
E-Mail: martin.weber1@alumni.fh-aachen.de
Matrikelnummer: 3187679

# Meilenstein 2
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


