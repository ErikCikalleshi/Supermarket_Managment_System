-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 08, 2021 alle 08:47
-- Versione del server: 10.4.14-MariaDB
-- Versione PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `supermarket`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `filiale`
--

CREATE TABLE `filiale` (
  `f_id` int(11) NOT NULL,
  `f_ort` varchar(40) NOT NULL,
  `f_name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `filiale`
--

INSERT INTO `filiale` (`f_id`, `f_ort`, `f_name`) VALUES
(1, 'BX', 'Mpreis BX'),
(2, 'IBK', 'Mpreis IBK');

-- --------------------------------------------------------

--
-- Struttura della tabella `kunde`
--

CREATE TABLE `kunde` (
  `k_id` int(11) NOT NULL,
  `k_vorname` varchar(40) DEFAULT NULL,
  `k_nachname` varchar(40) DEFAULT NULL,
  `k_karteaddr` double DEFAULT NULL,
  `k_email` varchar(40) DEFAULT NULL,
  `k_phone` mediumtext DEFAULT NULL,
  `k_adresse` varchar(40) DEFAULT NULL,
  `k_plz` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `kunde`
--

INSERT INTO `kunde` (`k_id`, `k_vorname`, `k_nachname`, `k_karteaddr`, `k_email`, `k_phone`, `k_adresse`, `k_plz`) VALUES
(1, 'Erik', 'Cikalleshi', 2321616516, 'erik.ck@outlook.it', '215', 'Stadelgasse 17', 39042),
(12, 'Gabriel', 'Cikalleshi', 4595891650210, 'gabri@outlook.it', '3271938871', 'Via Fienili 16', 39042);

-- --------------------------------------------------------

--
-- Struttura della tabella `mitarbeiter`
--

CREATE TABLE `mitarbeiter` (
  `m_id` int(11) NOT NULL,
  `m_gehalt` double NOT NULL,
  `m_vorname` varchar(40) NOT NULL,
  `m_nachname` varchar(40) NOT NULL,
  `m_adresse` varchar(40) NOT NULL,
  `m_iban` varchar(40) NOT NULL,
  `m_phone` mediumtext NOT NULL,
  `m_plz` int(11) NOT NULL,
  `m_email` varchar(40) NOT NULL,
  `f_f_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `mitarbeiter`
--

INSERT INTO `mitarbeiter` (`m_id`, `m_gehalt`, `m_vorname`, `m_nachname`, `m_adresse`, `m_iban`, `m_phone`, `m_plz`, `m_email`, `f_f_id`) VALUES
(3, 2500, 'Max', 'Mustermann', 'Via Fienili 17', 'IT1545453210153', '3213245843', 39042, 'maxmustermann@gmail.com', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `pf`
--

CREATE TABLE `pf` (
  `pf_id` int(11) NOT NULL,
  `pf_menge` int(11) NOT NULL,
  `f_f_id` int(11) NOT NULL,
  `f_p_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `pf`
--

INSERT INTO `pf` (`pf_id`, `pf_menge`, `f_f_id`, `f_p_id`) VALUES
(1, 20, 1, 2),
(2, -69, 1, 1),
(5, 80, 2, 7),
(6, 12, 1, 4),
(7, 100, 1, 5),
(12, 100, 2, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `produkt`
--

CREATE TABLE `produkt` (
  `p_id` int(11) NOT NULL,
  `p_name` varchar(40) NOT NULL,
  `p_typ` varchar(40) NOT NULL,
  `p_marke` varchar(40) NOT NULL,
  `p_preis` double NOT NULL,
  `p_besch` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `produkt`
--

INSERT INTO `produkt` (`p_id`, `p_name`, `p_typ`, `p_marke`, `p_preis`, `p_besch`) VALUES
(1, 'Nutella', 'Creme', 'Ferrero', 1.99, 'Nussschocko'),
(2, 'Almdudler', 'Beverages', 'Almdudler', 2.09, 'Beverages'),
(4, 'Cola', 'Beverages', 'Cola', 0.99, 'Cola'),
(5, 'Barilla', 'Grains, Pasta & Sides', 'Pasta', 2.99, 'Pasta'),
(7, 'Bravo Orange', 'Beverages', 'Bravo', 1.49, 'Bravo');

-- --------------------------------------------------------

--
-- Struttura della tabella `verkauft`
--

CREATE TABLE `verkauft` (
  `v_id` int(11) NOT NULL,
  `v_tag` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `v_menge` int(11) NOT NULL,
  `f_k_id` int(11) NOT NULL,
  `f_p_id` int(11) NOT NULL,
  `f_f_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `verkauft`
--

INSERT INTO `verkauft` (`v_id`, `v_tag`, `v_menge`, `f_k_id`, `f_p_id`, `f_f_id`) VALUES
(10, '2021-04-05 19:29:23', 100, 1, 2, 1),
(11, '2021-04-06 15:02:28', 100, 1, 2, 2),
(14, '2021-04-06 15:02:50', 100, 1, 1, 2),
(17, '2021-04-06 15:20:03', 31, 1, 4, 2),
(18, '2021-04-06 18:34:55', 35, 1, 1, 1),
(19, '2021-04-06 18:38:31', 35, 12, 1, 1);

--
-- Trigger `verkauft`
--
DELIMITER $$
CREATE TRIGGER `update_menge_pf` AFTER INSERT ON `verkauft` FOR EACH ROW begin
    SET @menge = New.v_menge;
    SET @id = NEW.f_p_id;
    update pf set pf_menge = pf_menge - @menge where f_p_id = @id;
end
$$
DELIMITER ;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `filiale`
--
ALTER TABLE `filiale`
  ADD PRIMARY KEY (`f_id`);

--
-- Indici per le tabelle `kunde`
--
ALTER TABLE `kunde`
  ADD PRIMARY KEY (`k_id`),
  ADD UNIQUE KEY `k_karteaddr` (`k_karteaddr`),
  ADD UNIQUE KEY `k_email` (`k_email`),
  ADD UNIQUE KEY `k_phone` (`k_phone`) USING HASH;

--
-- Indici per le tabelle `mitarbeiter`
--
ALTER TABLE `mitarbeiter`
  ADD PRIMARY KEY (`m_id`),
  ADD UNIQUE KEY `m_email` (`m_email`),
  ADD UNIQUE KEY `m_phone` (`m_phone`) USING HASH,
  ADD KEY `f_f_id` (`f_f_id`);

--
-- Indici per le tabelle `pf`
--
ALTER TABLE `pf`
  ADD PRIMARY KEY (`pf_id`),
  ADD KEY `f_f_id` (`f_f_id`),
  ADD KEY `f_p_id` (`f_p_id`);

--
-- Indici per le tabelle `produkt`
--
ALTER TABLE `produkt`
  ADD PRIMARY KEY (`p_id`),
  ADD UNIQUE KEY `p_name` (`p_name`);

--
-- Indici per le tabelle `verkauft`
--
ALTER TABLE `verkauft`
  ADD PRIMARY KEY (`v_id`),
  ADD KEY `f_k_id` (`f_k_id`),
  ADD KEY `f_p_id` (`f_p_id`),
  ADD KEY `f_f_id` (`f_f_id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `filiale`
--
ALTER TABLE `filiale`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `kunde`
--
ALTER TABLE `kunde`
  MODIFY `k_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT per la tabella `mitarbeiter`
--
ALTER TABLE `mitarbeiter`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `pf`
--
ALTER TABLE `pf`
  MODIFY `pf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT per la tabella `produkt`
--
ALTER TABLE `produkt`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `verkauft`
--
ALTER TABLE `verkauft`
  MODIFY `v_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `mitarbeiter`
--
ALTER TABLE `mitarbeiter`
  ADD CONSTRAINT `mitarbeiter_ibfk_1` FOREIGN KEY (`f_f_id`) REFERENCES `filiale` (`f_id`);

--
-- Limiti per la tabella `pf`
--
ALTER TABLE `pf`
  ADD CONSTRAINT `pf_ibfk_1` FOREIGN KEY (`f_f_id`) REFERENCES `filiale` (`f_id`),
  ADD CONSTRAINT `pf_ibfk_2` FOREIGN KEY (`f_p_id`) REFERENCES `produkt` (`p_id`);

--
-- Limiti per la tabella `verkauft`
--
ALTER TABLE `verkauft`
  ADD CONSTRAINT `verkauft_ibfk_1` FOREIGN KEY (`f_k_id`) REFERENCES `kunde` (`k_id`),
  ADD CONSTRAINT `verkauft_ibfk_2` FOREIGN KEY (`f_p_id`) REFERENCES `produkt` (`p_id`),
  ADD CONSTRAINT `verkauft_ibfk_3` FOREIGN KEY (`f_f_id`) REFERENCES `filiale` (`f_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
