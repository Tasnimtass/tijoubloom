<?php
// Connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "", "tijou_bloom");

if (!$connexion) {
    die("Connexion échouée : " . mysqli_connect_error());
}

// Gestion de l'insertion de commande
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_order'])) {
    $coffeeID = intval($_POST['coffeeID']);
    $flowerID = intval($_POST['flowerID']);

    // Vérification des IDs
    $coffeeCheck = "SELECT idCoffee FROM coffee WHERE idCoffee = $coffeeID";
    $flowerCheck = "SELECT idFlower FROM flowers WHERE idFlower = $flowerID";

    $coffeeResult = mysqli_query($connexion, $coffeeCheck);
    $flowerResult = mysqli_query($connexion, $flowerCheck);

    if (mysqli_num_rows($coffeeResult) > 0 && mysqli_num_rows($flowerResult) > 0) {
        // Insérer la commande
        $sql = "INSERT INTO orders (coffeeID, flowerID) VALUES ($coffeeID, $flowerID)";
        if (mysqli_query($connexion, $sql)) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Erreur lors de l'ajout de la commande : " . mysqli_error($connexion);
        }
    } else {
        echo "Erreur : ID du café ou de la fleur invalide.";
    }
}

// Récupérer les commandes
$sql = "SELECT * FROM orders";
$resultat = mysqli_query($connexion, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Commandes</title>
    <link rel="stylesheet" href="commande.css">
</head>
<body>
    <header>
        <h1>Gestion des Commandes - Tijou Bloom</h1>
    </header>
    <section>
        <!-- Formulaire pour ajouter une commande -->
        <form action="" method="POST">
            <h2>Ajouter une commande</h2>
            <label for="coffeeID">ID du café :</label>
            <input type="number" id="coffeeID" name="coffeeID" required>

            <label for="flowerID">ID de la fleur :</label>
            <input type="number" id="flowerID" name="flowerID" required>
            <br><br>

            <button type="submit" name="submit_order">Ajouter une commande</button>
            <br><br>
        </form>
    </section>
    <a href="tijoubloom.php">Retour</a>
    <section>
        <!-- Affichage des commandes -->
        <h2>Liste des Commandes</h2>
        <?php
        if (mysqli_num_rows($resultat) > 0) {
            echo '<table border="1">';
            echo '<tr>';
            echo '<th>ID de la commande</th>';
            echo '<th>ID du café</th>';
            echo '<th>ID de la fleur</th>';
            echo '</tr>';

            while ($ligne = mysqli_fetch_assoc($resultat)) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($ligne['id']) . '</td>';
                echo '<td>' . htmlspecialchars($ligne['coffeeID']) . '</td>';
                echo '<td>' . htmlspecialchars($ligne['flowerID']) . '</td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo '<p>Aucune commande trouvée.</p>';
        }
        ?>
    </section>
</body>
</html>
