allora ci sono 3 modi per salvare image in db allora quello che è più per formante e più pulito è che salviamo image in file di "app/storage/app/public/file" , poi all'interno del nostro repository layer salviamo image qua  e salviamo solo il path di image all'interno del nostro db allrora quello che dobbiamo fare è 

```bash
php artisan storage:link
```
Laravel non rende automaticamente accessibili i file salvati in storage/app/public/.
Per poter mostrare le immagini, devi creare un link simbolico.
Questo comando crea un link simbolico in public/storage/ che punta a storage/app/public/.
✅ Ora puoi accedere ai file salvati tramite URL pubblici come:

INFO  The [public/storage] link has been connected to [storage/app/public].

bash
Copia
Modifica
```bash
http://localhost:8003/storage/announcements/nomefile.jpg
```
ora 
```bash
injaunja/
 ├── storage/
 │   ├── app/
 │   │   ├── public/
 │   │   │   ├── announcements/  <-- Qui verranno salvate le immagini
 ├── public/
 │   ├── storage/  <-- Link simbolico creato

```
✅ Se la cartella storage/app/public/announcements/ non esiste, creala manualmente:

sh
Copia
Modifica
```bash
mkdir -p storage/app/public/announcements
```
✅ Dai i permessi corretti alla cartella per evitare errori di accesso:


```bash
chmod -R 775 storage/
chmod -R 775 storage/app/public/
chmod -R 775 storage/app/public/announcements/
```
Se hai problemi di permessi, puoi anche usare:

```bash
sudo chown -R www-data:www-data storage
```
📌 Dopo aver caricato un'immagine, verifica se viene salvata correttamente in:
```bash
storage/app/public/announcements/
ls -l storage/app/public/announcements/

```
```bash
ls -l storage/app/public/announcements/
```
Ora che le immagini sono salvate in storage/app/public/announcements/, possiamo mostrarle nel frontend.

```bash
<img :src="'/storage/' + announcement.image" v-if="announcement.image" alt="Immagine annuncio">
```
📌 Se l'immagine è salvata come announcements/house123.jpg, allora l'URL sarà:

```bash
http://localhost:8000/storage/announcements/house123.jpg
```

📌 🔥 Conclusione
✅ Abbiamo configurato Laravel per salvare le immagini correttamente!
✅ Il filesystem è pronto e le immagini sono accessibili via /storage/announcements/.
✅ Ora puoi gestire il caricamento e la visualizzazione senza problemi.

il metodo che salva image all'interno di file storage è 
```bash
use Illuminate\Http\UploadedFile;

public function saveImage(UploadedFile $image):string
    {
        return $image->store('announcement','public');

    }
```
