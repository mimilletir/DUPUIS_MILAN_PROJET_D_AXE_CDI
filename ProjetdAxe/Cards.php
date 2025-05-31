<?php

require_once("connexion.php");

function getLatestVersion() {
    $json = file_get_contents("https://ddragon.leagueoflegends.com/api/versions.json");
    $versions = json_decode($json, true);

    return $versions[0];
}

$version = getLatestVersion();
$json = file_get_contents("https://ddragon.leagueoflegends.com/cdn/{$version}/data/en_US/champion.json");
$data = json_decode($json, true);
$champions = $data['data'];

try {
    foreach ($champions as $champion) {
        $name = $champion['id'];
        $title = $champion['title'];
        $image = $champion['image']['full'];
        $attack = $champion['info']['attack'];
        $defense = $champion['info']['defense'];
        $magic = $champion['info']['magic'];
        $difficulty = $champion['info']['difficulty'];
        $description = $champion['blurb'];

        // Vérifie si le champion existe déjà
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM champion WHERE name = :name");
        $stmt->execute(["name" => $name]);
        $exists = $stmt->fetchColumn();

        if (!$exists) {
            // Insert seulement s'il n'existe pas
            $stmt = $pdo->prepare("INSERT INTO champion (name, title, image, attack, defense, magic, difficulty, description) 
                                   VALUES (:name, :title, :image, :attack, :defense, :magic, :difficulty, :description)");

            $stmt->execute([
                "name" => $name,
                "title" => $title,
                "image" => $image,
                "attack" => $attack,
                "defense" => $defense,
                "magic" => $magic,
                "difficulty" => $difficulty,
                "description" => $description,
            ]);
        }
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

if ($_POST) {
    $name = $_POST["name"];
    $title = $_POST["title"];
    $image = $_POST["image"];
    $attack = $_POST["attack"];
    $defense = $_POST["defense"];
    $magic = $_POST["magic"];
    $difficulty = $_POST["difficulty"];
    $description = $_POST["description"];

    try {
        if (!empty($_POST["id"])) {
            // cas UPDATE
            $stmt = $pdo->prepare("UPDATE champion SET name = :name, title = :title, image = :image, attack = :attack, defense = :defense, magic = :magic, difficulty = :difficulty, description = :description WHERE id = :id");

            $stmt->execute([
                "name" => $name,
                "title" => $title,
                "image" => $image,
                "attack" => $attack,
                "defense" => $defense,
                "magic" => $magic,
                "difficulty" => $difficulty,
                "description" => $description,
                "id" => $_POST["id"]
            ]);
        } else {
            // cas INSERT
            $stmt = $pdo->prepare("INSERT INTO champion (name, title, image, attack, defense, magic, difficulty, description) VALUES (:name, :title, :image, :attack, :defense, :magic, :difficulty, :description)");

            $stmt->execute([
                "name" => $name,
                "title" => $title,
                "image" => $image,
                "attack" => $attack,
                "defense" => $defense,
                "magic" => $magic,
                "difficulty" => $difficulty,
                "description" => $description,
            ]);
        }
        header("Location: Cards.php");
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM champion WHERE id = :id");
        $stmt->execute(["id" => $id]);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'modify') {
    $id = $_GET['id'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM champion WHERE id = :id");
        $stmt->execute(["id" => $id]);
        $championToEdit = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

$stmt = $pdo->query("SELECT * FROM champion");
$champions = $stmt->fetchAll(PDO::FETCH_ASSOC);


require_once("haut_page.php");

?>

    <!-- Haut de la page, bannière de présentation -->
    <header class="banner">
        <h1>Cards Crud</h1>
    </header>

    <table class="table-crud">
        <thead>
            <tr>
                <th>Name</th>
                <th>Title</th>
                <th>Image</th>
                <th>Attack</th>
                <th>Defense</th>
                <th>Magic</th>
                <th>Difficulty</th>
                <th>Description</th>
                <th>Modify</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($champions as $key => $champion):
                echo "<tr>";

                echo "<td>" . $champion["name"] . "</td>";
                echo "<td>" . $champion["title"] . "</td>";
                echo "<td>" . $champion["image"] . "</td>";
                echo "<td>" . $champion["attack"] . "</td>";
                echo "<td>" . $champion["defense"] . "</td>";
                echo "<td>" . $champion["magic"] . "</td>";
                echo "<td>" . $champion["difficulty"] . "</td>";
                echo "<td>" . $champion["description"] . "</td>";
                
                echo "<td> <a href='?id=" . $champion["id"] . "&action=modify'> Modify </a></td>";
                echo "<td> <a href='?id=" . $champion["id"] . "&action=delete'> Delete </a></td>";

                echo "</tr>";
            endforeach; ?>
        </tbody>
    </table>

    <br><br>

    <form method="POST" class="form-crud">
        <input type="hidden" name="id" value="<?= isset($championToEdit) ? $championToEdit["id"] : "" ?>">

        <label for="name">Name :</label>
        <input type="text" name="name" id="name" value="<?= isset($championToEdit) ? htmlspecialchars($championToEdit["name"]) : "" ?>">

        <label for="title">Title :</label>
        <input type="text" name="title" id="title" value="<?= isset($championToEdit) ? htmlspecialchars($championToEdit["title"]) : "" ?>">

        <label for="image">Image :</label>
        <input type="text" name="image" id="image" value="<?= isset($championToEdit) ? htmlspecialchars($championToEdit["image"]) : "" ?>">

        <label for="attack">Attack :</label>
        <input type="number" name="attack" id="attack" value="<?= isset($championToEdit) ? $championToEdit["attack"] : "" ?>">

        <label for="defense">Defense :</label>
        <input type="number" name="defense" id="defense" value="<?= isset($championToEdit) ? $championToEdit["defense"] : "" ?>">

        <label for="magic">Magic :</label>
        <input type="number" name="magic" id="magic" value="<?= isset($championToEdit) ? $championToEdit["magic"] : "" ?>">

        <label for="difficulty">Difficulty :</label>
        <input type="number" name="difficulty" id="difficulty" value="<?= isset($championToEdit) ? $championToEdit["difficulty"] : "" ?>">

        <label for="description">Description :</label>
        <input type="text" name="description" id="description" value="<?= isset($championToEdit) ? htmlspecialchars($championToEdit["description"]) : "" ?>">

        <input type="submit" value="<?= isset($championToEdit) ? "Modify champion" : "Create champion" ?>">
    </form>

<?php

require_once("bas_page.php");

?>