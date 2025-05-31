// On récupère la liste des versions de l'api ddragon
// On return la dernière version
async function LatestVersion() {
    const response = await fetch("https://ddragon.leagueoflegends.com/api/versions.json");
    const versions = await response.json();
    return versions[0];
}

// On récupère la liste de toutes les champions avec l'api ddragon
// On return la liste des champions avec leurs infos
async function Champions(version) {
    const response = await fetch(`https://ddragon.leagueoflegends.com/cdn/${version}/data/en_US/champion.json`);
    const data = await response.json();
    return data.data;
}

// On créé une carte pour chaque champion de l'api, avec :
// Une image, un nom, un bouton favori, une liste de stats
// On ajoute une fonction sur la carte qui nous donnera plus d'info quand on clique dessus
function CreateChampionCard(champ) {
    const card = document.createElement("div");
    card.className = `card ${champ.tags.map(tag => tag.toLowerCase()).join(' ')}`;
    const name = champ.name;
    const image = `https://ddragon.leagueoflegends.com/cdn/img/champion/loading/${champ.id}_0.jpg`;
    const stats = champ.info;

    card.innerHTML = `
        <img src="${image}" alt="${name}">
        <div class="shadow-bottom"></div>
        <div class="shadow-top"></div>
        <div class="name">${name}</div> 
        <div class="star" onclick="togglefavorite(this, event)">&#9733;</div>
        <div class="stats">
            <p>Attack : ${stats.attack}</p>
            <p>Defense : ${stats.defense}</p>
            <p>Magic : ${stats.magic}</p>
            <p>Difficulty : ${stats.difficulty}</p>
        </div>
    `;
    card.addEventListener("click", () => {
        OpenChampionInfos(champ.id);
    });
    return card
}

// On appelle les fonctions au-dessus pour créer les cartes
// On met toutes les cartes créées dans une balise avec un display grid
async function loadChampions() {
    const container = document.getElementById('cardsContainer');
    const version = await LatestVersion();
    const champions = await Champions(version);

    Object.values(champions).forEach(champ => {
        container.appendChild(CreateChampionCard(champ));
    });
}

// On lance l'initialisation de la création de la liste des cartes
loadChampions();