const boosterBtn = document.getElementById("openBoosterBtn");
const container = document.getElementById("cardsContainer");

const COOLDOWN_SECONDS = 5; // cooldown de 5 secondes
let cooldownTimer = null;

function startCooldown(seconds) {
    let remaining = seconds;

    boosterBtn.disabled = true;
    boosterBtn.textContent = `In Cooldown (${remaining}s)`;
    boosterBtn.classList.add("disabled");

    cooldownTimer = setInterval(() => {
        remaining--;
        if (remaining > 0) {
            boosterBtn.textContent = `In Cooldown (${remaining}s)`;
        } else {
            clearInterval(cooldownTimer);
            boosterBtn.disabled = false;
            boosterBtn.textContent = "Open a Booster";
            boosterBtn.classList.remove("disabled");
        }
    }, 1000);
}

async function checkCooldown() {
    try {
        const res = await fetch("Booster.php?action=cooldown");
        const data = await res.json();

        if (data.last_booster) {
            const lastTime = new Date(data.last_booster);
            const now = new Date();
            const diff = Math.floor((now - lastTime) / 1000);
            const remaining = COOLDOWN_SECONDS - diff;

            if (remaining > 0) {
                startCooldown(remaining);
            }
        }
    } catch (e) {
        console.error("Erreur cooldown :", e);
    }
}

document.getElementById("openBoosterBtn").addEventListener("click", async () => {
    const container = document.getElementById("cardsContainer");
    container.innerHTML = "";

    try {
        const response = await fetch("Booster.php?action=booster");
        const cards = await response.json();
        console.log("Réponse du booster :", cards);

        cards.forEach(champ => {
            const card = document.createElement("div");
            card.className = "card";

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
            container.appendChild(card);
        });

        startCooldown(COOLDOWN_SECONDS);

    } catch (error) {
        console.error("Erreur lors du chargement des cartes :", error);
    }
});


document.addEventListener("DOMContentLoaded", () => {
    checkCooldown();
});