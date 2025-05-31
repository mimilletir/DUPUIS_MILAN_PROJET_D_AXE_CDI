<?php

require_once("connexion.php");

$totalStmt = $pdo->query("SELECT COUNT(*) FROM champion");
$totalCount = $totalStmt->fetchColumn();

require_once("haut_page.php");

?>

    <main>

        <!-- Haut de la page, bannière de présentation -->
        <header class="medium-banner">
            <p class="banner-text">Browse the full list of collectible cards. There is a total of <strong><?php echo $totalCount; ?> cards</strong>.</p>
            <p class="banner-text">Click on any card to view detailed information.</p>
        </header>

        <!-- Bar de filtre pour les cartes -->
        <div class="filter-bar">
            <button class="filter-btn all-role tab-active">All Role</button>
            <button class="filter-btn tank">Tank</button>
            <button class="filter-btn fighter">Fighter</button>
            <button class="filter-btn assassin">Assassin</button>
            <button class="filter-btn mage">Mage</button>
            <button class="filter-btn marksman">Marksman</button>
            <button class="filter-btn support">Support</button>
            <button class="filter-btn favorite">Favorite</button>
            <input type="text" id="championSearch" placeholder="Search...">
        </div>

        <!-- Création de toutes les cartes à collectionner par l'api ddragon-->
        <div class="cards-container" id="cardsContainer">
            
        </div>

        <!-- Pop-up infos de champion -->
        <div id="championInfos" class="infos invisible">
            <div class="infos-content">
                <button class="close-btn" onclick="closeChampionInfos()">×</button>
                <img id="Splash" src="" alt="">
                <div class="infos-text">
                    <h2 id="Name"></h2>
                    <h3 id="Title"></h3>
                    <p id="Lore"></p>
                </div>
            </div>
        </div>

    </main>

    <script src="js/ClassFilter.js"></script>
    <script src="js/CardCreation.js"></script>
    <script src="js/CardInfo.js"></script>

<?php

require_once("bas_page.php");

?>