document.getElementById('search-form').addEventListener('submit', function(event){
    event.preventDefault(); // para nao recarregar a pagina no envio do formulario

    const form = event.target;
    const pokemonName = form.elements['pokemon_name'].value;
    console.log(pokemonName);

    // elementos da pagina html em variaveis para alterar posteriormente
    const pokemonImage = document.getElementById('pokemon-image');
    const pokemonNameElement = document.getElementById('pokemon-name');
    const pokemonIdElement = document.getElementById('pokemon-id');
    const pokemonTypeElement = document.getElementById('pokemon-type');
    const pokemonDescriptionElement = document.getElementById('pokemon-description');

    pokemonNameElement.textContent = "Buscando...";
    pokemonIdElement.textContent = "";    
    pokemonTypeElement.textContent = "";
    pokemonDescriptionElement.textContent = "";
    pokemonImage.src = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT0ghdBwJHz-6PnTiwFzlI-rnpUfr-6rWdr0g&s";

    // conexao com o PHP
    fetch(`buscar.php?pokemon_name=${pokemonName}`)
        .then(response => response.json()) // coloca a resposta do fetch em um arquivo 'response.json'

        .then(data => {
            // se a requisicao der certo:
            console.log(data);
            
            if(data.success) {
                // Pokemon encontrado
                pokemonNameElement.textContent = data.name;
                pokemonIdElement.textContent = data.id;
                pokemonTypeElement.textContent = data.type;
                pokemonDescriptionElement.textContent = data.description;
                pokemonImage.src = data.image;
            } else {
                // Pokemon não encontrado
                pokemonNameElement.textContent = data.name;
                pokemonIdElement.textContent = "";
                pokemonTypeElement.textContent = "";
                pokemonDescriptionElement.textContent = data.description;
                pokemonImage.src = data.image;
            }
        })
        .catch(error => { // se algo der errado, ele vai "pegar" esse erro e:
            console.log(error); // colocar o erro no log do console
        }) 
})