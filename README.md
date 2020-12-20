# svxrdb-server
  - Das svxrdb-server ist ein einfaches Dashboard für den Service svxreflektor(Server/status json).

- INSTALLATION:
  - Den Ordner in das Wurzelverzeichniss vom Webserverdeamon speichern
  - z.B. /var/www/html oder /var/www/html/httpdocs verschieben.
  - Pakete php-curl php-json installieren
  - in der Konfiguration TIMESTAMP_FORMAT="%d.%m.%Y %H:%M:%S" einstellen.

FUNKTIONEN:
  - zeigt den Aktuellen Status vom Client
    - Online / Offline / Icon->"spricht" / Icon->"Kanal belegt"
  - Darstellunglayout der Seite via css
    - (STYLECSS)

TODO:
  - letzte Aussendung mit Zeitstempel versehen
    - geht erst nach Anpassung in der svxreflector.cpp
  - Englische Übersetzung schreiben

## HINWEIS:
  - Den Port und die Serveradresse vom svxreflector in der config.php angeben
  - Die Ladezeit in ms Intervallen in der index.html anpassen.
  
# English
  - Reload Time value(ms) defined in index.html at line 14

## REMARK:
  - Reload Time value(ms) defined in index.html at line 14

Danke für die Ideen und Anregungen an DL7ATA / DJ1JAY 

73 Andy
