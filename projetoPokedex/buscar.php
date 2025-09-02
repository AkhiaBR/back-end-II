<?php
// CONFIGURAÇÕES DE CABEÇALHO: 
header('Content-Type: application/json');  // Diz ao navegador que a resposta é JSON
header('Access-Control-Allow-Origin: *');  // Permite requisições de qualquer origem
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');  // Métodos HTTP permitidos
header('Access-Control-Allow-Headers: Content-Type, Authorization');  // Headers permitidos

// RESPOSTA PADRÃO: Caso algo dê errado, retorna esta resposta
$response = array(
    "success" => false,
    "name" => "Pokemon não encontrado",
    "id" => "",
    "type" => "",
    "description" => "Tentem outro nome",
    "image" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT0ghdBwJHz-6PnTiwFzlI-rnpUfr-6rWdr0g&s"
);

// VERIFICAÇÃO: Só executa se recebeu o nome do Pokémon
if (!empty($_GET["pokemon_name"])) {
    // PREPARAÇÃO: Limpa e converte o nome para minúsculo
    $searchName = strtolower(trim($_GET["pokemon_name"]));

    // URL DA API: Endereço da PokeAPI que será consultada
    $url = "https://pokeapi.co/api/v2/pokemon/".$searchName;

    // CURL: "Navegador programático" que baixa dados da API externa
    // cURL é a ferramenta que "sai do PHP" e vai buscar dados na internet
    $ch = curl_init();                                    // Inicia o cURL
    curl_setopt($ch, CURLOPT_URL, $url);                  // Define a URL para visitar
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);       // "Me traga o conteúdo como texto"
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);     // Ignora certificados SSL (segurança)
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);     // Ignora verificação de host SSL
    $apiResponse = curl_exec($ch);                        // Executa e guarda o resultado
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);   // Pega o código de status HTTP
    curl_close($ch);                                     // Fecha a conexão

    // VERIFICAÇÃO DE SUCESSO: Se a API retornou dados válidos (código 200)
    if($httpCode == 200) {
        // JSON_DECODE: Converte o JSON da API em array PHP
        // $apiResponse = string JSON → $pokemonData = array PHP
        $pokemonData = json_decode($apiResponse, true);
        
        // EXTRAÇÃO DE DADOS: Pega só o que precisamos da resposta gigante da API
        $pokemonName = ucfirst($pokemonData['name']);     // ucfirst() = primeira letra maiúscula
        $pokemonId = $pokemonData['id'];
        $pokemonType = ucfirst($pokemonData['types'][0]['type']['name']);
        $pokemonImage = $pokemonData['sprites']['other']['official-artwork']['front_default'];

        // SEGUNDA REQUISIÇÃO: Busca a descrição do Pokémon
        $descUrl = $pokemonData['species']['url'];

        // CURL PARA DESCRIÇÃO: Faz outra requisição para pegar a descrição
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $descUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $descResponse = curl_exec($ch);
        curl_close($ch);

        // PROCESSAMENTO DA DESCRIÇÃO: Converte e busca descrição em inglês
        $descData = json_decode($descResponse, true);

        $description = "";        
        // FOREACH: Para cada entrada de descrição na API
        foreach($descData['flavor_text_entries'] as $entry) {
            if($entry['language']['name'] == 'en') {  // Se a descrição for em inglês
                $description = $entry['flavor_text'];
                break;  // Para no primeiro que encontrar
            } 
        }
    }

    // RESPOSTA FINAL: Organiza os dados filtrados para o JavaScript
    // Este é o "data" que o JavaScript vai receber - só o que precisa!
    $response = array(
        "success" => true,
        "name" => $pokemonName,
        "id" => $pokemonId,
        "type" => $pokemonType,
        "description" => $description,
        "image" => $pokemonImage
    );
}

// JSON_ENCODE: Converte array PHP em JSON para o JavaScript interpretar
// Este é o "retorno" que permite o JavaScript receber os dados processados
echo json_encode($response);
?>