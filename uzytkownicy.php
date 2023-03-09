<?php
    require('connect.php');
    if (isset($_REQUEST['typ'])) {
        $typ = $_REQUEST['typ'];
    } else {
        $typ = '';
    }
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
            $option = 4;
            require('menu.php');
        ?>
        <section>
            <?php  
            
            switch ($typ) {
                case "":
                    $sql = "SELECT id_pracownika, imie, nazwisko, pesel, login FROM pracownicy ORDER BY nazwisko, imie";
                    $result = mysqli_query($connect, $sql); 
                    echo "  <form action='uzytkownicy.php' method='GET'>";
                    echo "    <input type='hidden' name='typ' value='nowy'>";
                    
                    echo "    <input type='submit' class='button' value='Nowy użytkownik'>";
                    echo "  </form>"; 
                    ?>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Imię</th>
                            <th>Nazwisko</th>
                            <th>PESEL</th>
                            <th>Login</th>
                            <th></th>
                        </tr>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id_pracownika'] . "</td>";
                        echo "<td>" . $row['imie'] . "</td>";
                        echo "<td>" . $row['nazwisko'] . "</td>";
                        echo "<td>" . $row['pesel'] . "</td>";
                        echo "<td>" . $row['login'] . "</td>";
                        echo "<td>";
                        echo "  <form action='uzytkownicy.php' method='GET'>";
                        echo "    <input type='hidden' name='typ' value='edytuj'>";
                        echo "    <input type='hidden' name='id' value='" . $row['id_pracownika'] . "'>";
                        echo "    <input type='submit' class='button' value='Edytuj'>";
                        echo "  </form>";
                        echo "  <form action='uzytkownicy.php' method='GET'>";
                        echo "    <input type='hidden' name='typ' value='usun'>";
                        echo "    <input type='hidden' name='id' value='" . $row['id_pracownika'] . "'>";
                        echo "    <input type='submit' class='button' value='Usuń'>";
                        echo "  </form>";

                        echo "</td>";
                        echo "</tr>";
                    }    
                    echo "</table>";
                    break;
                case "nowy":
                    ?>
                    <h2>NOWY UŻYTKOWNIK</h2>
                    <form action="uzytkownicy.php" method="GET">
                        <input type="hidden" name="typ" value="nowydb">
                        <label for="imie">Imię:</label><br>
                        <input type="text" id="imie" name="imie" maxlength="20"><br>
                        <label for="nazwisko">Nazwisko:</label><br>
                        <input type="text" id="nazwisko" name="nazwisko" maxlength="50"><br>
                        <label for="pesel">Pesel:</label><br>
                        <input type="text" id="pesel" name="pesel" maxlength="11"><br>
                        <label for="login">Login:</label><br>
                        <input type="text" id="login" name="login" maxlength="6"><br>
                        <input type="hidden" name="haslo" value="<?php echo md5('test');?>"><br>
                        <input type="submit" class='button' value="Utwórz">
                    </form>

                    <?php
                    break;
                case "nowydb":
                    $imie = $_REQUEST['imie'];
                    $nazwisko = $_REQUEST['nazwisko'];
                    $pesel = $_REQUEST['pesel'];
                    $login = $_REQUEST['login'];
                    $haslo = $_REQUEST['haslo'];
                    $sql1 = "SELECT * FROM pracownicy WHERE login='$login'";
                    $result = mysqli_query($connect, $sql1);
                    if ($row = mysqli_fetch_array($result)) {
                        echo "Podany login: $login istnieje już w systemie.<br>";
                        echo "<button class='button' onClick='history.go(-1)'>Powrót</button>";
                    } else {
                        $sql2 = "INSERT INTO pracownicy (imie, nazwisko, pesel, login, haslo)
                        VALUES ('$imie', '$nazwisko', '$pesel', '$login', '$haslo')";
                        mysqli_query($connect, $sql2);
                        echo "Dodano nowego użytkownika:<br>
                            Imię: $imie<br>Nazwisko: $nazwisko<br>Login: $login<br>";
                        echo "<button class='button' onClick=\"location.href='uzytkownicy.php'\">Powrót</button>";
                    }
                    break;
                case "edytuj":
                    $id = $_REQUEST['id'];
                    $sql = "SELECT imie, nazwisko, pesel, login FROM pracownicy WHERE id_pracownika = $id";
                    $result = mysqli_query($connect, $sql);
                    $row = mysqli_fetch_array($result);
                    ?>
                    <h2>EDYCJA UŻYTKOWNIKA</h2>
                    <form action="uzytkownicy.php" method="GET">
                        <input type="hidden" name="typ" value="edytujdb">
                        <label for="imie">Id:</label><br>
                        <input type="text" id="id" name="id" value="<?php echo $id;?>" readonly><br>
                        <label for="imie">Imię:</label><br>
                        <input type="text" id="imie" name="imie" maxlength="20" value="<?php echo $row['imie']?>"><br>
                        <label for="nazwisko">Nazwisko:</label><br>
                        <input type="text" id="nazwisko" name="nazwisko" maxlength="50" value="<?php echo $row['nazwisko']?>"><br>
                        <label for="pesel">Pesel:</label><br>
                        <input type="text" id="pesel" name="pesel" maxlength="11" value="<?php echo $row['pesel']?>" disabled><br>
                        <label for="login">Login:</label><br>
                        <input type="text" id="login" name="login" maxlength="6" value="<?php echo $row['login']?>"><br>
                        <br>
                        <input type="submit" class='button' value="Zachowaj zmiany">
                    </form>
                    <?php
                    break;
                case "edytujdb":
                    $id = $_REQUEST['id'];
                    $imie = $_REQUEST['imie'];
                    $nazwisko = $_REQUEST['nazwisko'];
                    $login = $_REQUEST['login'];
                    $sql = "UPDATE pracownicy SET imie='$imie', nazwisko='$nazwisko', login='$login' WHERE id_pracownika=$id";
                    mysqli_query($connect, $sql);
                    echo "Zmieniono dane użytkownika:<br>
                            Imię: $imie<br>Nazwisko: $nazwisko<br>Login: $login<br>";
                    echo "<button class='button' onClick=\"location.href='uzytkownicy.php'\">Powrót</button>";
                    break;
                case "usun":
                    $id = $_REQUEST['id'];
                    $sql = "SELECT imie, nazwisko FROM pracownicy WHERE id_pracownika = $id";
                    $result = mysqli_query($connect, $sql);
                    $row = mysqli_fetch_array($result);
                    ?>
                    <h2>USUWANIE UŻYTKOWNIKA</h2>
                    Czy na pewno chcesz usunąć użytkownika: <?php echo $row['imie'] . " " . $row['nazwisko'];?><br>
                    <form action="uzytkownicy.php" method="GET">
                        <input type="hidden" name="typ" value="usundb">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="hidden" name="imie" value="<?php echo $row['imie'];?>">
                        <input type="hidden" name="nazwisko" value="<?php echo $row['nazwisko'];?>">
                        <input type="submit" class='button' value="Tak">
                    </form>
                    <button class='button' onClick='history.go(-1)'>Nie</button> 
                    <?php
                    break;
                case "usundb":
                    $id = $_REQUEST['id'];
                    $imie = $_REQUEST['imie'];
                    $nazwisko = $_REQUEST['nazwisko'];
                    $sql = "DELETE FROM pracownicy WHERE id_pracownika = $id";
                    mysqli_query($connect, $sql);
                    echo "Usunięto użytkownika: ID: $id $imie $nazwisko<br>";
                    echo "<button class='button' onClick=\"location.href='uzytkownicy.php'\">Powrót</button>";
                    break;
            }
            ?>
        </section>
    </div>
</body>
</html>
<?php
    mysqli_close($connect);
?>