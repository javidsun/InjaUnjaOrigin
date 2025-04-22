## About GIT

quello che ho imparato di git e voglio mettere qua in documentazione per non dimenticare più
allora prima di tutto 

vi presento il concetto di branche principale che in questo caso si chiama "develompment"

#### Development

```bash
git development checkout
```
```bash
git fetch
```
```bash
git pull
```
oppure posso fare click al git di sopra e fare  [Update]() 

poi dopo di questo devo creare un [new branch from development]()
poi seleziono un nome per questo 

#### < new branch >
in questo caso vedi che viene aperto un branch aggiornato dal development che in questo caso abbiamo bisogno di modificare il mio progetto in modo corretot allora dopo di che lo modifico come posso creare un [PULL REQUEST o MERGE REQUEST ]()
allora vediamo come si fa  
##### step 1 
seleziono file modificato e commit oppure con questo commando faccio commit
```bash
git commit 
```
dopo di che ho fatto commit devo fare push 
```bash
git push 
```
se sia il primo push mi da un nuovo suggerimento di git  push che è diverso con questo 
se non sia la prima push dobbiamo fare questo commando 
```bash
git push --force-with-lease
```
ma non dimenticare che non sia anchè il primo push dobbiamo fare commit $ [AMEND]()che in php storm c'è un checkbox per selezionarlo 

##### step due 
ora le nostre modifiche si è finito ora vogliamo mergiare il nostro MR o PR allora 
devo rebasare il mio <new branch > dal branch principale che si chiama development
allora devo fare qualche operazioni prima 
1- o faccio checkout development 
```bash
git checkout development
```
```bash
git fetch
```
```bash
git pull
```
poi torno al mio <new branch> oppure nel mio branch 
faccio 
```bash
git fetch 
```
faccio pull per aggiornare il mio branch che magari qualcuno dall'altra parte hanno modificato il mio branch allora 
```bash
git pull --rebase
```
ora possiamo rebasare il mio branch dal development 
```bash
git rebase development 
```
ora se ci sono confilitto lo devo risolvere che quelli modifihe al destra della pagina è degli altri e quello in sinistra sono i miei allora dopo di modifica faccio 
[continue]()
ora il nostro <new branch > si è rebasato dal development e facciamo [amend]()
poi 
```bash
git push --force-with-lease
```
ora il nostro PR o MR si è a posto se non ci sono CS-fixer [command + option + L]()
o test 
```bash
php artisan test
```
possiamo mergiare il nostro branch [Merge]()
poi cancelliamo branch attuale 


ci sono due commandi che magari ci serveranno allora sono 
```bash
git stash save
```
questo quando vogliamo cambiare una branch senza commitarlo e per restituirlo facciamo 
```bash
git stash pop
```
per fare git ignor un file come file di laravel.log 
```bash
git rm --cached storage/logs/laravel.log
git commit -m
git push --force-with-lease
```

e la stessa cosa per il file /storage/framework/views/*
```bash
git rm --cached -r storage/framework/views
git commit -m "Ignorati i file di cache delle views"
git push origin main
```
per verificare se ci sono altri file indesiderati 
```bash
git status
```




