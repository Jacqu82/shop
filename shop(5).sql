-- phpMyAdmin SQL Dump
-- version 4.6.4deb1+deb.cihar.com~xenial.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 07, 2017 at 11:12 PM
-- Server version: 5.7.18-0ubuntu0.16.04.1
-- PHP Version: 7.0.15-0ubuntu0.16.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `adminName` varchar(255) NOT NULL,
  `adminPassword` varchar(255) NOT NULL,
  `adminMail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `adminName`, `adminPassword`, `adminMail`) VALUES
(1, 'slawek', 'slawek1', 'jajarzab@op.pl');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `path` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `path`, `user_id`, `item_id`) VALUES
(9, 'files/131131Yamaha HTR-20671/1_Yamaha HTR-2067.jpg', 9, 131);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `groupName` varchar(255) NOT NULL,
  `groupDescriptiopn` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `groupName`, `groupDescriptiopn`) VALUES
(8, 'AGD', 'Agd male, duze, do zabudowy.Tak.'),
(9, 'RTV', 'Telewizory LCD LED, kino domowe'),
(10, 'Komputery', 'Akcesoria, Laptopy, Stacjonarne'),
(11, 'Telefony & GSM', 'Telefony i akcesoria GSM'),
(12, 'Foto', 'Aparaty, kamery, akcesoria'),
(13, 'Gry i Konsole', 'Gry Pc, Konsole, gry na konsole'),
(14, 'Zegarki ', 'Super bajer zegareczki');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` float(4,2) NOT NULL,
  `description` text NOT NULL,
  `availability` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `name`, `price`, `description`, `availability`, `group_id`) VALUES
