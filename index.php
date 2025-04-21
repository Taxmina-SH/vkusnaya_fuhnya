<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вкусная кухня</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Вкусная кухня</h1>
        <a href="add_recipe.php" class="add-button">Добавить рецепт</a>
    </header>

    <main class="recipes-grid">
        <?php
        include 'db_connect.php';

        $sql = "SELECT id, title, image FROM recipes"; // Выбираем ID, название и путь к изображению
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<a href="recipe.php?id=' . $row["id"] . '" class="recipe-card">';
                echo '<div class="recipe-card-image-container">';
                echo '<img src="' . $row["image"] . '" alt="' . $row["title"] . '">';
                echo '</div>';
                echo '<h2>' . $row["title"] . '</h2>';
                echo '</a>';
            }
        } else {
            echo "<p>Рецептов пока нет.</p>";
        }

        $conn->close();
        ?>
    </main>

</body>
</html>
