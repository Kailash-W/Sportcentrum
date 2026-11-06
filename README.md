# 🏋️‍♂️ Sportcentrum De Linde - Website

Welkom bij de officiële GitHub-repository van het webproject voor **Sportcentrum De Linde**. Dit project is ontwikkeld als onderdeel van de PRA-opdracht en is inmiddels succesvol en definitief opgeleverd. 

De applicatie is gebouwd met het **Laravel**-framework en maakt gebruik van een **MySQL (phpMyAdmin)** database om een sportieve, overzichtelijke en functionele website te bieden voor zowel leden als beheerders.

---

## 📂 Projectdocumentatie & Eisen (`/Docs`)

Alle formele documenten, functionele eisen en visuele ontwerpen die tijdens dit project zijn opgesteld, zijn netjes gecategoriseerd en terug te vinden in de **`Docs`**-folder van deze repository. 

In deze map vind je onder andere:

*   **Plan van Eisen (PvE):** De getekende klantversie (`Plan_van_Eisen_klantversie_v3.docx`) waarin alle functionele en niet-functionele eisen, randvoorwaarden en de scope van het project helder zijn vastgelegd.
*   **Wireframes (Ontwerpen):** De volledige evolutie van het website-ontwerp, inclusief de interactieve HTML-bestand (`wireframe-de-linde-rework.html`). Deze ontwerpen weerspiegelen de sportieve uitstraling en de feedback van de klant. (Download het .html bestand apart om het wireframe te zien.)
*   **Entity Relationship Diagram (ERD):** Het database-ontwerp dat de structuur, tabellen en relaties binnen phpMyAdmin visueel in kaart brengt. (Het ERD zit in ons plannen van eisen bij "Datamodel")
*   **Acceptatiecriteria (Testfase):** Het volledige document dat specifiek ingaat op het testen van onze website, waarin is vastgelegd hoe de applicatie voldoet aan de gestelde kwaliteitseisen.

*Navigeer naar de map `/Docs` bovenin de bestandsstructuur om deze bestanden direct te bekijken of te downloaden.*

(Voor het doc file download het apart.)

---

## ✨ Belangrijkste Functionaliteiten

Op basis van de klanteisen in het PvE bevat de website de volgende kernfunctionaliteiten:
*   **Sportieve Homepage:** Een aantrekkelijk visitekaartje voor het sportcentrum dat direct de juiste sfeer overbrengt.
*   **Gebruikersregistratie & Inlogsysteem:** Een veilig portaal waar leden kunnen inloggen (inclusief het door de klant aangevraagde telefoonnummer-veld bij registratie).
*   **Leden Dashboard:** Een gepersonaliseerde omgeving voor leden, volledig opgebouwd volgens de goedgekeurde wireframes.
*   **Profielbeheer:** Een dedicated profielpagina waar gebruikers hun gegevens kunnen inzien en beheren.
*   **Beheerderspaneel (Admin):** Functionaliteiten voor het beheer van de website en de gekoppelde database.

---

## 🛠️ Technische Stack

*   **Framework:** Laravel 13+
*   **Taal (back-end):** PHP 8.3 of hoger
*   **Database:** MySQL / phpMyAdmin
*   **Front-end:** HTML5, CSS3 (Styling conform wireframes), JavaScript
*   **Dependency Management:** Composer & NPM
*   **Versiebeheer & Downloaden:** Git & GitHub (via `git clone` of als ZIP-bestand, zie hieronder)

---

## ⬇️ Het project downloaden en starten

### 1. Vereisten

Zorg dat het volgende op je computer staat:

*   **PHP 8.3 of hoger**
*   **Composer**
*   **MySQL met phpMyAdmin** (bijvoorbeeld via XAMPP)
*   **Git** (alleen nodig als je het project via `git clone` downloadt)
*   **Node.js & NPM** (optioneel, alleen nodig voor `npm install`)

### 2. Het project downloaden

Kies één van de twee manieren:

**Optie A: via Git (aanbevolen)**

```bash
git clone https://github.com/Kailash-W/Sportcentrum.git
cd Sportcentrum
```

**Optie B: als ZIP-bestand**

1. Ga naar de hoofdpagina van deze repository op GitHub.
2. Klik op de groene knop **`<> Code`**.
3. Klik op **`Download ZIP`**.
4. Pak het ZIP-bestand uit en open de map in je terminal of code-editor.

### 3. Het project installeren

Voer de volgende stappen uit in de projectmap:

```bash
# 1. Installeer de PHP-pakketten
composer install

# 2. Maak je eigen .env-bestand
cp .env.example .env
#    (Windows: copy .env.example .env)

# 3. Genereer de applicatiesleutel
php artisan key:generate
```

### 4. De database instellen

1. Start **Apache** en **MySQL** (bijvoorbeeld in het XAMPP Control Panel).
2. Open **phpMyAdmin** en maak een lege database aan met de naam `sportcentrum`.
3. Open het bestand `.env` en pas de database-instellingen aan:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sportcentrum
DB_USERNAME=root
DB_PASSWORD=
```

4. Maak de tabellen aan en vul ze met testgegevens:

```bash
php artisan migrate --seed
```

### 5. De website starten

```bash
php artisan serve
```

Open daarna **http://localhost:8000** in je browser.

*Optioneel:* wil je ook de NPM-pakketten installeren, voer dan `npm install` uit.

### 🔑 Testaccount

Na `php artisan migrate --seed` kun je inloggen als beheerder met:

*   **E-mailadres:** `admin@delinde.nl`
*   **Wachtwoord:** `password`

*Let op: dit zijn alleen testgegevens voor lokaal gebruik.*

---

## 👥 Het Team (Inazuma Eleven)

Dit project is met trots gerealiseerd door:
*   **Teun** (Database & Back-end functionaliteiten, Ledensectie)
*   **Shiwan** (Klantcontact, Dashboard & Front-end logica)
*   **Kailash** (Repository beheer, UI/CSS-styling, Inlog- & Homescreen visuals en Documentatie PvE)
