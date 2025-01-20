# Data processing
Leden:
Aaron de Bruin, 
Dave van den Berg, 
Lucas Wanink, 
Lucas Lübbers

## Installatie
Clone de repository:
```
git clone git@github.com:IC-INF2-dataprocessing/laravel.git
cd laravel
```
Voeg de .env bestand toe in de netflix-clone folder (staat in de onedrive).

Voer de volgende commandos uit in de terminal in de root map:
```
make setup (als dit niet werkt verander the backup_script.sh en cron_setup.sh in Visual Studio Code van CRLF naar LF)
make up
make data
```

## phpMyAdmin
De inloggegevens van phpMyAdmin kan je vinden in de .env
```
Voor Server kan je het vinden onder: DB_HOST
Voor Username kan je het vinden onder: DB_USERNAME
Voor Password kan je het vinden onder: DB_PASSWORD
```

## Tests
De Postman tests staan in de onedrive. De tests zijn onderverdeeld in collections, buiten de collections staat de 'login' request. Deze request moet je eerst runnen om de acces token op te halen. Kopieer deze en zet hem in de bovenste collectie onder 'authorization'. Hierna kan je alle tests runnen.
