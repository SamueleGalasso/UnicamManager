<p align="center">
  <img src="https://www.unicam.it/sites/default/files/logoUNICAM-full.jpg" width="50%">
</p>

---

<p align="center">
<img src="https://forthebadge.com/images/badges/made-with-javascript.svg"/>
  <img src="https://forthebadge.com/images/badges/60-percent-of-the-time-works-every-time.svg"/>
  <img src="https://forthebadge.com/images/badges/built-with-love.svg"/><br></br>
    <b>UnicamManager</b>, progetto realizzato in <b>PHP</b> con l'ausilio di <b>AdminLte 3</b> per il corso di laurea <b>L-31</b> presso <b>Unicam</b>, <i>nell'anno accademico 2019/2020</i>, realizzato dallo studente <b>Samuele Galasso</b>
<a href="https://www.unicam.it/">• Unicam</a>
<a href="https://it.wikipedia.org/wiki/Licenza_MIT">• Licenza</a>
</b></p>

L’applicazione Web sviluppata ha lo scopo di valutare le strutture amministrative di Unicam e i dipendenti tecnico-amministrativi che vi lavorano su richiesta del responsabile dell’ufficio Qualità dell’Università. Questa procedura veniva precedentemente effettuata tramite fogli elettronici senza alcun tipo di persistenza dei dati il che può essere problematico quando si tratta di dati così importanti e sensibili. 
Presentiamo quindi una Web Application, che consente la gestione Amministrativa e Monetaria del personale tecnico-amministrativo, in relazione al completamento di obiettivi prefissati dal piano accademico dell’Università di Camerino. 
Lo scopo del sistema è quello di permettere, una volta deciso il Budget del Piano Annuale, di assegnarne una parte ad ogni Area Amministrativa che vi partecipa. Successivamente per quanto riguarda la sezione dedicata all’Università, il Piano Annuale viene suddiviso in uno o più Obiettivi, a loro volta suddivisi in uno o più Target. Inoltre, ogni Target ha uno o più indicatori che ne determinano la percentuale di completamento, ogni entità ha un peso espresso in percentuale grazie al quale viene calcolato dinamicamente il budget preso dal Piano corrispondente e la percentuale di completamento. Per quanto riguarda la sezione dedicata all’Area Amministrativa, abbiamo la possibilità di creare un’Azione Organizzativa scegliendo una serie di parametri, tra cui l’Area Amministrativa di riferimento, da cui viene ricavato il budget attribuito in fase di creazione del Piano Annuale e uno o più Obiettivi di cui abbiamo parlato precedentemente. Le Azioni Organizzative vengono divise in uno o più Target/Risultato Atteso, che possono essere intese come una serie di Goals ai quali possono essere assegnati i dipendenti tecnico-amministrativi registrati nel sistema. Inoltre, vengono attribuiti uno o più Indicatori ad ogni Target/Risultato Atteso per determinarne la percentuale di completamento e di conseguenza la premialità monetaria che spetta ad ogni dipendente che ha partecipato al Target, quest’ultima viene anche calcolata in base alla percentuale di coinvolgimento (un parametro espresso in percentuale) nel realizzare il Target. Tutto il sistema, in particolare la distribuzione dei budget viene influenzata dal peso espresso in percentuale di ogni entità. 


## Tecnologie e struttura del progetto

Il progetto utilizza un'architettura layered costiutita da tre strati:

#### Backend:

- Linguaggio PHP per il back end
- Il carico del lavoro è stato suddiviso usando il pattern MVC separando al meglio le responsabilità all'interno del sistema
- Apache come WebServer

#### Frontend:

- Non è stato usato nessun framework
- Realizzato con l'ausilio del plugin AdminLte 3

#### Persistenza

- Il database utilizzato è MySql in localhost in particolare è stata sfruttata l'interfaccio PhPMyAdmin

## Avvio della piattaforma:

- Eseguire il dump unicam_manager_dump.sql per importare le tabelle del database
- Scaricare Xampp e assicurarsi di avere Apache e MySqlServer attivi
- Indirizzo della piattaforma in locale: http://localhost/unicamManager/
- Dati di accesso come admin Username -> admin Password -> admin
