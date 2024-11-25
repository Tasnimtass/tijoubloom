<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
    </head>
<body>
<header>
    <h1>Bienvenu sur Tijou Bloom</h1>
    <a href="index.php" class='hd'>retour au page principale</a>

</header>
<main>
    <form action="flowerrecherche.php" method="POST">
    <label for="flr">Rechercher une Fleure :</label>
    <input type="text" id="flr" name="flr">
    <input type="submit" value="Rechercher">
</form>
<?php
$connexion = mysqli_connect("localhost", "root", "", "tijou_bloom");

if (!$connexion) {
    die("<div style='color:red;'>Connexion échouée : " . mysqli_connect_error() . "</div>");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['flr']) ) {
    $flower = mysqli_real_escape_string($connexion, $_POST['flr']);

    // Requête SQL pour rechercher les products dans la catégorie
    $sql = "SELECT * FROM flowers WHERE name LIKE '%".$flower."%'";
    $result = mysqli_query($connexion, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo '<table border="1">';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Nom</th>';
        echo '<th>Prix</th>';
        echo '<th>Stock</th>';
        echo '</tr>';

        while ($ligne = mysqli_fetch_assoc($result)) {
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
}

// Fermeture de la connexion
mysqli_close($connexion);
?>

</main>

</body>
</html>