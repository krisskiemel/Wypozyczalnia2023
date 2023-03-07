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
                    
                    echo "    <input type='submit' value='Nowy użytkownik'>";
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
                        echo "    <input type='submit' value='Edytuj'>";
                        echo "  </form>";
                        echo "  <form action='uzytkownicy.php' method='GET'>";
                        echo "    <input type='hidden' name='typ' value='usun'>";
                        echo "    <input type='hidden' name='id' value='" . $row['id_pracownika'] . "'>";
                        echo "    <input type='submit' value='Usuń'>";
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
                        <label for="imie">Imię:</label><br>
                        <input type="text" id="imie" name="imie" maxlength="20"><br>
                        <label for="nazwisko">Nazwisko:</label><br>
                        <input type="text" id="nazwisko" name="nazwisko" maxlength="50"><br>
                        <label for="pesel">Pesel:</label><br>
                        <input type="text" id="pesel" name="pesel" maxlength="11"><br>
                        <label for="login">Login:</label><br>
                        <input type="text" id="login" name="login" maxlength="6"><br>
                        <input type="hidden" name="haslo" value="<?php echo md5('test');?>"><br>
                        <input type="submit" value="Utwórz">
                    </form>

                    <?php
                    break;
                case "edytuj":
                    echo "EDYTUJ";
                    break;
                case "usun":
                    echo "USUŃ";
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