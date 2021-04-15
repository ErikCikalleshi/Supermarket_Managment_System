-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 15, 2021 alle 20:11
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

DELIMITER $$
--
-- Procedure
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_sales` (IN `menge` INT, `f_id` INT, `p_id` INT, `k_id` INT)  begin
    IF EXISTS(select * from PF where f_f_id = f_id and p_id = f_p_id and pf_menge >= menge) THEN
        insert into Verkauft(v_tag, v_menge, f_k_id, f_p_id, f_f_id) VALUES (now(), menge, k_id, p_id, f_id);
    ELSE
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'The Product doesn`t exist';
    end if;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_stock` (IN `menge` INT, `f_id` INT, `p_id` INT)  begin
    IF EXISTS(select * from PF where f_f_id = f_id and p_id = f_p_id) THEN
        update pf set pf_menge = pf_menge + menge where f_f_id = f_id and p_id = f_p_id;
    ELSE
        insert into PF(pf_menge, f_f_id, f_p_id) values (menge, f_id,p_id);
    end if;
end$$

DELIMITER ;

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
  `k_vorname` varchar(40) NOT NULL,
  `k_nachname` varchar(40) NOT NULL,
  `k_karteaddr` double NOT NULL,
  `k_email` varchar(40) NOT NULL,
  `k_phone` mediumtext NOT NULL,
  `k_adresse` varchar(40) NOT NULL,
  `k_plz` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `kunde`
--

INSERT INTO `kunde` (`k_id`, `k_vorname`, `k_nachname`, `k_karteaddr`, `k_email`, `k_phone`, `k_adresse`, `k_plz`) VALUES
(1, 'Gabriel', 'Cikalleshi', 4595891650210, 'gabri@outlook.it', '3271938863', 'Via Fienili 16', 39042);

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
(1, 3000, 'TestArbeiter', 'Test123', 'Via Fienili 16', 'IT1545453210153', '32423454364', 39042, 'test@outlook.it', 1),
(3, 2000, 'Max', 'Mustermann', 'Dantestraße 16', 'IT1545453210169', '398', 39042, 'max@gmail.com', 1);

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
(1, 360, 1, 1),
(16, 100, 1, 2),
(17, 20, 2, 2),
(19, 0, 1, 3);

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
(1, 'Nutella', 'Creme', 'Ferrero', 1.99, 'Schocko'),
(2, 'Almdudler', 'Getränk', 'Almdudler', 2.09, 'Getränk'),
(3, 'RedBull', 'Getränk', 'Wings', 1.25, 'Getränk');

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
(1, '2021-04-15 17:33:44', 25, 1, 1, 1),
(7, '2021-04-15 17:57:24', 20, 1, 3, 1),
(9, '2021-04-15 18:04:18', 5, 1, 3, 1);

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
  ADD UNIQUE KEY `m_iban` (`m_iban`),
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
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `kunde`
--
ALTER TABLE `kunde`
  MODIFY `k_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `mitarbeiter`
--
ALTER TABLE `mitarbeiter`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `pf`
--
ALTER TABLE `pf`
  MODIFY `pf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT per la tabella `produkt`
--
ALTER TABLE `produkt`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `verkauft`
--
ALTER TABLE `verkauft`
  MODIFY `v_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
