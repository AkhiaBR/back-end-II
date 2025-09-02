document.getElementById("get-cat-btn").addEventListener("click", function(event) {
    event.preventDefault();
    console.log("Cliquei no botão");

    // declarar variaveis referentes aos elementos da pagina
    const catName = document.getElementById("cat-name");
    const catImage = document.getElementById("cat-image");

    // feedback visual
    catName.textContent = "BUSCANDO GATINHO...";
    catImage.src = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT0ghdBwJHz-6PnTiwFzlI-rnpUfr-6rWdr0g&s";

    // 
    fetch(`buscar.php`)
        .then(response => response.json())
        .then(data => {
            catName.textContent = "Gatinho encontrado!";
            catImage.src = data.image;
        })
        .catch(error => {
            console.log(error);
        })
});