(115, 'Amica FK3214DFXIo', 77.00, 'Bardzo oszczedna A+++\r\n120 l. pojemnosci\r\nDwa kolory: grafi i biel.\r\nBia?a', 215, 8),
(116, 'Bosch KGV39XL20E', 79.00, 'Bardzo wydajna\r\nKlasa A+\r\nDobra relacja cena/jakosc', 10, 8),
(117, 'LG OLED55B6J', 99.00, '55 cali w technologii OLED\r\nFunkcjonalny pilot\r\nSmart TV', 1, 9),
(118, 'Sony KDL-40WD655', 49.00, '40\'\r\nBardzo ostry obraz\r\nNowoczesny pilot', 0, 9),
(120, 'Samsung Galaxy A5 2016', 79.00, 'Duzy wyswietlacz\r\nEkran dotykowy\r\nAndroid', 14, 11),
(121, 'Huawei P8 Lite', 49.00, 'Bardzo korzystna cena\r\nOdporny na uszkodzenia\r\nPRzedluzona Gwarancja', 14, 11),
(122, 'LG G6', 89.00, 'Nowoczesny design\r\nCzarny chrom\r\nElegancki', 3, 11),
(123, 'Nikon D3300', 79.00, 'Zoom 24x\r\nKarta pamieci w zestawie\r\nDluga gwarancja', 1, 12),
(124, 'Canon EOS 1200D ', 59.00, 'Niska Cena\r\nZoom x 16\r\nGwarancja 5 lat', 4, 12),
(125, 'Mass Effect Andromeda', 49.00, 'Najnowsza czÄ™Å›Ä‡\r\nDodatkowo DLC\r\nNajwyzsze oceny', 18, 13),
(127, 'Diablo III', 19.00, 'Ostatnia czesc\r\nKlasyka RPG Action\r\nSuper cena', 4, 13),
(128, 'Amica ZWM 668 IED', 79.00, 'Nowoczesna Zmywarka\r\nRewelacyjna cena\r\nOszczÄ™dna', 12, 8),
(129, 'Zelmer Jupiter', 49.00, 'Cicha praca\r\nKabel 5m.\r\nKilka koÅ„cÃ³wek', 10, 8),
(130, 'Philips Azur Performer', 28.00, 'Nowoczesny Design\r\nNiska Cena', 10, 8),
(131, '131Yamaha HTR-20671', 69.00, 'Wysoka jako?? d?wi?ku\r\nNowoczesny design', 2, 9),
(132, 'LG 49LH630V', 69.00, 'Wysoka jakoÅ›c obrazu\r\nSmart TV\r\nNiska cena', 9, 8),
(133, 'Apple Macbook Air 13', 99.00, 'Krystaliczny obraz\r\nSzybki procesor\r\nDysk SSD', 10, 10),
(134, 'ASUS GL753VE 17,3', 99.00, 'SprzÄ™t dla gracza\r\nDuÅ¼y wyÅ›wietlacz\r\nNajnowszy procesor', 2, 10),
(135, 'Apple iPhone 7 ', 79.00, 'Odporna obudowa\r\nDuÅ¼y wyÅ›wietlacz\r\nZadziała??', 54, 11);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `date` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `title`, `content`, `date`, `status`) VALUES
(10, 8, 'wiad1', 'tresc1', '17-05-28', 0),
(12, 8, 'wiad do jacka', 'hej hej', '17-05-28', 0),
(14, 8, 'hej', 'hejeje', '17-05-29', 0),
(15, 8, 'kolejnas', 'taaak', '17-05-29', 0),
(16, 8, 'osdtatania', 'nieee', '17-05-29', 0),
(17, 8, 'rr', 'ff', '17-06-04', 0),
(18, 8, 'trataa', 'sddxss', '17-06-07', 0),
(19, 9, 'hej', 'hejehejehej', '17-06-07', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `amount`, `date`, `status`) VALUES
(1, 9, 292, '17-06-04', 1),
(3, 9, 99, '17-06-04', 1),
(4, 9, 140, '17-06-04', 1),
(5, 9, 252, '17-06-04', 1),
(6, 9, 252, '17-06-04', 1),
(7, 9, 77, '17-06-04', 1),
(8, 9, 77, '17-06-04', 1),
(9, 9, 49, '17-06-04', 1),
(10, 9, 79, '17-06-04', 0),
(11, 9, 19, '17-06-05', 0),
(12, 9, 305, '17-06-07', 0),
(13, 9, 305, '17-06-07', 0),
(14, 9, 305, '17-06-07', 0),
(15, 9, 247, '17-06-07', 1),
(16, 9, 247, '17-06-07', 1),
(17, 9, 245, '17-06-07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id`, `item_id`, `path`) VALUES
(176, 116, 'files/116Bosch KGV39XL20E/1_Bosch KGV39XL20E.jpg'),
(177, 116, 'files/116Bosch KGV39XL20E/2_Bosch KGV39XL20E.jpg'),
(178, 117, 'files/117LG OLED55B6J/1_LG OLED55B6J.jpg'),
(179, 117, 'files/117LG OLED55B6J/2_LG OLED55B6J.jpg'),
(180, 117, 'files/117LG OLED55B6J/3_LG OLED55B6J.jpg'),
(181, 117, 'files/117LG OLED55B6J/4_LG OLED55B6J.jpg'),
(182, 118, 'files/118Sony KDL-40WD655/1_Sony KDL-40WD655.jpg'),
(183, 118, 'files/118Sony KDL-40WD655/2_Sony KDL-40WD655.jpg'),
(184, 118, 'files/118Sony KDL-40WD655/3_Sony KDL-40WD655.jpg'),
(185, 118, 'files/118Sony KDL-40WD655/4_Sony KDL-40WD655.jpg'),
(189, 120, 'files/120Samsung Galaxy A5 2016/1_Samsung Galaxy A5 2016.jpg'),
(190, 120, 'files/120Samsung Galaxy A5 2016/2_Samsung Galaxy A5 2016.jpg'),
(191, 120, 'files/120Samsung Galaxy A5 2016/3_Samsung Galaxy A5 2016.jpg'),
(192, 121, 'files/121Huawei P8 Lite/1_Huawei P8 Lite.jpg'),
(193, 121, 'files/121Huawei P8 Lite/2_Huawei P8 Lite.jpg'),
(194, 121, 'files/121Huawei P8 Lite/3_Huawei P8 Lite.jpg'),
(195, 122, 'files/122LG G6/1_LG G6.jpg'),
(196, 122, 'files/122LG G6/2_LG G6.jpg'),
(197, 122, 'files/122LG G6/3_LG G6.jpg'),
(198, 123, 'files/123Nikon D3300/1_Nikon D3300.jpg'),
(199, 123, 'files/123Nikon D3300/2_Nikon D3300.jpg'),
(200, 123, 'files/123Nikon D3300/3_Nikon D3300.jpg'),
(201, 124, 'files/124Canon EOS 1200D/1_Canon EOS 1200D.jpg'),
(202, 124, 'files/124Canon EOS 1200D/2_Canon EOS 1200D.jpg'),
(203, 124, 'files/124Canon EOS 1200D/3_Canon EOS 1200D.jpg'),
(204, 125, 'files/125Mass Effect Andromeda/1_Mass Effect Andromeda.jpg'),
(205, 125, 'files/125Mass Effect Andromeda/2_Mass Effect Andromeda.jpg'),
(209, 127, 'files/127Diablo III/1_Diablo III.jpg'),
(210, 127, 'files/127Diablo III/2_Diablo III.jpg'),
(211, 127, 'files/127Diablo III/3_Diablo III.jpg'),
(212, 128, 'files/128Amica ZWM 668 IED/1_Amica ZWM 668 IED.jpg'),
(213, 128, 'files/128Amica ZWM 668 IED/2_Amica ZWM 668 IED.jpg'),
(214, 128, 'files/128Amica ZWM 668 IED/3_Amica ZWM 668 IED.jpg'),
(215, 128, 'files/128Amica ZWM 668 IED/4_Amica ZWM 668 IED.jpg'),
(216, 129, 'files/129Zelmer Jupiter/1_Zelmer Jupiter.jpg'),
(217, 129, 'files/129Zelmer Jupiter/2_Zelmer Jupiter.jpg'),
(218, 129, 'files/129Zelmer Jupiter/3_Zelmer Jupiter.jpg'),
(219, 129, 'files/129Zelmer Jupiter/4_Zelmer Jupiter.jpg'),
(220, 130, 'files/130Philips Azur Performer/1_Philips Azur Performer.jpg'),
(221, 130, 'files/130Philips Azur Performer/2_Philips Azur Performer.jpg'),
(222, 130, 'files/130Philips Azur Performer/3_Philips Azur Performer.jpg'),
(226, 132, 'files/132LG 49LH630V/1_LG 49LH630V.jpg'),
(227, 132, 'files/132LG 49LH630V/2_LG 49LH630V.jpg'),
(228, 132, 'files/132LG 49LH630V/3_LG 49LH630V.jpg'),
(229, 132, 'files/132LG 49LH630V/4_LG 49LH630V.jpg'),
(230, 133, 'files/133Apple Macbook Air 13/1_Apple Macbook Air 13.jpg'),
(231, 133, 'files/133Apple Macbook Air 13/2_Apple Macbook Air 13.jpg'),
(232, 133, 'files/133Apple Macbook Air 13/3_Apple Macbook Air 13.jpg'),
(233, 133, 'files/133Apple Macbook Air 13/4_Apple Macbook Air 13.jpg'),
(234, 134, 'files/134ASUS GL753VE 17,3/1_ASUS GL753VE 17,3.jpg'),
(235, 134, 'files/134ASUS GL753VE 17,3/2_ASUS GL753VE 17,3.jpg'),
(236, 134, 'files/134ASUS GL753VE 17,3/3_ASUS GL753VE 17,3.jpg'),
(237, 135, 'files/135Apple iPhone 7/1_Apple iPhone 7.jpg'),
(238, 135, 'files/135Apple iPhone 7/2_Apple iPhone 7.jpg'),
(239, 135, 'files/135Apple iPhone 7/3_Apple iPhone 7.jpg'),
(333, 115, 'files/115Amica FK3214DFXIo/1_Amica FK3214DFXI.jpg'),
(334, 115, 'files/115Amica FK3214DFXIo/2_Amica FK3214DFXI.jpg'),
(335, 115, 'files/115Amica FK3214DFXIo/3_Amica FK3214DFXI.jpg'),
(341, 131, 'files/131131Yamaha HTR-20671/1_Yamaha HTR-2067.jpg'),
(342, 131, 'files/131131Yamaha HTR-20671/2_Yamaha HTR-2067.jpg'),
(343, 131, 'files/131131Yamaha HTR-20671/3_Yamaha HTR-2067.jpg'),
(459, 135, 'files/135Apple iPhone 7 /4_Apple iPhone 7 .png'),
(467, 115, 'files/115Amica FK3214DFXIo/4_Amica FK3214DFXIo.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `password`, `address`) VALUES
(8, 'jacek', 'kulka', 'kulka@kulka.pl', 'jacek1', 'ruda, czarny'),
(9, 'slawek', 'jot', 'lawka@lawka.pl', 'slawek1', 'olkusz');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=468;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`);

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;