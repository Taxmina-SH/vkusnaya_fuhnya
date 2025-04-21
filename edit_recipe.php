<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать рецепт</title>
    <link rel="stylesheet" href="styles.css">
    <style>
      /* Добавляем стили для контейнера и заголовка */
      .edit-container {
          max-width: 600px;
          margin: 0 auto;
      }

      .edit-container h2 {
          text-align: left; /* Выравниваем заголовок по левому краю */
          margin-bottom: 20px; /* добавляем отступ снизу */
      }
    </style>
</head>
<body>
    <header>
        <h1>Вкусная кухня</h1>
        <a href="index.php">Главная</a>
    </header>

    <main>
        <div class="edit-container">  <!-- Оборачиваем заголовок и форму в контейнер -->
            <h2>Редактировать рецепт</h2>

            <?php
            include 'db_connect.php';

            $recipe_id = $_GET['id'];

            // Получаем информацию о рецепте из базы данных
            $sql = "SELECT title, image, ingredients, instructions FROM recipes WHERE id = " . $recipe_id;
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $title = $row["title"];
                $image = $row["image"];
                $ingredients = $row["ingredients"];
                $instructions = $row["instructions"];
            } else {
                echo "<p>Рецепт не найден.</p>";
                $conn->close();
                exit;
            }
            ?>

            <form action="edit_recipe.php?id=<?php echo $recipe_id; ?>" method="POST" enctype="multipart/form-data">
                <label for="title">Название:</label>
                <input type="text" id="title" name="title" value="<?php echo $title; ?>" required><br><br>

                <label for="image">Изображение:</label>
                <img src="<?php echo $image; ?>" alt="Текущее изображение" width="100"><br>
                <input type="file" id="image" name="image" accept="image/*"><br><br>
                <small>Оставьте поле пустым, чтобы не менять изображение.</small><br><br>

                <label for="ingredients">Ингредиенты:</label>
                <textarea id="ingredients" name="ingredients" rows="5" required><?php echo $ingredients; ?></textarea><br><br>

                <label for="instructions">Инструкции:</label>
                <textarea id="instructions" name="instructions" rows="10" required><?php echo $instructions; ?></textarea><br><br>

                <button type="submit">Сохранить изменения</button>
            </form>
        </div> <!-- Закрываем контейнер -->

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $ingredients = $_POST["ingredients"];
            $instructions = $_POST["instructions"];

            // Обработка загрузки нового изображения (если есть)
            if($_FILES["image"]["name"] != ""){
                $target_dir = "images/";
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

                // Проверка размера файла (не более 2MB)
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
                        $image = $target_file; // Обновляем путь к изображению
                    } else {
                        echo "Ошибка при загрузке файла.";
                    }
                }
            }

            // SQL-запрос для обновления данных
            $sql = "UPDATE recipes SET title='$title', image='$image', ingredients='$ingredients', instructions='$instructions' WHERE id = " . $recipe_id;

            if ($conn->query($sql) === TRUE) {
                echo "<p>Рецепт успешно обновлен!</p>";
                header("Location: recipe.php?id=" . $recipe_id); // Редирект на страницу рецепта
            } else {
                echo "Ошибка: " . $sql . "<br>" . $conn->error;
            }
        }

        $conn->close();
        ?>
    </main>

</body>
</html>
