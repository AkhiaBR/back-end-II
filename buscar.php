<?php
header('Content-Type: application/json');

$response = [
    "success" => false,
    "name": => "Pokemon não encontrado",
    "id" => "",
    "type" => "",
    "description" => "Tenten outro nome",
    "image" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT0ghdBwJHz-6PnTiwFzlI-rnpUfr-6rWdr0g&s"
]

echo json_encode($response);
?>