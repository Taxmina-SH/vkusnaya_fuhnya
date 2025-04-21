<?php
include 'db_connect.php';

$recipe_id = $_GET['id'];

// SQL-запрос для удаления рецепта
$sql = "DELETE FROM recipes WHERE id = " . $recipe_id;

if ($conn->query($sql) === TRUE) {
    echo "<p>Рецепт успешно удален!</p>";
    header("Location: index.php"); // Редирект на главную
} else {
    echo "Ошибка: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
