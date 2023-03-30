<?php
    require('connect.php');
    session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wypożyczalnia samochodów - Samochody</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
        <?php
            $option = 3;
            require('menu.php');
        ?>
        <section>
            Samochody
        </section>
    </div>
</body>
</html>