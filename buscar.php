<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

$response = array(
    "success" => false,
    "name" => "Pokemon não encontrado",
    "id" => "",
    "type" => "",
    "description" => "Tentem outro nome",
    "image" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT0ghdBwJHz-6PnTiwFzlI-rnpUfr-6rWdr0g&s"
);

if (!empty($_GET["pokemon_name"])) {
    $searchName = strtolower(trim($_GET["pokemon_name"]));

    $url = "https://pokeapi.co/api/v2/pokemon/".$searchName;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $apiResponse = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if($httpCode == 200) {
        $pokemonData = json_decode($apiResponse, true);
        
        $pokemonName = ucfirst($pokemonData['name']);
        $pokemonId = $pokemonData['id'];
        $pokemonType = ucfirst($pokemonType['types'][0]['type']['name']);
        $pokemonImage = $pokemonImage['sprites']['other']['official-artwork']['front-default'];
    }

    $response = array(
        "success" => true,
        "name" => $pokemonName,
        "id" => $pokemonId,
        "type" => $pokemonType,
        "description" => "Tentem outro nome",
        "image" => $pokemonImage
    );
}

echo json_encode($response);
?>