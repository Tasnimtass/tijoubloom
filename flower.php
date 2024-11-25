<?php
// Connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "", "tijou_bloom");

if (!$connexion) {
    die("Connexion échouée : " . mysqli_connect_error());
}

// Gestion de l'insertion de la fleur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_flower'])) {
    $nameF = mysqli_real_escape_string($connexion, $_POST['nameF']);
    $priceF = floatval($_POST['priceF']);
    $stockF = intval($_POST['stockF']);

    $sql = "INSERT INTO flowers (name, price, stock) VALUES ('$nameF', $priceF, $stockF)";
    if (mysqli_query($connexion, $sql)) {
        // Redirection pour nettoyer les données POST
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Erreur : " . mysqli_error($connexion) . "<br>";
    }
}

// Récupérer les données des fleurs
$sql = "SELECT * FROM flowers ORDER BY price";
$resultat = mysqli_query($connexion, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Fleur</title>
    <link rel="stylesheet" href="flower.css">
</head>
<body>
    <!-- Formulaire pour ajouter une fleur -->
    <section>
        <form action="flower.php" method="POST">
            <h2>Ajouter une fleur</h2>
            <label for="nameF">Nom :</label>
            <input type="text" id="nameF" name="nameF" required>

            <label for="priceF">Prix :</label>
            <input type="number" id="priceF" name="priceF" step="0.01" required>

            <label for="stockF">Stock :</label>
            <input type="number" id="stockF" name="stockF" required>
            <br><br>

            <button type="submit" name="submit_flower">Ajouter une fleur</button>
            <br><br>
        </form>
    </section>
    <a href="tijoubloom.php">Retour</a>

    <!-- Affichage des fleurs -->
    <section>
        <h2>Liste des fleurs</h2>
        <?php
        if (mysqli_num_rows($resultat) > 0) {
            echo '<table border="1">';
            echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Nom</th>';
            echo '<th>Prix</th>';
            echo '<th>Stock</th>';
            echo '</tr>';

            while ($ligne = mysqli_fetch_assoc($resultat)) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($ligne['idFlower']) . '</td>';
                echo '<td>' . htmlspecialchars($ligne['name']) . '</td>';
                echo '<td>' . htmlspecialchars($ligne['price']) . '</td>';
                echo '<td>' . htmlspecialchars($ligne['stock']) . '</td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo '<p>Aucune fleur trouvée.</p>';
        }
        ?>
    </section>
</body>
</html>
