## COMMANDS

per front
```bash
npm run dev
```
per il back
```bash
php artisan serve --port=8003
```
per eseguire test 
```bash
php artisan test 
```
per creare un controller 
```bash
php artisan make:controller <nomeFile>
```
per creare un model
```bash
php artisan make:model <nomeModel>
```
per migrare il db che abbiamo creato o modificato
```bash
git artisan migrate
```
se è in un db che non esiste nel nostro .env
```bash
php artisan migrate --database=<nomeDataBaseSecondary>
```
se il nome di db è in .env.testing
```bash
php artisan migrate --env=testing
```
per creare o modificare la tabella in db devo fare per forza questo 
```bash
php artisan make:migration create_nome_table --path=database/migrations/doveVorreiSalvare
```
per eliminare una tabella elimino file e lo elimino anchè dal db di migrations 

se c'è una tabella e vorrei creare una nuova tabella con lo stesso nome che non lo fa allora puoi usare questo 
```bash
php artisan migrate --force
```
per creare un file di test devi fare 
```bash
php artisan make:test <nomeFileTest>
```
per eseguire il test 
```bash
php artisan test 
```
fa test di tutto oppure 
```bash
php artisan test --filter <nomefileTest>
```
per installare composer e aggiornare 
```bash
composer install
```
```bash
composer update
```
questi commandi importanti sono per pulire catch
```bash
composer dump-autoload
php artisan cache:clear
php artisan config:clear
```
per creare .env.testing lo creo come semplice file poi 
```bash
cp .env .env.testing
```
faccio coppia in colla al file il nostro env poi 
```bash
php artisan key:generate --env=testing
```
creo un chiave poi faccio test 
ci sono due commandi importanti e metto qua per non dimenticare
```bash
ls app/Http/Middleware/
nano app/Http/Middleware/VerifyCsrfToken.php
```
e questo file è per creare manualmente un file come middleware
```bash
touch app/Http/Middleware/VerifyCsrfToken.php
```
oppure per cercare un file
```bash
find vendor/laravel/framework/src -name "VerifyCsrfToken.php"
```
per creare una cartella 
```bash
mkdir -p tests/Unit
```
```bash

php --ini | grep xdebug
```
