# LB2 Applikation
Diese Applikation ist bewusst unsicher programmiert und sollte nie in produktiven Umgebungen zum Einsatz kommen. Ziel der Applikation ist es, Lernende für mögliche Schwachstellen in Applikationen zu sensibilisieren, diese anzuleiten, wie die Schwachstellen aufgespürt und geschlossen werden können.

Die Applikation wird im Rahmen der LB2 im [Modul 183](https://gitlab.com/ch-tbz-it/Stud/m183/m183) durch die Lernenden bearbeitet.

## Hinweise zur Installation
Bevor mit `docker compose up` die Applikation gestartet wird, muss der Source-Pfad für's Volume an Ihre Umgebung angepasst werden (dass die todo-list-Applikation auch korrekt in den Container rein gelinkt wird). Wichtig: die DB wird nicht automatisch erzeugt. Verbinden Sie sich dafür mit einem SQL-Client Ihrer Wahl auf den Datenbankcontainer (localhost port 3306) und verwenden Sie [m183_lb2.sql](./todo-list/m183_lb2.sql), um die Datenbank / Datenstruktur zu erzeugen. Beachten Sie, dass die Datenbank nach einem "neu bauen" des Containers wieder weg sein wird und Sie diese nochmals anlegen müssten.

## Default Users
'admin1'  -  'Awesome.Pass34' <br/>
'user1'   -  'Amazing.Pass23'

## Logs to find per file
todo-list
- admin
  - #### users.php - 1 log
    - Database error occures
- fw
  - #### db.php - 1 log
    - Database error occures
- search
  - v2
    - #### index.php - 4 log
      - Before successfull search
      - After successfull search with results (first 5 entries)
      - After successfull search with results (amount of all entries)
      - After successfull search with no results
- user
  - #### tasklist.php - 1 log
    - Database error occures
- #### edit.php - 2 logs
  - starting to edit a task
  - starting to create a task
- #### login.php - 4 logs
  - Database error occures
  - Successfully logging in
  - Logging in with wrong Password
  - Logging in with non existant Username
- #### logout.php - 1 log
  - Logging out
- #### savetask.php - 4 logs
  - Before successfull creation of new Task
  - After successfull creation of new Task
  - Before successfull update of Task
  - After successfull update of Task

## TODO
What needs to be done?
3. Figure out what’s wrong in lines 49 and 50 of backgroundsearch.php
4. Sanitise for XSS
5. Find out why delete.php despawned (referenced in user/tasklist.php, ln44)
6. Find out what the abomination in the CallAPI function in search is, and probably remove the switch case there, replacing it with only the default
8. Get images


7. Encryption (if possible) (not just URL requests, but entire message bodies are in plain text) (example: savetask)
  - While URL shouldn’t be encrypted, body should. 
  - Move info from URL to body in search/v2/index.php