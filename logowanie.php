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
    <title>Wypożyczalnia samochodów</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
        <?php
            if (isset($_REQUEST['login']) && isset($_REQUEST['haslo'])) {
                
                $sql = "SELECT login, haslo FROM pracownicy WHERE login = '{$_REQUEST['login']}'";
                $result = mysqli_query($connect, $sql);
                if ($row = mysqli_fetch_array($result)) {
                    if (md5($_REQUEST['haslo']) == $row['haslo']) {
                        $_SESSION['zalogowany'] = true;
                        $_SESSION['login'] = $row['login'];
                        $option = 5;
                        require('menu.php');
                        echo "<section>Logowanie poprawne</section>";
                    } else {
                        session_destroy();
                        $option = 5;
                        require('menu.php');
                        echo "<section>Logowanie niepoprawne. Błędne hasło.</section>";
                    }
                } else {
                    session_destroy();
                    $option = 5;
                    require('menu.php');
                    echo "<section>Logowanie niepoprawne. Podany login nie istnieje.</section>";
                }
            } else {
                $option = 5;
                require('menu.php');
                ?>
                <section>
                    <form action="logowanie.php" method="GET">
                        <label for="login">login:</label><br>
                        <input type="text" id="login" name="login" maxlength="10" required>
                        <br>
                        <label for="haslo">hasło:</label><br>
                        <input type="password" id="haslo" name="haslo" maxlength="10" required>
                        <br>
                        <input type="submit" class="button" value="Zaloguj">
                    </form>
                </section>
            <?php
            }
            ?>
    </div>
</body>
</html>