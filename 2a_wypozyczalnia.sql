-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 07 Mar 2023, 18:26
-- Wersja serwera: 10.4.24-MariaDB
-- Wersja PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `2a_wypozyczalnia`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klienci`
--

CREATE TABLE `klienci` (
  `id_klienta` int(11) NOT NULL,
  `imie` varchar(20) NOT NULL,
  `nazwisko` varchar(30) NOT NULL,
  `adres` varchar(50) NOT NULL,
  `nr_dowodu` varchar(9) NOT NULL,
  `nr_prawa_jazdy` varchar(15) NOT NULL,
  `nr_tel` varchar(12) NOT NULL,
  `ilosc_wyp` int(11) NOT NULL,
  `rabat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `klienci`
--

INSERT INTO `klienci` (`id_klienta`, `imie`, `nazwisko`, `adres`, `nr_dowodu`, `nr_prawa_jazdy`, `nr_tel`, `ilosc_wyp`, `rabat`) VALUES
(2, 'Jan', 'Kowalski', '', '', '0', '', 0, 0),
(3, 'Adam', 'Wiśniewski', '', '', '0', '', 0, 0),
(4, 'Jarosław', 'Bugaj', '', '', '0', '', 0, 0),
(5, 'Antoni', 'Kowal', '', '', '0', '', 0, 0),
(6, 'Maciej', 'Laskowski', '', '', '0', '', 0, 0),
(7, 'Kornel', 'Nowak', '', '', '0', '', 0, 0),
(8, 'Karol', 'Kowalski', '12-345 Poznań, ul. Wysoka 23/34', 'ADB123456', '0', '+48 123 456 ', 0, 5),
(9, 'Krzysztof', 'Kiemel', '12-345 Poznań, u. Wysoka 23/34', 'DFG123456', '101010/23/89', '+48 123 456 ', 0, 5),
(10, 'Krzysztof', 'Kiemel', '12-345 Poznań, u. Wysoka 23/34', 'DFG123456', '101010/23/89', '+48 123 456 ', 0, 5),
(11, 'Krzysztof', 'Kiemel', '12-345 Poznań, u. Wysoka 23/34', 'DFG123456', '101010/23/89', '+48 123 456 ', 0, 5),
(12, 'Krzysztof', 'Kiemel', '12-345 Poznań, u. Wysoka 23/34', 'DFG123456', '101010/23/89', '+48 123 456 ', 0, 5);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kolory`
--

CREATE TABLE `kolory` (
  `id_koloru` int(11) NOT NULL,
  `kolor` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownicy`
--

CREATE TABLE `pracownicy` (
  `id_pracownika` int(11) NOT NULL,
  `imie` varchar(20) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `pesel` varchar(11) NOT NULL,
  `login` varchar(10) NOT NULL,
  `haslo` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `pracownicy`
--

INSERT INTO `pracownicy` (`id_pracownika`, `imie`, `nazwisko`, `pesel`, `login`, `haslo`) VALUES
(1, 'Marek', 'Wiśniewski', '06272312345', 'marwis', ''),
(2, 'Jacek', 'Nowak', '04272312345', 'jacnow', ''),
(3, 'Jan', 'Kowalski', '99062312345', 'jankow', ''),
(4, 'Jan', 'Nowak', '56576576576', 'jannow', '098f6bcd4621d373cade4e832627b4f6');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `samochody`
--

CREATE TABLE `samochody` (
  `vin` varchar(17) NOT NULL,
  `marka` varchar(20) NOT NULL,
  `model` varchar(25) NOT NULL,
  `nr_rej` varchar(8) NOT NULL,
  `st_licz` int(11) NOT NULL,
  `cena_km` float NOT NULL,
  `cena_dz` float NOT NULL,
  `miejsca` int(11) NOT NULL,
  `typ_nadw` int(11) NOT NULL,
  `typ_napedu` int(11) NOT NULL,
  `kolor` int(11) NOT NULL,
  `opis` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `typy_nadwozia`
--

CREATE TABLE `typy_nadwozia` (
  `id_typu_nadwozia` int(11) NOT NULL,
  `typ_nadwozia` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `typy_napedu`
--

CREATE TABLE `typy_napedu` (
  `id_typu_napedu` int(11) NOT NULL,
  `typ_napedu` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wypozyczenia`
--

CREATE TABLE `wypozyczenia` (
  `id_wypozyczenia` int(11) NOT NULL,
  `id_samochodu` int(11) NOT NULL,
  `id_klienta` int(11) NOT NULL,
  `id_pracownika_wyp` int(11) NOT NULL,
  `id_pracownika_zwr` int(11) DEFAULT NULL,
  `data_wyp` date NOT NULL,
  `data_zwr` date DEFAULT NULL,
  `stan_licz_wyp` int(11) NOT NULL,
  `stan_licz_zwr` int(11) DEFAULT NULL,
  `cena_wyp` float DEFAULT NULL,
  `zaliczka` float NOT NULL,
  `do_zaplaty` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `klienci`
--
ALTER TABLE `klienci`
  ADD PRIMARY KEY (`id_klienta`);

--
-- Indeksy dla tabeli `kolory`
--
ALTER TABLE `kolory`
  ADD PRIMARY KEY (`id_koloru`);

--
-- Indeksy dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD PRIMARY KEY (`id_pracownika`);

--
-- Indeksy dla tabeli `samochody`
--
ALTER TABLE `samochody`
  ADD PRIMARY KEY (`vin`),
  ADD KEY `nadwozie` (`typ_nadw`),
  ADD KEY `naped` (`typ_napedu`),
  ADD KEY `kolor` (`kolor`);

--
-- Indeksy dla tabeli `typy_nadwozia`
--
ALTER TABLE `typy_nadwozia`
  ADD PRIMARY KEY (`id_typu_nadwozia`);

--
-- Indeksy dla tabeli `typy_napedu`
--
ALTER TABLE `typy_napedu`
  ADD PRIMARY KEY (`id_typu_napedu`);

--
-- Indeksy dla tabeli `wypozyczenia`
--
ALTER TABLE `wypozyczenia`
  ADD PRIMARY KEY (`id_wypozyczenia`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `klienci`
--
ALTER TABLE `klienci`
  MODIFY `id_klienta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `kolory`
--
ALTER TABLE `kolory`
  MODIFY `id_koloru` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  MODIFY `id_pracownika` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `typy_nadwozia`
--
ALTER TABLE `typy_nadwozia`
  MODIFY `id_typu_nadwozia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `typy_napedu`
--
ALTER TABLE `typy_napedu`
  MODIFY `id_typu_napedu` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `wypozyczenia`
--
ALTER TABLE `wypozyczenia`
  MODIFY `id_wypozyczenia` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `samochody`
--
ALTER TABLE `samochody`
  ADD CONSTRAINT `kolor` FOREIGN KEY (`kolor`) REFERENCES `kolory` (`id_koloru`),
  ADD CONSTRAINT `nadwozie` FOREIGN KEY (`typ_nadw`) REFERENCES `typy_nadwozia` (`id_typu_nadwozia`),
  ADD CONSTRAINT `naped` FOREIGN KEY (`typ_napedu`) REFERENCES `typy_napedu` (`id_typu_napedu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
