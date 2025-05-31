<?php

require_once("connexion.php");

if (isset($_GET['action']) && $_GET['action'] == 'cooldown') {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["error" => "non connecté"]);
        exit;
    }

    $stmt = $pdo->prepare("SELECT last_booster FROM user WHERE user_id = :id");
    $stmt->execute(["id" => $_SESSION["user_id"]]);
    $last = $stmt->fetchColumn();

    if ($last) {
        echo json_encode(["last_booster" => $last]);
    } else {
        echo json_encode(["last_booster" => null]);
    }

    exit;
}

if (isset($_GET['action']) && $_GET['action'] == 'booster') {

    if (!isset($_SESSION['user_id'])) {
        http_response_code(403);
        echo json_encode(["error" => "Vous devez être connecté."]);
        exit;
    }

    $userId = $_SESSION['user_id'];

    try {
        $stmt = $pdo->query("SELECT * FROM champion ORDER BY RAND() LIMIT 5");
        $champions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $insertStmt = $pdo->prepare("INSERT INTO user_collection (user_id, champion_name) VALUES (:user_id, :champion_name)");

        foreach ($champions as $champion) {
            $insertStmt->execute([
                'user_id' => $userId,
                'champion_name' => $champion['name']
            ]);
        }
        $pdo->prepare("UPDATE user SET last_booster = NOW() WHERE user_id = :user_id")->execute(['user_id' => $userId]);

        echo json_encode($champions);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
    }

    exit;
}

require_once("haut_page.php");

?>

    <main>

        <!-- Haut de la page, bannière de présentation -->
        <header class="medium-banner">
            <p class="banner-text">You can open a booster every minute to obtain 5 random cards from the global collection. Make sure you're logged in !</p>
        </header>

        <?php if (!isset($_SESSION["user_id"])): ?>
            <p class="login-warning">
                You need to be logged in to open a booster
            </p>
        <?php endif; ?>

        <!-- Bouton Booster -->
        <div class="booster">
        <button id="openBoosterBtn" class="booster-button">Open a Booster</button>
        <a href="Profil.php" style="text-decoration: none"><button class="booster-button">Go to My Collection</button></a>
        </div>

        <!-- Affichage des cartes si booster ouvert -->
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

    <script src="js/Booster.js"></script>
    <script src="js/CardInfo.js"></script>
    <script src="js/ClassFilter.js"></script>

<?php

require_once("bas_page.php");

?>
