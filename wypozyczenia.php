<?php
    require('connect.php');
    session_start();
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
            $option = 1;
            require('menu.php');
        ?>
        <section>
            <?php  
            
            switch ($typ) {
                case "":
                    $sql = "SELECT vin, marka, model, nr_rej, cena_km, cena_dz, miejsca, n.typ_nadwozia, k.kolor
                            FROM samochody s
                            JOIN typy_nadwozia n ON n.id_typu_nadwozia = s.typ_nadw
                            JOIN kolory k ON k.id_koloru = s.kolor
                            WHERE status = 'Dostępny'";
                    $result = mysqli_query($connect, $sql); 
                    ?>
                    <table>
                        <tr>
                            <th>VIN</th>
                            <th>Marka</th>
                            <th>Model</th>
                            <th>Nr rejestracyjny</th>
                            <th>Typ nadwozia</th>
                            <th>Miejsca</th>
                            <th>Cena / dzień</th>
                            <th>Cena / km</th>
                            <th>Kolor</th>
                            <th></th>
                        </tr>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['vin'] . "</td>";
                        echo "<td>" . $row['marka'] . "</td>";
                        echo "<td>" . $row['model'] . "</td>";
                        echo "<td>" . $row['nr_rej'] . "</td>";
                        echo "<td>" . $row['typ_nadwozia'] . "</td>";
                        echo "<td>" . $row['miejsca'] . "</td>";
                        echo "<td>" . $row['cena_dz'] . "</td>";
                        echo "<td>" . $row['cena_km'] . "</td>";
                        echo "<td>" . $row['kolor'] . "</td>";
                        echo "<td>";
                        echo "  <form action='wypozyczenia.php' method='GET'>";
                        echo "    <input type='hidden' name='typ' value='wyp'>";
                        echo "    <input type='hidden' name='vin' value='" . $row['vin'] . "'>";
                        echo "    <input type='submit' class='button' value='Wypożycz'>";
                        echo "  </form>";

                        echo "</td>";
                        echo "</tr>";
                    }    
                    echo "</table>";
                    break;
                case "wyp":
                    $vin = $_REQUEST['vin'];
                    $sql = "SELECT marka, model, nr_rej, cena_km, cena_dz, st_licz FROM samochody WHERE vin = '$vin'";
                    $result = mysqli_query($connect, $sql);
                    $row = mysqli_fetch_array($result);
                    ?>
                    <h2>WYPOŻYCZENIE</h2>
                    <br>
                    <h4>Samochód: <?php echo $row['marka'] . " " . $row['model'] . " " . $row['nr_rej'] ?></h4>
                    <br>
                    <form action="wypozyczenia.php" method="GET">
                        <input type="hidden" name="typ" value="wypdb">
                        <input type="hidden" name="vin" value="<?php echo $vin; ?>">
                        <label for="klient">Klient:</label><br>
                        <select id="klient" name="klient">
                            <?php
                            $sql1 = "SELECT id_klienta, imie, nazwisko, nr_dowodu FROM klienci ORDER BY nazwisko, imie";
                            $result1 = mysqli_query($connect, $sql1);
                            while ($row1 = mysqli_fetch_array($result1)) {
                                echo "<option value='{$row1['id_klienta']}'>{$row1['nazwisko']} {$row1['imie']} {$row1['nr_dowodu']}</option>\n";
                            }
                            ?>
                        </select><br>
                        <label for="pracownik">Pracownik:</label><br>
                        <select id="pracownik" name="pracownik">
                            <?php
                            $sql2 = "SELECT id_pracownika, imie, nazwisko FROM pracownicy ORDER BY nazwisko, imie";
                            $result2 = mysqli_query($connect, $sql2);
                            while ($row2 = mysqli_fetch_array($result2)) {
                                echo "<option value='{$row2['id_pracownika']}'>{$row2['id_pracownika']} {$row2['nazwisko']} {$row2['imie']}</option>\n";
                            }
                            ?>
                        </select><br>
                        <label for="cena_dz">Cena/dzień:</label><br>
                        <input type="text" id="cena_dz" name="cena_dz" value="<?php echo $row['cena_dz']; ?>" readonly><br>
                        <label for="cena_km">Cena/km:</label><br>
                        <input type="text" id="cena_km" name="cena_km" value="<?php echo $row['cena_km']; ?>" readonly><br>
                        <label for="st_licz">Stan licznika:</label><br>
                        <input type="text" id="st_licz" name="st_licz" value="<?php echo $row['st_licz']; ?>" readonly><br>
                        <label for="data_wyp">Data wypożyczenia:</label><br>
                        <input type="date" id="data_wyp" name="data_wyp" required><br>
                        <label for="data_zwr">Data zwrotu:</label><br>
                        <input type="date" id="data_zwr" name="data_zwr"><br>
                        <label for="zaliczka">Zaliczka:</label><br>
                        <input type="text" id="zaliczka" name="zaliczka" pattern="[0-9]*[.]?[0-9]+" required><br>
                        <input type="submit" class='button' value="Utwórz">
                    </form>

                    <?php
                    break;
                case "wypdb":
                    $vin = $_REQUEST['vin'];
                    $klient = $_REQUEST['klient'];
                    $pracownik = $_REQUEST['pracownik'];
                    $st_licz = $_REQUEST['st_licz'];
                    $data_wyp = $_REQUEST['data_wyp'];
                    $data_zwr = $_REQUEST['data_zwr'];
                    $zaliczka = $_REQUEST['zaliczka'];
                    $sql1 = "INSERT INTO wypozyczenia(id_samochodu, id_klienta, id_pracownika_wyp, data_wyp, data_zwr, stan_licz_wyp, zaliczka)
                             VALUES ('$vin', $klient, $pracownik, '$data_wyp', '$data_zwr', '$st_licz', '$zaliczka')";
                    mysqli_query($connect, $sql1);
                    $sql2 = "UPDATE samochody SET status='Wypożyczony' WHERE vin='$vin'";
                    mysqli_query($connect, $sql2);
                    echo "Wypożyczono Samochód VIN:<br>
                          $vin<br>";
                    echo "<button class='button' onClick=\"location.href='wypozyczenia.php'\">Powrót</button>";
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