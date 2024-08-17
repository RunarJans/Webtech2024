# Webtech-project

## Overzicht

Dit project maakt gebruik van een PYNQ-bord (Python Productivity for Zynq) om gesimuleerde temperatuurgegevens te genereren en deze gegevens weer te geven op een webpagina. Het omvat zowel hardware- als softwarecomponenten, en illustreert hoe je data van een embedded systeem naar een webinterface kunt brengen.

## Inhoud

1. [Project Beschrijving](#project-beschrijving)
2. [Technische Specificaties](#technische-specificaties)
3. [Systeemarchitectuur](#systeemarchitectuur)
4. [Installatie](#installatie)
5. [Gebruik](#gebruik)
6. [API Documentatie](#api-documentatie)
7. [Technologieën](#technologieën)
8. [Bijdragen](#bijdragen)
9. [Licentie](#licentie)

## Project Beschrijving

Het project is ontworpen om temperatuurmetingen die gesimuleerd worden door een PYNQ-bord, op een webpagina weer te geven. Dit gebeurt door het ophalen van gegevens uit een PostgreSQL-database via een PHP-backend, en het dynamisch updaten van een HTML-tabel met JavaScript.

## Technische Specificaties

- **PYNQ Bord**: Generatie van gesimuleerde temperatuurgegevens.
- **PostgreSQL Database**: Opslag van temperatuurgegevens.
- **PHP Backend**: API voor het ophalen en beheren van gegevens.
- **HTML/CSS/JavaScript**: Frontend voor de weergave en dynamische updates van temperatuurgegevens.

## Systeemarchitectuur

1. **Hardware**: Het PYNQ-bord simuleert temperatuurdata en stuurt deze gegevens naar een PostgreSQL-database.
2. **Backend**:
   - **PHP**: Verzorgt de API die temperatuurgegevens ophaalt uit de PostgreSQL-database en deze in JSON-formaat beschikbaar stelt.
3. **Frontend**:
   - **HTML/CSS**: Structureert en style de webpagina.
   - **JavaScript**: Vraagt periodiek gegevens op van de API en werkt de tabel op de webpagina bij.

## Installatie

### Vereisten

- PYNQ-bord met een gesimuleerde temperatuurdata setup.
- PostgreSQL database.
- Webserver met PHP ondersteuning (bijvoorbeeld Apache).
- Webbrowser voor toegang tot de HTML-pagina.

### Installatie Stappen

1. **Configureer het PYNQ-bord**:
   - Zorg ervoor dat het PYNQ-bord is ingesteld om temperatuurgegevens te genereren en op te slaan in de PostgreSQL-database.

2. **Installeer PostgreSQL**:
   - Installeer PostgreSQL en configureer een database genaamd `sensor_data`.
   - Maak een tabel `temperatures` met de kolommen `id`, `temperature`, en `timestamp`.

3. **Configureer de Webserver**:
   - Plaats de `api.php` en de HTML-bestanden op je webserver in de documentroot (`/var/www/html` of een andere locatie afhankelijk van je serverconfiguratie).

4. **Configureer PHP**:
   - Zorg ervoor dat je PHP-configuratie de databaseverbinding correct kan uitvoeren. Werk de `api.php`-bestand bij met jouw databaseconfiguratie.

5. **Open de Webpagina**:
   - Bezoek `http://your-server-address/index.html` in je webbrowser om de webinterface te bekijken.

## Gebruik

- **Homepagina**: `index.html` biedt links naar de temperatuurgegevens en de About Us-pagina.
- **Temperatuur Gegevens**: `temperatures.html` toont een dynamische tabel van temperatuurgegevens die elke 10 seconden wordt bijgewerkt.
- **About Us**: `about_us.html` geeft informatie over het project en de ontwikkelaar.

## API Documentatie

### Endpoints

- **GET /api.php**
  - Haalt alle temperatuurgegevens op in JSON-formaat.
  - Optioneel: Voeg een queryparameter `id` toe om gegevens voor een specifieke ID op te halen.

- **POST /api.php**
  - Voegt een nieuwe temperatuurmeting toe aan de database.

- **PUT /api.php?id={id}**
  - Werk de temperatuurgegevens bij voor de opgegeven ID.

- **DELETE /api.php?id={id}**
  - Verwijder de temperatuurgegevens voor de opgegeven ID.

## Technologieën

- **PYNQ**: Python Productivity for Zynq voor hardware simulatie.
- **PostgreSQL**: Relationele database voor gegevensopslag.
- **PHP**: Server-side scripting taal voor de API.
- **HTML/CSS/JavaScript**: Webtechnologieën voor frontend weergave.
