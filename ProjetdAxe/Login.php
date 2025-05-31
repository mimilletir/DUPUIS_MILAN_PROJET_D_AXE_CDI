<?php

    require_once("connexion.php");

    if(isset($_SESSION["user_id"])) {
        header("location: Profil.php");
    }

    if($_POST){
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);
    
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            header("Location: Login.php");
            exit;
        }

        if (!empty($email) && !empty($password)){   
            $stmt = $pdo->prepare("SELECT user_id, email, password FROM user WHERE email = :email");
            $stmt->execute(["email" => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && password_verify($password, $user["password"])){
                $_SESSION["user_id"] = $user["user_id"];
                $_SESSION["email"] = $user["email"];

                header("Location: Profil.php");
                exit;

            } else {
                header("Location: Login.php");
            }
        }
    }

    if(isset($_GET["action"]) && $_GET["action"] == "deconnexion")
    {
        unset($_SESSION["user_id"]);
        unset($_SESSION["email"]);
        header("Location: Login.php");
    }


require_once("haut_page.php");

?>

    <!-- Haut de la page, bannière de présentation -->
    <header class="small-banner">
    </header>

    <?php if(!isset($_SESSION["user_id"]) ) { ?>
        <form method="POST" class="auth-form">
            <h3>Log in</h3>

            <label for="email">Email :</label>
            <input type="text" name="email" id="email" placeholder="Email">

            <label for="password">Password :</label>
            <input type="password" name="password" id="password" placeholder="Password">

            <input type="submit" value="Log in">
        </form>

        <a class="auth-link" href="Signup.php">Create an account</a>
    
    <?php } else { ?>

        <a href="?action=deconnexion">Log out</a>

    <?php } ?>

<?php

require_once("bas_page.php");

?>