# SerpApi 

Query SerpApi

# Usage

$serpApi = SerpApi::config(array(
    'apiUrl' => 'https://serpapi.com',
    'apiKey' => 'yourApiKey'
));

$search = $serpApi->GoogleSearch->search([
    'q' => 'coffee'
]);

$search = $serpApi->HomeDepotSearch->search([
    'q' => 'samsung fridge'
]);

$account = $serpApi->Account->get();

$locations = $serpApi->Locations->get();

$searchAcrhive = $serpApi->SearchArchive('archiveId')->get();