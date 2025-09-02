<?php
// Configurações:
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

$response = array(
    "success" => false,
    "image" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT0ghdBwJHz-6PnTiwFzlI-rnpUfr-6rWdr0g&s",
    "name" => "Gato não encontrado",
);

$url = "https://api.thecatapi.com/v1/images/search";

$ch = curl_init();                                   
curl_setopt($ch, CURLOPT_URL, $url);                
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    
$apiResponse = curl_exec($ch);                        
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);   
curl_close($ch);     

if ($httpCode == 200) {
    $catData = json_decode($apiResponse, true); // true porque vai retornar um array
    $catImage = $catData[0]['url'];

    $response = array(
        "success" => true,
        "image" => $catImage,
        "name" => "Gato encontrado!",
    );
}

echo json_encode($response);
?>