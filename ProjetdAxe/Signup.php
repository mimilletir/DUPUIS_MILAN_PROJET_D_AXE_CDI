<?php

require_once("connexion.php");

if($_POST){

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "INSERT INTO user (email, password) VALUES(:email, :password)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT)
    ]);

    echo "Votre user a été correctement inséré en BDD";

    header("Location: Login.php");
}


require_once("haut_page.php");

?>

    <!-- Haut de la page, bannière de présentation -->
    <header class="small-banner">
    </header>

    <form method="POST" class="auth-form">
        <h3>Sign-up</h3>
        
        <label for="email">Email :</label>
        <input type="text" name="email" id="email" placeholder="Email">

        <label for="password">Password :</label>
        <input type="password" name="password" id="password" placeholder="Password">

        <input type="submit" value="Sign-up">
    </form>

    <a class="auth-link" href="Login.php">Already an account ? Log in</a>

<?php

require_once("bas_page.php");

?>