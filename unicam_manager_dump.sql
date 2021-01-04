-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 03, 2021 alle 18:17
-- Versione del server: 10.4.14-MariaDB
-- Versione PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `unicam_manager`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `areas`
--

CREATE TABLE `areas` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `idResponsabile` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `areas`
--

INSERT INTO `areas` (`id`, `name`, `idResponsabile`) VALUES
(5, 'Area Avvocatura di Ateneo', 42),
(6, 'Area Edilizia', 43),
(8, 'pinco pallino', 24);

-- --------------------------------------------------------

--
-- Struttura della tabella `indicators`
--

CREATE TABLE `indicators` (
  `id` int(11) NOT NULL,
  `idTarget` int(11) NOT NULL DEFAULT -1,
  `name` text NOT NULL,
  `weight` int(11) NOT NULL DEFAULT 0,
  `completion` int(11) NOT NULL DEFAULT 0,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `indicators`
--

INSERT INTO `indicators` (`id`, `idTarget`, `name`, `weight`, `completion`, `description`) VALUES
(2, 4, 'Analisi del caso e valutazione', 100, 100, 'Analisi del caso concreto e valutazione in merito alla recuperabilita'),
(4, 6, 'Analisi Normativa', 100, 100, 'Analisi della Normativa Vigente e delle modifiche della compagine sociale delle societa coinvolte'),
(5, 7, 'Attuazione Piano', 100, 100, 'Attuazione Piano in relazione ai fondi'),
(6, 8, 'Attuazione', 100, 100, 'Attuazione interventi'),
(7, 9, 'Attuazione', 100, 100, 'Attuazione nei termini programmati'),
(8, 10, 'Attuazione', 80, 100, 'Attuazione in relazione alle richieste pervenute'),
(9, 10, 'Piccola manutenzione', 10, 100, 'Piccola manutenzione'),
(10, 10, 'Supervisione manutenzione', 10, 100, 'Supervisionare gli interventi di piccola manutenzione');

-- --------------------------------------------------------

--
-- Struttura della tabella `indicatorsuniversita`
--

CREATE TABLE `indicatorsuniversita` (
  `id` int(11) NOT NULL,
  `idTarget` int(11) NOT NULL,
  `name` text NOT NULL,
  `weight` int(11) NOT NULL,
  `completion` int(11) NOT NULL DEFAULT 0,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `indicatorsuniversita`
--

INSERT INTO `indicatorsuniversita` (`id`, `idTarget`, `name`, `weight`, `completion`, `description`) VALUES
(13, 12, 'Attuazione ', 100, 50, 'Attuazione nei termini programmati'),
(14, 13, 'Attuazione ', 100, 100, 'Attuazione in relazione alle richieste pervenute'),
(15, 14, 'Analisi del Caso', 100, 100, 'Analisi caso concreto e valutazione in merito alla recuperabilita o meno del creditosi della Normativa Vigente e delle modifiche della compagine sociale delle societa coinvolte'),
(16, 15, 'Analisi della Normativa ', 100, 100, 'Analisi normativa vigente e delle modifiche e della compagine sociale'),
(21, 18, 'Piccola manutenzione', 50, 100, 'Verificare i risultati delle piccole manutenzioni'),
(22, 18, 'Completato Si No', 50, 100, 'Completato Si No');

-- --------------------------------------------------------

--
-- Struttura della tabella `objectives`
--

CREATE TABLE `objectives` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `weight` int(11) NOT NULL,
  `idArea` int(11) NOT NULL,
  `idPlan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `objectives`
--

INSERT INTO `objectives` (`id`, `title`, `description`, `weight`, `idArea`, `idPlan`) VALUES
(7, 'Recupero Crediti e Ricognizione di terze parti', 'Redazione di diffide ingiunzioni di pagamento crediti dalla diffida di pagamento e ricognizione di terze parti ', 70, 5, 5),
(8, 'Manutenzione Edifici ', 'Manutenzione e realizzazione di interventi per la sicurezza dell\'Ateneo', 80, 6, 6);

-- --------------------------------------------------------

--
-- Struttura della tabella `objectivesuniversita`
--

CREATE TABLE `objectivesuniversita` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `weight` int(11) NOT NULL,
  `idPlan` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `objectivesuniversita`
--

INSERT INTO `objectivesuniversita` (`id`, `title`, `weight`, `idPlan`, `description`) VALUES
(11, 'Recupero Crediti', 60, 5, 'Redazione di diffide ingiunzioni di pagamento crediti dalla diffida di pagamento '),
(12, 'Ricognizione di terze parti', 40, 5, 'Ricognizione di terze parti.'),
(15, 'Realizzazione Interventi', 50, 6, 'Realizzazione Interventi finalizzati alla messa a norma ai fini della prevenzione incendi e sicurezza'),
(16, 'Esecuzione Interventi Piccola Manutenzione', 50, 6, 'Esecuzione Piccola Manutenzione supporto logistico spostamenti manifestazione ed eventi di vario genere');

-- --------------------------------------------------------

--
-- Struttura della tabella `participation`
--

CREATE TABLE `participation` (
  `id` int(11) NOT NULL,
  `idDipendente` int(11) NOT NULL,
  `idTarget` int(11) NOT NULL,
  `contributo` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `participation`
--

INSERT INTO `participation` (`id`, `idDipendente`, `idTarget`, `contributo`) VALUES
(4, 41, 4, 50),
(6, 42, 6, 100),
(7, 44, 7, 50),
(8, 45, 7, 0),
(9, 46, 7, 0),
(10, 44, 8, 0),
(11, 45, 8, 30),
(12, 46, 8, 0),
(13, 44, 9, 0),
(14, 45, 9, 60),
(15, 46, 9, 0),
(16, 44, 10, 0),
(17, 45, 10, 0),
(18, 46, 10, 0),
(19, 42, 4, 50);

-- --------------------------------------------------------

--
-- Struttura della tabella `participationareas`
--

CREATE TABLE `participationareas` (
  `id` int(11) NOT NULL,
  `idPlan` int(11) NOT NULL,
  `idArea` int(11) NOT NULL,
  `budget` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `participationareas`
--

INSERT INTO `participationareas` (`id`, `idPlan`, `idArea`, `budget`) VALUES
(5, 5, 5, 10000),
(6, 6, 6, 47000);

-- --------------------------------------------------------

--
-- Struttura della tabella `participationobjectives`
--

CREATE TABLE `participationobjectives` (
  `id` int(11) NOT NULL,
  `idObjectiveUniversita` int(11) NOT NULL,
  `idObjective` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `participationobjectives`
--

INSERT INTO `participationobjectives` (`id`, `idObjectiveUniversita`, `idObjective`) VALUES
(10, 11, 7),
(11, 12, 7),
(14, 15, 8),
(15, 16, 8);

-- --------------------------------------------------------

--
-- Struttura della tabella `plans`
--

CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `budget` int(11) NOT NULL,
  `date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `plans`
--

INSERT INTO `plans` (`id`, `title`, `description`, `budget`, `date`) VALUES
(5, 'Piano Annuale per Avvocatura di Ateneo', 'Recupero crediti di Diffida e Ricognizione di societa partecipate spin off start up', 12000, '2020'),
(6, 'Piano Annuale Manutenzione', 'Manutenzione e Sicurezza di tutte le strutture edilizie di Unicam', 47000, '2020');

-- --------------------------------------------------------

--
-- Struttura della tabella `targets`
--

CREATE TABLE `targets` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `name` text NOT NULL,
  `weight` int(11) NOT NULL,
  `idObjective` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `targets`
--

INSERT INTO `targets` (`id`, `description`, `name`, `weight`, `idObjective`) VALUES
(4, 'Recupero crediti di diffide e ingiunzioni di pagamento', 'Recupero Crediti', 80, 7),
(6, 'Collaborazione con area di ricerca nella definizione del regolamento da sottoporre all approvazione del cda', 'Collaborazione Area Ricerca', 20, 7),
(7, 'Manutenzione Ordinaria Edifici ', 'Manutenzione Ordinaria Edifici', 60, 8),
(8, 'Attuazione degli Interventi ', 'Attuazione degli Interventi', 20, 8),
(9, 'Realizzazione interventi piccola manutenzione', 'Realizzazione Interventi ', 5, 8),
(10, 'Interventi Piccola Manutenzione da portare a termine', 'Esecuzione Interventi Piccola Manutenzione', 15, 8);

-- --------------------------------------------------------

--
-- Struttura della tabella `targetsuniversita`
--

CREATE TABLE `targetsuniversita` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `name` text NOT NULL,
  `weight` int(11) NOT NULL,
  `idObjectiveUniversita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `targetsuniversita`
--

INSERT INTO `targetsuniversita` (`id`, `description`, `name`, `weight`, `idObjectiveUniversita`) VALUES
(12, 'progettare ed eseguire interventi secondo un programma da attuare e studiare', 'Progettazione ed esecuzioni interventi', 100, 15),
(13, 'provvedere quanto di competenza dell\'area', 'Provvedere l\'Area', 50, 16),
(14, 'Completamento della procedura di recupero crediti in merito alla ricuperabilità', 'Procedura recupero crediti', 100, 11),
(15, 'Analisi della Normativa Vigente e delle modifiche della compagine sociale delle societa coinvolte', 'Analisi della Normativa ', 100, 12),
(18, 'Supervisionare interventi di piccola manutenzione relativi all area amministrativa di competenza', 'Supervisionare interventi di piccola manutenzione', 50, 16);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user` text NOT NULL,
  `password` text NOT NULL,
  `profile` text DEFAULT NULL,
  `name` text NOT NULL,
  `lastLogin` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `photo` text NOT NULL,
  `status` int(11) DEFAULT 0,
  `idArea` int(11) DEFAULT NULL,
  `responsabile` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `user`, `password`, `profile`, `name`, `lastLogin`, `photo`, `status`, `idArea`, `responsabile`) VALUES
(1, 'admin', '$2a$07$asxx54ahjppf45sd87a5auXBm1Vr2M1NV5t/zNQtGHGpS5fFirrbG', 'Admin', 'Admin', '2021-01-02 17:01:38', 'views/img/users/admin/529.png', 1, NULL, 1),
(19, 'giovanni', '$2a$07$asxx54ahjppf45sd87a5au8uJqn2VoaOMw86zRUoDH6inuYomGLDq', 'Responsabile Area', 'Giovanni Michetti', '2020-12-19 17:03:05', 'views/img/users/giovanni/328.png', 1, 5, 1),
(24, 'roberto', '$2a$07$asxx54ahjppf45sd87a5au8uJqn2VoaOMw86zRUoDH6inuYomGLDq', 'Amministratore', 'Roberto Gagliardi', '2020-12-27 16:07:39', 'views/img/users/roberto/754.png', 1, 5, 1),
(41, 'alessandraciccarelli', '$2a$07$asxx54ahjppf45sd87a5au8uJqn2VoaOMw86zRUoDH6inuYomGLDq', 'Dipendente', 'Alessandra Ciccarelli', '2021-01-02 17:22:28', 'views/img/users/alessandraciccarelli/517.png', 1, 5, 0),
(42, 'giuliagiontella', '$2a$07$asxx54ahjppf45sd87a5au8uJqn2VoaOMw86zRUoDH6inuYomGLDq', 'Responsabile Area', 'Giulia Giontella', '2020-12-27 16:07:59', '', 1, 5, 1),
(43, 'francescotomassetti', '$2a$07$asxx54ahjppf45sd87a5au8uJqn2VoaOMw86zRUoDH6inuYomGLDq', 'Dipendente', 'Francesco Tomassetti', '2020-12-07 21:27:57', '', 1, 6, 1),
(44, 'vannaceresani', '$2a$07$asxx54ahjppf45sd87a5au8uJqn2VoaOMw86zRUoDH6inuYomGLDq', 'Dipendente', 'Vanna Ceresani', '2020-12-07 21:28:06', '', 1, 6, 0),
(45, 'sandrobarboni', '$2a$07$asxx54ahjppf45sd87a5au8uJqn2VoaOMw86zRUoDH6inuYomGLDq', 'Dipendente', 'Sandro Barboni', '2021-01-02 17:33:04', '', 1, 6, 0),
(46, 'fabiocaroni', '$2a$07$asxx54ahjppf45sd87a5au8uJqn2VoaOMw86zRUoDH6inuYomGLDq', 'Dipendente', 'Fabio Caroni', '2020-12-14 09:26:20', '', 1, 6, 0),
(47, 'brunomogliani', '$2a$07$asxx54ahjppf45sd87a5au8uJqn2VoaOMw86zRUoDH6inuYomGLDq', 'Dipendente', 'Bruno Mogliani', '2020-12-07 21:28:23', '', 1, 6, 0);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idResponsabile` (`idResponsabile`);

--
-- Indici per le tabelle `indicators`
--
ALTER TABLE `indicators`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idTarget` (`idTarget`);

--
-- Indici per le tabelle `indicatorsuniversita`
--
ALTER TABLE `indicatorsuniversita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idTarget` (`idTarget`);

--
-- Indici per le tabelle `objectives`
--
ALTER TABLE `objectives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idArea` (`idArea`),
  ADD KEY `idPlan` (`idPlan`);

--
-- Indici per le tabelle `objectivesuniversita`
--
ALTER TABLE `objectivesuniversita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idPlan` (`idPlan`);

--
-- Indici per le tabelle `participation`
--
ALTER TABLE `participation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idDipendente` (`idDipendente`),
  ADD KEY `idTarget` (`idTarget`);

--
-- Indici per le tabelle `participationareas`
--
ALTER TABLE `participationareas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idArea` (`idArea`),
  ADD KEY `idPlan` (`idPlan`);

--
-- Indici per le tabelle `participationobjectives`
--
ALTER TABLE `participationobjectives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idObjective` (`idObjective`),
  ADD KEY `idObjectiveUniversita` (`idObjectiveUniversita`);

--
-- Indici per le tabelle `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `targets`
--
ALTER TABLE `targets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idObjective` (`idObjective`);

--
-- Indici per le tabelle `targetsuniversita`
--
ALTER TABLE `targetsuniversita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idObjectiveUniversita` (`idObjectiveUniversita`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idArea` (`idArea`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `indicators`
--
ALTER TABLE `indicators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `indicatorsuniversita`
--
ALTER TABLE `indicatorsuniversita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT per la tabella `objectives`
--
ALTER TABLE `objectives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `objectivesuniversita`
--
ALTER TABLE `objectivesuniversita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT per la tabella `participation`
--
ALTER TABLE `participation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT per la tabella `participationareas`
--
ALTER TABLE `participationareas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `participationobjectives`
--
ALTER TABLE `participationobjectives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT per la tabella `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `targets`
--
ALTER TABLE `targets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT per la tabella `targetsuniversita`
--
ALTER TABLE `targetsuniversita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `areas`
--
ALTER TABLE `areas`
  ADD CONSTRAINT `areas_ibfk_1` FOREIGN KEY (`idResponsabile`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Limiti per la tabella `indicators`
--
ALTER TABLE `indicators`
  ADD CONSTRAINT `indicators_ibfk_1` FOREIGN KEY (`idTarget`) REFERENCES `targets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `indicatorsuniversita`
--
ALTER TABLE `indicatorsuniversita`
  ADD CONSTRAINT `indicatorsuniversita_ibfk_1` FOREIGN KEY (`idTarget`) REFERENCES `targetsuniversita` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `objectives`
--
ALTER TABLE `objectives`
  ADD CONSTRAINT `objectives_ibfk_1` FOREIGN KEY (`idArea`) REFERENCES `areas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `objectives_ibfk_2` FOREIGN KEY (`idPlan`) REFERENCES `plans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `objectivesuniversita`
--
ALTER TABLE `objectivesuniversita`
  ADD CONSTRAINT `objectivesuniversita_ibfk_1` FOREIGN KEY (`idPlan`) REFERENCES `plans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `participation`
--
ALTER TABLE `participation`
  ADD CONSTRAINT `participation_ibfk_1` FOREIGN KEY (`idDipendente`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participation_ibfk_2` FOREIGN KEY (`idTarget`) REFERENCES `targets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `participationareas`
--
ALTER TABLE `participationareas`
  ADD CONSTRAINT `participationareas_ibfk_1` FOREIGN KEY (`idArea`) REFERENCES `areas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participationareas_ibfk_2` FOREIGN KEY (`idPlan`) REFERENCES `plans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `participationobjectives`
--
ALTER TABLE `participationobjectives`
  ADD CONSTRAINT `participationobjectives_ibfk_1` FOREIGN KEY (`idObjective`) REFERENCES `objectives` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participationobjectives_ibfk_2` FOREIGN KEY (`idObjectiveUniversita`) REFERENCES `objectivesuniversita` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `targets`
--
ALTER TABLE `targets`
  ADD CONSTRAINT `targets_ibfk_1` FOREIGN KEY (`idObjective`) REFERENCES `objectives` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `targetsuniversita`
--
ALTER TABLE `targetsuniversita`
  ADD CONSTRAINT `targetsuniversita_ibfk_1` FOREIGN KEY (`idObjectiveUniversita`) REFERENCES `objectivesuniversita` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`idArea`) REFERENCES `areas` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
