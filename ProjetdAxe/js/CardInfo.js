// Lors du clique sur une carte, on exécute cette fonction qui affiche un pop-up des infos du champion
async function OpenChampionInfos(championId) {
    // On récupère les infos de la carte cliquée par l'api ddragon
    const response = await fetch("https://ddragon.leagueoflegends.com/api/versions.json");
    const versions = await response.json();
    const version = versions[0];
    const res = await fetch(`https://ddragon.leagueoflegends.com/cdn/${version}/data/en_US/champion/${championId}.json`);
    const data = await res.json();
    const champ = data.data[championId];

    // On affiche : son image en plus grand, son nom, son titre, et son histoire
    document.getElementById("Splash").src = `https://ddragon.leagueoflegends.com/cdn/img/champion/splash/${championId}_0.jpg`;
    document.getElementById("Splash").alt = champ.name;
    document.getElementById("Name").textContent = champ.name;
    document.getElementById("Title").textContent = champ.title;
    document.getElementById("Lore").textContent = champ.lore;
    document.getElementById("championInfos").classList.remove("invisible");
}

// On ferme le pop-up quand on clique sur la croix
function closeChampionInfos() {
    document.getElementById("championInfos").classList.add("invisible");
}

// On ferme le pop-up quand on clique à côté du pop-up
window.addEventListener("click", (e) => {
    const modal = document.getElementById("championInfos");
    if (e.target === modal) {
        closeChampionInfos();
    }
});