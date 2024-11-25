<?php
// Connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "", "tijou_bloom");

if (!$connexion) {
    die("Connexion échouée : " . mysqli_connect_error());
}

// Gestion de l'insertion de café
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_coffee'])) {
    $name = mysqli_real_escape_string($connexion, $_POST['namec']);
    $price = floatval($_POST['pricec']);
    $size = intval($_POST['sizec']);

    $sql = "INSERT INTO coffee (name, size, price) VALUES ('$name', $size, $price)";
    if (mysqli_query($connexion, $sql)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Erreur : " . mysqli_error($connexion) . "<br>";
    }
}

// Récupération des données de la table coffee
$sql = "SELECT * FROM coffee ORDER BY price";
$resultat = mysqli_query($connexion, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Café</title>
    <link rel="stylesheet" href="coffee.css">
</head>
<body>
<section>
    <form action="coffee.php" method="POST">
        <h2>Ajouter un café</h2>
        <label for="namec">Nom :</label>
        <input type="text" id="name" name="namec" required>
        
        <label for="pricec">Prix :</label>
        <input type="number" id="price" name="pricec" step="0.01" required>

        <label for="sizec">Stock :</label>
        <input type="number" id="size" name="sizec" required>
        <br><br>
        <button type="submit" name="submit_coffee">Ajouter un café</button>
    </form>
</section>
<br>
<a href="tijoubloom.php">Retour</a>
<section>
    <h2>Liste des cafés</h2>
    <?php
    if (mysqli_num_rows($resultat) > 0) {
        echo '<table border="1">';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Nom</th>';
        echo '<th>Stock</th>';
        echo '<th>Prix</th>';
        echo '</tr>';

        while ($ligne = mysqli_fetch_assoc($resultat)) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($ligne['idCoffee']) . '</td>';
            echo '<td>' . htmlspecialchars($ligne['name']) . '</td>';
            echo '<td>' . htmlspecialchars($ligne['size']) . '</td>';
            echo '<td>' . htmlspecialchars($ligne['price']) . '</td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo '<p>Aucun café trouvé.</p>';
    }
    ?>
</section>
</body>
</html>
