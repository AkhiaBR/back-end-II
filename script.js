// ESCUTADOR DE EVENTO: Quando o formulário for enviado, execute esta função
// getElementById('search-form') = busca o formulário pelo ID
// addEventListener('submit') = "escuta" quando o formulário é enviado
// function(event){ = função anônima (sem nome / com nome: function nomeFuncao(event)) que é declarada e passada como parâmetro
document.getElementById('search-form').addEventListener('submit', function(event){
    event.preventDefault(); // para nao recarregar a pagina no envio do formulario

    // PEGA o nome do Pokémon digitado no formulário
    const form = event.target;
    const pokemonName = form.elements['pokemon_name'].value;
    console.log(pokemonName);

    // ELEMENTOS HTML: Guarda referências dos elementos que serão atualizados
    // Essas variáveis permitem alterar o conteúdo da página dinamicamente
    const pokemonImage = document.getElementById('pokemon-image');
    const pokemonNameElement = document.getElementById('pokemon-name');
    const pokemonIdElement = document.getElementById('pokemon-id');
    const pokemonTypeElement = document.getElementById('pokemon-type');
    const pokemonDescriptionElement = document.getElementById('pokemon-description');

    // FEEDBACK VISUAL: Mostra "Buscando..." enquanto carrega
    // Limpa os campos anteriores e mostra uma imagem de carregamento
    pokemonNameElement.textContent = "Buscando...";
    pokemonIdElement.textContent = "";    
    pokemonTypeElement.textContent = "";
    pokemonDescriptionElement.textContent = "";
    pokemonImage.src = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT0ghdBwJHz-6PnTiwFzlI-rnpUfr-6rWdr0g&s";

    // FETCH: "Sai do JavaScript" e vai buscar dados no PHP
    // fetch é o "mensageiro" que permite comunicação com o servidor
    fetch(`buscar.php?pokemon_name=${pokemonName}`)
        .then(response => response.json()) // CONVERTE a resposta do servidor em JSON
        // response = "caixa" com tudo do servidor
        // response.json() = extrai os dados JSON da caixa

        .then(data => {
            // DATA: Recebe o resultado filtrado do PHP (não toda a API)
            // O PHP já processou e organizou só o que precisamos
            // data = objeto JavaScript com: name, id, type, description, image
            pokemonImage.src = data.image;
            pokemonNameElement.textContent = data.name;
            pokemonIdElement.textContent = data.id;    
            pokemonTypeElement.textContent = data.type;
            pokemonDescriptionElement.textContent = data.description;
        })
        .catch(error => { // TRATAMENTO DE ERRO: Se algo der errado
            console.log(error); // Mostra o erro no console do navegador
        }) 
})
    