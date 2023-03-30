<nav>
    <ul>
        <?php
        if ($option == 1) {
            $act = " class='active'";
        } else {
            $act = "";
        }       
        echo "<li class='opcja link'><a$act href='wypozyczenia.php'>Wypożyczenia</a></li>\n";
        if ($option == 2) {
            $act = " class='active'";
        } else {
            $act = "";
        }    
        echo "<li class='opcja link'><a$act href='klienci.php'>Klienci</a></li>\n";
        if ($option == 3) {
            $act = " class='active'";
        } else {
            $act = "";
        }
        echo "<li class='opcja link'><a$act href='samochody.php'>Samochody</a></li>\n";
        if ($option == 4) {
            $act = " class='active'";
        } else {
            $act = "";
        }
        echo "<li class='opcja link'><a$act href='uzytkownicy.php'>Użytkownicy</a></li>\n";
        if ($option == 5) {
            $act = " class='active'";
        } else {
            $act = "";
        }
        if ($_SESSION['zalogowany']) {
            echo "<li class='opcja logowanie'><a>Użytkownik: {$_SESSION['login']}</a></li>\n";
        } else {
            echo "<li class='opcja logowanie'><a$act href='logowanie.php'>Logowanie</a></li>\n";
        }    
        ?>       
    </ul>
</nav>