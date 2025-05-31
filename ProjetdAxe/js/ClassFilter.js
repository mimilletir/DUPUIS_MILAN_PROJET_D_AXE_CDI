// Carte favorite
function togglefavorite(starElement, event) {
    event.stopPropagation();
    // Empêche l'ouverture des infos du champion
    // Récupérer l'élément parent de l'étoile (la div.card)
    let cardElement = starElement.closest(".card");
    // Ajouter ou supprimer la classe "favorite" sur l'étoile cliquée
    starElement.classList.toggle("favorite");
    cardElement.classList.toggle("favorite");
}

// Barre de filtre
document.querySelectorAll(".filter-btn").forEach((filterbtn) => {
    // Création d'un événement click pour chaque bouton
    filterbtn.addEventListener("click",function(){

        // Retire la classe "tab-active" de tous les boutons
        document.querySelectorAll(".filter-btn").forEach((btn) => {
            btn.classList.remove("tab-active")
        })

        // Retire la classe "active" de toutes les cartes
        document.querySelectorAll(".card").forEach((card) => {
            card.classList.add("invisible")
        })

        // Ajout de la classe "tab-active" au bouton cliqué
        this.classList.add("tab-active")
        
        // Pour chaque classe card vérifier si elle contient aussi la classe du bouton cliqué
        if(this.classList.contains("all-role")){
            document.querySelectorAll(".card").forEach((card) => {card.classList.remove("invisible")})
        }
        else if(this.classList.contains("tank")){
            document.querySelectorAll(".card.tank").forEach((card) => {card.classList.remove("invisible")})
        }
        else if(this.classList.contains("fighter")){
            document.querySelectorAll(".card.fighter").forEach((card) => {card.classList.remove("invisible")})
        }
        else if(this.classList.contains("assassin")){
            document.querySelectorAll(".card.assassin").forEach((card) => {card.classList.remove("invisible")})
        }
        else if(this.classList.contains("mage")){
            document.querySelectorAll(".card.mage").forEach((card) => {card.classList.remove("invisible")})
        }
        else if(this.classList.contains("marksman")){
            document.querySelectorAll(".card.marksman").forEach((card) => {card.classList.remove("invisible")})
        }
        else if(this.classList.contains("support")){
            document.querySelectorAll(".card.support").forEach((card) => {card.classList.remove("invisible")})
        }
        else if(this.classList.contains("favorite")){
            document.querySelectorAll(".card.favorite").forEach((card) => {card.classList.remove("invisible")})
        }
    })
})

// Barre de recherche dynamique
document.getElementById("championSearch").addEventListener("input", function () {
    // On récupère ce qui est écrit et la liste de toute les cartes
    const searchValue = this.value.toLowerCase();
    const cards = document.querySelectorAll(".card");

    // Pour chaque carte, on vérifie si ce qu'on a écrit est dans le nom de la carte
    // Si oui on l'affiche
    // Si non on la rend invisible
    cards.forEach(card => {
        const name = card.querySelector(".name").textContent.toLowerCase();
        if (name.includes(searchValue)) {
            card.style.display = "inline-block";
        } else {
            card.style.display = "none";
        }
    });
});