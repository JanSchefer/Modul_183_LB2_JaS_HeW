# LB2 Applikation

Diese Applikation ist eine Version der Application, die wir als Schueler im Rahmen der LB2 im [Modul 183](https://gitlab.com/ch-tbz-it/Stud/m183/m183) erhalten haben. In unserer Version sind alle Schwachstellen, die wir gefunden haben gefixt. Zudem haben wir logging-funktionen zur Applikation hinzugefuegt.

## Hinweise zur Installation
Zum starten `docker compose up` nutzen. Wichtig: die DB wird nicht automatisch erzeugt. Verbinden Sie sich dafür mit einem SQL-Client Ihrer Wahl auf den Datenbankcontainer (localhost port 3306) und verwenden Sie [m183_lb2.sql](./todo-list/m183_lb2.sql), um die Datenbank / Datenstruktur zu erzeugen. Beachten Sie, dass die Datenbank nach einem "neu bauen" des Containers wieder weg sein wird und Sie diese nochmals anlegen müssten.

## Default Users
'admin1'  -  'Awesome.Pass34' <br/>
'user1'   -  'Amazing.Pass23'
