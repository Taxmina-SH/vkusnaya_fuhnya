<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить рецепт</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Вкусная кухня</h1>
        <a href="index.php">Главная</a>
    </header>

    <main>
        <h2>Добавить рецепт</h2>
        <form action="add_recipe.php" method="POST" enctype="multipart/form-data"> <!-- enctype для загрузки файлов -->
            <label for="title">Название:</label>
            <input type="text" id="title" name="title" required><br><br>

            <label for="image">Изображение:</label>
            <input type="file" id="image" name="image" accept="image/*" required><br><br>

            <label for="ingredients">Ингредиенты:</label>
            <textarea id="ingredients" name="ingredients" rows="5" required></textarea><br><br>

            <label for="instructions">Инструкции:</label>
            <textarea id="instructions" name="instructions" rows="10" required></textarea><br><br>

            <button type="submit">Добавить рецепт</button>
        </form>

        <?php
        include 'db_connect.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $ingredients = $_POST["ingredients"];
            $instructions = $_POST["instructions"];

            // Обработка загрузки изображения
            $target_dir = "images/"; // Папка для хранения изображений
            $image_name = basename($_FILES["image"]["name"]);
            $target_file = $target_dir . $image_name;
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // Проверка, является ли файл изображением
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if($check === false) {
                echo "Файл не является изображением.";
                $uploadOk = 0;
            }

            // Проверка размера файла 
            if ($_FILES["image"]["size"] > 2000000) {
                echo "Слишком большой файл.";
                $uploadOk = 0;
            }

            // Разрешенные форматы изображений 
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                echo "Разрешены только JPG, JPEG, PNG и GIF файлы.";
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                echo "Файл не был загружен.";
            } else {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    // SQL-запрос для вставки данных
                    $sql = "INSERT INTO recipes (title, image, ingredients, instructions) VALUES ('$title', '$target_file', '$ingredients', '$instructions')";

                    if ($conn->query($sql) === TRUE) {
                        echo "<p>Рецепт успешно добавлен!</p>";
                        header("Location: index.php"); // Редирект на главную
                    } else {
                        echo "Ошибка: " . $sql . "<br>" . $conn->error;
                    }
                } else {
                    echo "Ошибка при загрузке файла.";
                }
            }
        }

        $conn->close();
        ?>
    </main>

</body>
</html>
