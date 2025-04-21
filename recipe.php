<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Рецепт</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Вкусная кухня</h1>
        <a href="index.php">Главная</a>
    </header>

    <main class="recipe-details">
        <?php
        include 'db_connect.php';

        $recipe_id = $_GET['id'];

        $sql = "SELECT title, image, ingredients, instructions FROM recipes WHERE id = " . $recipe_id;
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo '<div class="recipe-details-container">';
            echo '<div class="recipe-details-image-container">';
            echo '<img src="' . $row["image"] . '" alt="' . $row["title"] . '">';
            echo '</div>';
            echo '<div class="recipe-details-content">';
            echo '<h2>' . $row["title"] . '</h2>';
            echo '<div class="ingredients">';
            echo '<h3>Ингредиенты:</h3>';
            echo '<p>' . nl2br($row["ingredients"]) . '</p>';
            echo '</div>';
            echo '</div>'; // recipe-details-content
            echo '</div>'; // recipe-details-container
            echo '<h3>Инструкции:</h3>';
            echo '<p>' . nl2br($row["instructions"]) . '</p>';
            echo '<a href="edit_recipe.php?id=' . $recipe_id . '" class="edit-button">Редактировать рецепт</a>';
            echo '<a href="delete_recipe.php?id=' . $recipe_id . '" class="delete-button">Удалить рецепт</a>';

        } else {
            echo "<p>Рецепт не найден.</p>";
        }

        $conn->close();
        ?>
    </main>

</body>
</html>

