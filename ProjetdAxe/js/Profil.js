async function LatestVersion() {
    const response = await fetch("https://ddragon.leagueoflegends.com/api/versions.json");
    const versions = await response.json();
    return versions[0];
}

async function getChampionFullData(version, champName) {
    const response = await fetch(`https://ddragon.leagueoflegends.com/cdn/${version}/data/en_US/champion/${champName}.json`);
    const data = await response.json();
    return data.data[champName];
}

function CreateUserChampionCard(champ, tags) {
    const card = document.createElement("div");
    card.className = `card ${tags.map(tag => tag.toLowerCase()).join(' ')}`;

    const image = `https://ddragon.leagueoflegends.com/cdn/img/champion/loading/${champ.name}_0.jpg`;

    card.innerHTML = `
        <img src="${image}" alt="${champ.name}">
        <div class="shadow-bottom"></div>
        <div class="shadow-top"></div>
        <div class="name">${champ.name}</div>
        <div class="star" onclick="togglefavorite(this, event)">&#9733;</div>
        <div class="stats">
            <p>Attack : ${champ.attack}</p>
            <p>Defense : ${champ.defense}</p>
            <p>Magic : ${champ.magic}</p>
            <p>Difficulty : ${champ.difficulty}</p>
        </div>
    `;

    card.addEventListener("click", () => {
        OpenChampionInfos(champ.name);
    });

    return card;
}

async function loadUserCollection() {
    const container = document.getElementById('cardsContainer');
    container.innerHTML = "";

    try {
        const version = await LatestVersion();
        const response = await fetch("Profil.php?action=collection");
        const cards = await response.json();

        if (!cards.length) {
            container.innerHTML = "<p>Aucune carte dans votre collection.</p>";
            return;
        }

        for (const champ of cards) {
            const champData = await getChampionFullData(version, champ.name);
            const tags = champData.tags || [];

            const card = CreateUserChampionCard(champ, tags);
            container.appendChild(card);
        }

    } catch (error) {
        console.error("Erreur lors du chargement de la collection :", error);
        container.innerHTML = "<p>Erreur lors du chargement de la collection.</p>";
    }
}

document.addEventListener("DOMContentLoaded", loadUserCollection);
