<?php

require_once("connexion.php");

if(!isset($_SESSION["user_id"])) {
    header("location:Login.php");
}

if(isset($_GET["action"]) && $_GET["action"] == "deconnexion") {
    unset($_SESSION["user_id"]);
    unset($_SESSION["email"]);
    header("location:Login.php");
}

if (isset($_GET['action']) && $_GET['action'] == 'collection') {
    try {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode([]);
            exit;
        }

        $userId = $_SESSION['user_id'];

        $stmt = $pdo->prepare("
            SELECT DISTINCT c.* 
            FROM user_collection uc
            INNER JOIN champion c ON uc.champion_name = c.name
            WHERE uc.user_id = :user_id
        ");
        $stmt->execute(["user_id" => $userId]);
        $collection = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($collection);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
    }
    exit;
}

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    $stmt = $pdo->prepare("
        SELECT DISTINCT c.* 
        FROM user_collection uc
        INNER JOIN champion c ON uc.champion_name = c.name
        WHERE uc.user_id = :user_id
    ");
    $stmt->execute(["user_id" => $userId]);
    $collection = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalStmt = $pdo->query("SELECT COUNT(*) FROM champion");
    $totalCount = $totalStmt->fetchColumn();

    $percentage = $totalCount > 0 ? round((count($collection) / $totalCount) * 100, 0) : 0;
}

require_once("haut_page.php");

?>

    <main>

        <!-- Haut de la page, bannière de présentation -->
        <header class="medium-banner">
            <div style="display: flex; justify-content: space-between">
                <p class="profile-message">You are loged-in with this email : <?php echo $_SESSION["email"]; ?></p>
                <a class="profile-logout" href="?action=deconnexion">Log out</a>
            </div>
            <p class="banner-text">This is your own collection</p>
            <p class="banner-text">You own <strong><?php echo count($collection); ?></strong> out of <strong><?php echo $totalCount; ?></strong> cards (<?php echo $percentage; ?>%).</p>
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

        <script src="js/ClassFilter.js"></script>
        <script src="js/CardInfo.js"></script>
        <script src="js/Profil.js"></script>
    
    </main>

<?php

require_once("bas_page.php");

?>