<?php
session_start();
ob_start(); 

$hote = 'localhost';
$nom_bdd = 'user';
$utilisateur_db = 'root';
$mot_de_passe_db = '';

try {
    $dbh = new PDO("mysql:host=$hote;dbname=$nom_bdd", $utilisateur_db, $mot_de_passe_db);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("<h1>Erreur BDD</h1> Vérifiez que la base s'appelle bien 'user'. Erreur : " . $e->getMessage());
}

$message_succes = "";
$erreurs = [];

if (isset($_POST['new_message']) && isset($_SESSION['name'])) {
    $le_message = htmlspecialchars($_POST['content_message']);
    
    if (!empty($le_message)) {
        $sql = "INSERT INTO message (name, message) VALUES (:name, :message)";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([
            'name' => $_SESSION['name'],
            'message' => $le_message
        ]);
        header("Location: index.php");
        exit();
    }
}

if (isset($_POST['inscription'])) {
    $nom_utilisateur = htmlspecialchars($_POST['username']);
    $mot_de_passe = $_POST['password'];
    $nom_reel = htmlspecialchars($_POST['name']);

    if (empty($nom_utilisateur)) $erreurs['inscription'] = "Username vide";
    if (empty($mot_de_passe)) $erreurs['inscription'] = "Password vide";
    if (empty($nom_reel)) $erreurs['inscription'] = "Name vide";

    if (empty($erreurs)) {
        $requete = $dbh->prepare("SELECT id FROM user WHERE username = :username");
        $requete->execute(['username' => $nom_utilisateur]);
        if ($requete->fetch()) $erreurs['inscription'] = "Ce username existe déjà";
    }

    if (empty($erreurs)) {
        $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (name, username, password) VALUES (:name, :username, :password)";
        $stmt = $dbh->prepare($sql);
        $stmt->execute(['name' => $nom_reel, 'username' => $nom_utilisateur, 'password' => $hash]);
        $message_succes = "Inscription validée ! Connectez-vous ci-dessous.";
    }
}

if (isset($_POST['connexion'])) {
    $nom_utilisateur = htmlspecialchars($_POST['username']);
    $mot_de_passe = $_POST['password'];

    if (empty($nom_utilisateur) || empty($mot_de_passe)) {
        $erreurs['connexion'] = "Veuillez tout remplir";
    } else {
        $stmt = $dbh->prepare("SELECT * FROM user WHERE username = :username");
        $stmt->execute(['username' => $nom_utilisateur]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($mot_de_passe, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['name'] = $user['name'];
            header("Location: index.php");
            exit();
        } else {
            $erreurs['connexion'] = "Identifiants incorrects";
        }
    }
}

$stmt = $dbh->query("SELECT * FROM message ORDER BY id DESC");
$liste_messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>TP Final</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">

    <?php if (isset($_SESSION['username'])): ?>
        
        <a href="logout.php" class="btn-deco">Se déconnecter</a>
        <h1>Bonjour, <?php echo htmlspecialchars($_SESSION['name']); ?></h1>
        <hr>

        <h3>Chat Général</h3>
        <div class="chat-box">
            <?php foreach($liste_messages as $m): ?>
                <div class="msg">
                    <span class="auteur"><?php echo htmlspecialchars($m['name']); ?> :</span><br>
                    <?php echo nl2br(htmlspecialchars($m['message'])); ?>
                </div>
            <?php endforeach; ?>
        </div>

        <form method="post" action="index.php">
            <textarea name="content_message" placeholder="Votre message..."></textarea>
            <input type="submit" value="Envoyer" name="new_message">
        </form>

    <?php else: ?>

        <?php if ($message_succes) echo "<p class='success'>$message_succes</p>"; ?>

        <div style="display:flex; gap: 20px;">
            <div style="flex:1;">
                <h2>Inscription</h2>
                <form method="post" action="index.php">
                    <label>Name (Nom complet)</label>
                    <input type="text" name="name">
                    
                    <label>Username</label>
                    <input type="text" name="username">
                    
                    <label>Password</label>
                    <input type="password" name="password">
                    
                    <?php if (isset($erreurs['inscription'])) echo "<p class='error'>".$erreurs['inscription']."</p>"; ?>
                    <input type="submit" value="S'inscrire" name="inscription">
                </form>
            </div>

            <div style="flex:1;">
                <h2>Connexion</h2>
                <form method="post" action="index.php">
                    <label>Username</label>
                    <input type="text" name="username">
                    
                    <label>Password</label>
                    <input type="password" name="password">
                    
                    <?php if (isset($erreurs['connexion'])) echo "<p class='error'>".$erreurs['connexion']."</p>"; ?>
                    <input type="submit" value="Se connecter" name="connexion">
                </form>
            </div>
        </div>

    <?php endif; ?>

</div>
<?php ob_end_flush(); ?>
</body>
</html>