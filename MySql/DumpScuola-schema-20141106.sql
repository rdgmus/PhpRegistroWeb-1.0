-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 06, 2014 alle 10:31
-- Versione del server: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `scuola`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `allievi_risultati_periodo`
--

CREATE TABLE IF NOT EXISTS `allievi_risultati_periodo` (
  `id_periodo` bigint(20) NOT NULL,
  `id_materia` bigint(20) NOT NULL,
  `id_studente` bigint(20) NOT NULL,
  `num_assenze` int(11) DEFAULT NULL,
  `totale_ore_periodo` int(11) DEFAULT NULL,
  `percentuale_assenze_periodo` double DEFAULT NULL,
  `giudizio` char(15) DEFAULT NULL,
  `scritto` char(10) DEFAULT NULL,
  `orale` char(10) DEFAULT NULL,
  `pratico` char(10) DEFAULT NULL,
  `condotta` char(10) DEFAULT NULL,
`id_risultato` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=446 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `anagrafe_insegnanti`
--

CREATE TABLE IF NOT EXISTS `anagrafe_insegnanti` (
`idanagrafe_insegnanti` int(11) NOT NULL,
  `id_insegnante` bigint(20) NOT NULL,
  `codice_fiscale` varchar(45) DEFAULT NULL,
  `data_nascita` datetime DEFAULT NULL,
  `sesso` varchar(1) DEFAULT NULL,
  `nazione_nascita` varchar(45) DEFAULT NULL,
  `indirizzo_residenza` varchar(45) DEFAULT NULL,
  `numero_civico` varchar(10) DEFAULT NULL,
  `cap` varchar(10) DEFAULT NULL,
  `comune_residenza` varchar(45) DEFAULT NULL,
  `provincia_residenza` varchar(45) DEFAULT NULL,
  `nazione_residenza` varchar(45) DEFAULT NULL,
  `foto` longblob,
  `data_foto` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `anagrafe_studenti`
--

CREATE TABLE IF NOT EXISTS `anagrafe_studenti` (
`idanagrafe_studenti` int(11) NOT NULL,
  `id_studente` bigint(20) NOT NULL,
  `codice_fiscale` varchar(45) DEFAULT NULL,
  `data_nascita` datetime DEFAULT NULL,
  `sesso` varchar(1) DEFAULT NULL,
  `nazione_nascita` varchar(45) DEFAULT NULL,
  `indirizzo_residenza` varchar(45) DEFAULT NULL,
  `numero_civico` varchar(10) DEFAULT NULL,
  `cap` varchar(10) DEFAULT NULL,
  `comune_residenza` varchar(45) DEFAULT NULL,
  `provincia_residenza` varchar(45) DEFAULT NULL,
  `nazione_residenza` varchar(45) DEFAULT NULL,
  `handicap_certificato` tinyint(4) DEFAULT NULL,
  `tipologia_handicap` varchar(45) DEFAULT NULL,
  `foto` longblob,
  `data_foto` datetime DEFAULT NULL COMMENT 'Data di inserimento della foto'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `anni_scolastici`
--

CREATE TABLE IF NOT EXISTS `anni_scolastici` (
`id_anno_scolastico` bigint(20) NOT NULL,
  `id_scuola` bigint(20) NOT NULL,
  `anno_scolastico` char(10) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `assenze_studenti`
--
CREATE TABLE IF NOT EXISTS `assenze_studenti` (
`id_studente` bigint(20)
,`cognome` varchar(50)
,`nome` varchar(50)
,`id_classe` bigint(20)
,`anno_scolastico` char(10)
,`nome_classe` varchar(10)
,`id_materia` bigint(20)
,`materia` varchar(50)
,`id_lezione` bigint(20)
,`data_lezione` date
,`ore_lezione` int(11)
,`argomento` varchar(100)
,`num_ora` int(11)
,`assenza` tinyint(4)
,`giustifica_assenza` tinyint(4)
,`ritardo` tinyint(4)
,`giustifica_ritardo` tinyint(4)
,`motivo_giustifica` longtext
);
-- --------------------------------------------------------

--
-- Struttura della tabella `aule`
--

CREATE TABLE IF NOT EXISTS `aule` (
`id_aula` bigint(20) NOT NULL,
  `id_scuola` bigint(20) NOT NULL,
  `nome_aula` varchar(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `change_password_request`
--

CREATE TABLE IF NOT EXISTS `change_password_request` (
`id_request` bigint(20) NOT NULL,
  `from_user` bigint(20) NOT NULL COMMENT 'utente che ha inoltrato la richiesta',
  `user_email` longtext COLLATE utf8_bin,
  `request_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pending` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'richiesta in attesa di essere servita',
  `hash` longtext COLLATE utf8_bin COMMENT 'hash per il link conferma',
  `confirmed` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'l''utente ha confermato la richiesta',
  `request_done_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `request_done` tinyint(4) DEFAULT '0',
  `email_sent` tinyint(4) NOT NULL DEFAULT '0',
  `id_admin` bigint(20) DEFAULT NULL COMMENT 'amministratore che ha servito la richiesta',
  `elapsed_days` int(11) DEFAULT '0' COMMENT 'Calcolo giorni da trigger'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=37 ;

--
-- Trigger `change_password_request`
--
DELIMITER //
CREATE TRIGGER `elapsed_day_calc` BEFORE UPDATE ON `change_password_request`
 FOR EACH ROW SET NEW.elapsed_days = DATEDIFF(NEW.request_done_date, NEW.request_date)
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `store_user_email` BEFORE INSERT ON `change_password_request`
 FOR EACH ROW SET NEW.user_email = (
    SELECT email FROM utenti_scuola 
    WHERE id_utente = NEW.from_user)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `classi`
--

CREATE TABLE IF NOT EXISTS `classi` (
  `nome_classe` varchar(10) NOT NULL,
`id_classe` bigint(20) NOT NULL,
  `anno_scolastico` char(10) NOT NULL,
  `id_scuola` bigint(20) NOT NULL,
  `id_anno_scolastico` bigint(20) NOT NULL,
  `specializzazione` char(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `email_attachments`
--

CREATE TABLE IF NOT EXISTS `email_attachments` (
`id_attachment` bigint(20) NOT NULL,
  `id_email` bigint(20) NOT NULL,
  `attachment_name` longtext COLLATE utf8_bin,
  `attachment_bin` longblob
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `email_recipients`
--

CREATE TABLE IF NOT EXISTS `email_recipients` (
`id_recipient` bigint(20) NOT NULL COMMENT 'chiave primaria',
  `id_email` bigint(20) NOT NULL COMMENT 'email di cui è stato destinatario',
  `email` varchar(256) COLLATE utf8_bin DEFAULT NULL COMMENT 'email del recipient',
  `name` varchar(256) COLLATE utf8_bin DEFAULT NULL COMMENT 'nome del recipient',
  `to_recipient` tinyint(4) DEFAULT NULL,
  `cc_recipient` tinyint(4) DEFAULT NULL,
  `bcc_recipient` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `email_server_params`
--

CREATE TABLE IF NOT EXISTS `email_server_params` (
`id_email_server` bigint(20) NOT NULL,
  `use_smtp` tinyint(4) DEFAULT NULL COMMENT 'Set mailer to use SMTP',
  `host_main_server` text COLLATE utf8_bin COMMENT 'Specify main and backup SMTP servers',
  `host_backup_server` text COLLATE utf8_bin,
  `smtp_auth` tinyint(4) DEFAULT NULL,
  `username` text COLLATE utf8_bin COMMENT 'SMTP username',
  `password` text COLLATE utf8_bin COMMENT 'SMTP password',
  `smtp_secure` varchar(32) COLLATE utf8_bin DEFAULT NULL COMMENT 'Enable TLS encryption, `ssl` also accepted',
  `port` int(11) DEFAULT NULL COMMENT 'server port',
  `email_server_tagname` text COLLATE utf8_bin
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `email_store`
--

CREATE TABLE IF NOT EXISTS `email_store` (
`id_email` bigint(20) NOT NULL,
  `subject` longtext COLLATE utf8_bin,
  `body` longtext COLLATE utf8_bin,
  `data_email` datetime DEFAULT NULL,
  `from_email` text COLLATE utf8_bin NOT NULL COMMENT 'Email dell''utente che invia',
  `from_name` text COLLATE utf8_bin NOT NULL COMMENT 'Nome dell''utente che invia',
  `email_inviata` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Se = 0 la email è una bozza ancora da inviare',
  `id_user` bigint(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=84 ;

--
-- Trigger `email_store`
--
DELIMITER //
CREATE TRIGGER `email_inviata_data` BEFORE UPDATE ON `email_store`
 FOR EACH ROW IF NEW.email_inviata = 1 THEN SET NEW.data_email = NOW();
END IF
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `insegnanti`
--

CREATE TABLE IF NOT EXISTS `insegnanti` (
`id_insegnante` bigint(20) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `id_classe` bigint(20) NOT NULL,
  `anno_scolastico` char(10) NOT NULL,
  `id_anno_scolastico` bigint(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `lezioni`
--

CREATE TABLE IF NOT EXISTS `lezioni` (
`id_lezione` bigint(20) NOT NULL,
  `id_materia` bigint(20) NOT NULL,
  `data_lezione` date DEFAULT NULL,
  `ore_lezione` int(11) DEFAULT NULL,
  `argomento` varchar(100) DEFAULT NULL,
  `freeze_lezione` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=806 ;

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `lezioni_materia`
--
CREATE TABLE IF NOT EXISTS `lezioni_materia` (
`data_lezione` date
,`ore_lezione` int(11)
,`argomento` varchar(100)
,`freeze_lezione` tinyint(4)
,`id_materia` bigint(20)
,`id_lezione` bigint(20)
,`id_anno_scolastico` bigint(20)
,`materia` varchar(50)
,`anno_scolastico` char(10)
,`start_date` date
,`end_date` date
,`id_insegnante` bigint(20)
,`giudizio` tinyint(4)
,`scritto` tinyint(4)
,`orale` tinyint(4)
,`pratico` tinyint(4)
,`nome_classe` varchar(10)
,`id_classe` bigint(20)
,`id_scuola` bigint(20)
,`nome_scuola` varchar(50)
,`tipo_scuola_acronimo` varchar(10)
);
-- --------------------------------------------------------

--
-- Struttura della tabella `log_msg_body`
--

CREATE TABLE IF NOT EXISTS `log_msg_body` (
`id_msg_body` bigint(20) NOT NULL,
  `msg_body` longtext COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `log_msg_types`
--

CREATE TABLE IF NOT EXISTS `log_msg_types` (
`id_msg_type` bigint(20) NOT NULL,
  `msg_type` longtext NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Trigger `log_msg_types`
--
DELIMITER //
CREATE TRIGGER `upper_msg_type` BEFORE INSERT ON `log_msg_types`
 FOR EACH ROW SET NEW.msg_type = upper(NEW.msg_type)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `materie`
--

CREATE TABLE IF NOT EXISTS `materie` (
`id_materia` bigint(20) NOT NULL,
  `materia` varchar(50) NOT NULL,
  `id_classe` bigint(20) NOT NULL,
  `anno_scolastico` char(10) NOT NULL,
  `id_insegnante` bigint(20) NOT NULL,
  `giudizio` tinyint(4) NOT NULL DEFAULT '0',
  `scritto` tinyint(4) NOT NULL DEFAULT '0',
  `orale` tinyint(4) NOT NULL DEFAULT '0',
  `pratico` tinyint(4) NOT NULL DEFAULT '0',
  `id_anno_scolastico` bigint(20) NOT NULL,
  `giudizioBool` tinyint(1) NOT NULL,
  `oraleBool` tinyint(1) NOT NULL,
  `praticoBool` tinyint(1) NOT NULL,
  `scrittoBool` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `mysql_servers_groups`
--

CREATE TABLE IF NOT EXISTS `mysql_servers_groups` (
`id_server_group` bigint(20) NOT NULL,
  `server_group` longtext COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `mysql_server_params`
--

CREATE TABLE IF NOT EXISTS `mysql_server_params` (
`id_server` bigint(20) NOT NULL,
  `id_server_group` bigint(20) NOT NULL,
  `server_name` text COLLATE utf8_bin,
  `username` text COLLATE utf8_bin,
  `password` text COLLATE utf8_bin,
  `server` text COLLATE utf8_bin,
  `socket` text COLLATE utf8_bin,
  `note` longtext COLLATE utf8_bin
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `orario_insegnante`
--

CREATE TABLE IF NOT EXISTS `orario_insegnante` (
`id_orario` bigint(20) NOT NULL,
  `id_insegnante` bigint(20) NOT NULL,
  `id_anno_scolastico` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `orario_lezioni_as`
--

CREATE TABLE IF NOT EXISTS `orario_lezioni_as` (
`id_orario_lezioni` bigint(20) NOT NULL,
  `id_materia` bigint(20) NOT NULL,
  `id_scansione` bigint(20) NOT NULL,
  `id_aula` bigint(20) NOT NULL,
  `materia` longtext NOT NULL,
  `giorno` longtext NOT NULL,
  `ora_inizio` time NOT NULL,
  `ora_fine` time NOT NULL,
  `nome_aula` longtext NOT NULL,
  `id_anno_scolastico` bigint(20) NOT NULL,
  `id_classe` bigint(20) NOT NULL,
  `nome_classe` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `ore_assenze`
--

CREATE TABLE IF NOT EXISTS `ore_assenze` (
  `id_lezione` bigint(20) NOT NULL,
  `num_ora` int(11) NOT NULL,
  `id_studente` bigint(20) NOT NULL,
  `assenza` tinyint(4) NOT NULL DEFAULT '1',
  `giustifica_assenza` tinyint(4) NOT NULL DEFAULT '0',
  `ritardo` tinyint(4) NOT NULL DEFAULT '0',
  `giustifica_ritardo` tinyint(4) NOT NULL DEFAULT '0',
  `motivo_giustifica` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `parametri_orario_as`
--

CREATE TABLE IF NOT EXISTS `parametri_orario_as` (
`id_param_orario` bigint(20) NOT NULL,
  `inizio_lezioni` time NOT NULL,
  `id_anno_scolastico` bigint(20) NOT NULL,
  `durata_ora_minuti` int(11) NOT NULL DEFAULT '60',
  `durata_intervallo_minuti` int(11) NOT NULL DEFAULT '15'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `periodi_anno_scolastico`
--

CREATE TABLE IF NOT EXISTS `periodi_anno_scolastico` (
`id_periodo` bigint(20) NOT NULL,
  `id_scuola` bigint(20) NOT NULL,
  `id_anno_scolastico` bigint(20) NOT NULL,
  `periodo` varchar(20) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `registri_granted`
--

CREATE TABLE IF NOT EXISTS `registri_granted` (
  `id_utente` bigint(20) NOT NULL,
  `id_ruolo` bigint(20) NOT NULL,
  `ruolo` longtext,
  `id_materia` bigint(20) NOT NULL,
`id_grant` bigint(20) NOT NULL,
  `read_granted` tinyint(4) NOT NULL DEFAULT '0',
  `write_granted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Trigger `registri_granted`
--
DELIMITER //
CREATE TRIGGER `ins_ruolo_registri_granted` BEFORE INSERT ON `registri_granted`
 FOR EACH ROW set NEW.ruolo = (SELECT `ruolo` FROM `ruoli_utenti` WHERE `id_ruolo` = NEW.id_ruolo)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `registri_insegnanti`
--
CREATE TABLE IF NOT EXISTS `registri_insegnanti` (
`id_materia` bigint(20)
,`tipo_scuola_acronimo` varchar(10)
,`nome_scuola` varchar(50)
,`anno_scolastico` char(10)
,`nome_classe` varchar(10)
,`cognome` varchar(50)
,`nome` varchar(50)
,`materia` varchar(50)
,`id_insegnante` bigint(20)
,`id_anno_scolastico` bigint(20)
,`id_scuola` bigint(20)
,`id_classe` bigint(20)
);
-- --------------------------------------------------------

--
-- Struttura della tabella `ruoli_granted_to_utenti`
--

CREATE TABLE IF NOT EXISTS `ruoli_granted_to_utenti` (
`id_ruoli_granted` bigint(20) NOT NULL,
  `id_utente` bigint(20) NOT NULL,
  `id_ruolo` bigint(20) NOT NULL,
  `ruolo` longtext
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=125 ;

--
-- Trigger `ruoli_granted_to_utenti`
--
DELIMITER //
CREATE TRIGGER `ins_ruolo_ruoli_granted_to_utenti` BEFORE INSERT ON `ruoli_granted_to_utenti`
 FOR EACH ROW set NEW.ruolo = (SELECT `ruolo` FROM `ruoli_utenti` WHERE `id_ruolo` = NEW.id_ruolo)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `ruoli_utenti`
--

CREATE TABLE IF NOT EXISTS `ruoli_utenti` (
`id_ruolo` bigint(20) NOT NULL,
  `ruolo` longtext NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `scansione_orario_as`
--

CREATE TABLE IF NOT EXISTS `scansione_orario_as` (
`id_scansione` bigint(20) NOT NULL,
  `id_anno_scolastico` bigint(20) NOT NULL,
  `giorno_settimana` longtext NOT NULL,
  `num_ora_lezione` int(11) DEFAULT NULL,
  `inizia` time NOT NULL,
  `finisce` time NOT NULL,
  `lezione` tinyint(4) NOT NULL DEFAULT '0',
  `intervallo` tinyint(4) NOT NULL DEFAULT '0',
  `lezioneAsBool` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=299 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `scuole`
--

CREATE TABLE IF NOT EXISTS `scuole` (
  `nome_scuola` varchar(50) NOT NULL,
  `tipo_scuola_acronimo` varchar(10) NOT NULL,
`id_scuola` bigint(20) NOT NULL,
  `indirizzo` varchar(50) DEFAULT NULL,
  `cap` char(6) DEFAULT NULL,
  `città` char(30) DEFAULT NULL,
  `provincia` char(15) DEFAULT NULL,
  `telefono` char(20) DEFAULT NULL,
  `fax` char(20) DEFAULT NULL,
  `email` char(30) DEFAULT NULL,
  `web` char(30) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `studenti`
--

CREATE TABLE IF NOT EXISTS `studenti` (
  `id_classe` bigint(20) NOT NULL,
  `anno_scolastico` char(10) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  `nome` varchar(50) NOT NULL,
`id_studente` bigint(20) NOT NULL,
  `attivo` tinyint(4) NOT NULL DEFAULT '1',
  `ritirato_data` date DEFAULT NULL,
  `id_anno_scolastico` bigint(20) NOT NULL,
  `data_entrata` date DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=236 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `tipologia_giudizi`
--

CREATE TABLE IF NOT EXISTS `tipologia_giudizi` (
`id_giudizio` bigint(20) NOT NULL,
  `giudizio` varchar(15) DEFAULT NULL,
  `value_giudizio` double DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti_logger`
--

CREATE TABLE IF NOT EXISTS `utenti_logger` (
`id_log` bigint(20) NOT NULL,
  `id_utente` bigint(20) DEFAULT NULL,
  `errata_email` text NOT NULL COMMENT 'email fornita in un tentativo di accesso fallito',
  `errata_password` text NOT NULL COMMENT 'password fornita in un tentativo di accesso fallito',
  `ip_client` varchar(32) NOT NULL,
  `message` longtext,
  `msg_type` longtext COMMENT 'TIPO DEL MESSAGGIO',
  `when_registered` datetime DEFAULT NULL COMMENT 'QUANDO è STATO REGISTRATO QUESTO LOG',
  `msg_to_utente` tinyint(4) DEFAULT '0' COMMENT '''0'' SE NON è ANCORA STATO NOTIFICATO ALL''UTENTE id_utente, ''1'' SE è STATO NOTIFICATO. LA DATA DELLA NOTIFICA APPARE NEL CAMPO msg_sent_time',
  `msg_sent_time` datetime DEFAULT NULL COMMENT 'QUANDO è STATO NOTIFICATO ALL''UTENTE'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15560 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti_scuola`
--

CREATE TABLE IF NOT EXISTS `utenti_scuola` (
`id_utente` bigint(20) NOT NULL,
  `cognome` longtext NOT NULL,
  `nome` longtext NOT NULL,
  `email` longtext NOT NULL,
  `password` longtext,
  `user_is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `has_to_change_password` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Messo a 1 quando cambi password'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Trigger `utenti_scuola`
--
DELIMITER //
CREATE TRIGGER `upper_cognome_nome` BEFORE INSERT ON `utenti_scuola`
 FOR EACH ROW SET NEW.cognome = upper(NEW.cognome),
NEW.nome = upper(NEW.nome)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `voti_lezioni_studente`
--

CREATE TABLE IF NOT EXISTS `voti_lezioni_studente` (
  `id_lezione` bigint(20) NOT NULL,
  `id_voto` bigint(20) NOT NULL,
  `id_studente` bigint(20) NOT NULL,
  `voto_string` varchar(15) DEFAULT NULL,
  `voto_num` double DEFAULT NULL,
  `giudizio` tinyint(4) DEFAULT '0',
  `tipo_voto` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura per la vista `assenze_studenti`
--
DROP TABLE IF EXISTS `assenze_studenti`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `assenze_studenti` AS select `studenti`.`id_studente` AS `id_studente`,`studenti`.`cognome` AS `cognome`,`studenti`.`nome` AS `nome`,`classi`.`id_classe` AS `id_classe`,`classi`.`anno_scolastico` AS `anno_scolastico`,`classi`.`nome_classe` AS `nome_classe`,`materie`.`id_materia` AS `id_materia`,`materie`.`materia` AS `materia`,`lezioni`.`id_lezione` AS `id_lezione`,`lezioni`.`data_lezione` AS `data_lezione`,`lezioni`.`ore_lezione` AS `ore_lezione`,`lezioni`.`argomento` AS `argomento`,`ore_assenze`.`num_ora` AS `num_ora`,`ore_assenze`.`assenza` AS `assenza`,`ore_assenze`.`giustifica_assenza` AS `giustifica_assenza`,`ore_assenze`.`ritardo` AS `ritardo`,`ore_assenze`.`giustifica_ritardo` AS `giustifica_ritardo`,`ore_assenze`.`motivo_giustifica` AS `motivo_giustifica` from ((((`studenti` join `ore_assenze`) join `lezioni`) join `materie`) join `classi`) where ((`ore_assenze`.`id_studente` = `studenti`.`id_studente`) and (`ore_assenze`.`id_lezione` = `lezioni`.`id_lezione`) and (`lezioni`.`id_materia` = `materie`.`id_materia`) and (`classi`.`id_classe` = `studenti`.`id_classe`)) order by `classi`.`id_classe`,`studenti`.`cognome`,`studenti`.`nome`,`materie`.`materia`,`lezioni`.`data_lezione`;

-- --------------------------------------------------------

--
-- Struttura per la vista `lezioni_materia`
--
DROP TABLE IF EXISTS `lezioni_materia`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `lezioni_materia` AS select `lezioni`.`data_lezione` AS `data_lezione`,`lezioni`.`ore_lezione` AS `ore_lezione`,`lezioni`.`argomento` AS `argomento`,`lezioni`.`freeze_lezione` AS `freeze_lezione`,`materie`.`id_materia` AS `id_materia`,`lezioni`.`id_lezione` AS `id_lezione`,`anni_scolastici`.`id_anno_scolastico` AS `id_anno_scolastico`,`materie`.`materia` AS `materia`,`anni_scolastici`.`anno_scolastico` AS `anno_scolastico`,`anni_scolastici`.`start_date` AS `start_date`,`anni_scolastici`.`end_date` AS `end_date`,`materie`.`id_insegnante` AS `id_insegnante`,`materie`.`giudizio` AS `giudizio`,`materie`.`scritto` AS `scritto`,`materie`.`orale` AS `orale`,`materie`.`pratico` AS `pratico`,`classi`.`nome_classe` AS `nome_classe`,`classi`.`id_classe` AS `id_classe`,`scuole`.`id_scuola` AS `id_scuola`,`scuole`.`nome_scuola` AS `nome_scuola`,`scuole`.`tipo_scuola_acronimo` AS `tipo_scuola_acronimo` from ((((`lezioni` join `materie`) join `anni_scolastici`) join `classi`) join `scuole`) where ((`materie`.`id_materia` = `lezioni`.`id_materia`) and (`materie`.`id_anno_scolastico` = `anni_scolastici`.`id_anno_scolastico`) and (`materie`.`id_classe` = `classi`.`id_classe`) and (`anni_scolastici`.`id_scuola` = `classi`.`id_scuola`) and (`classi`.`id_anno_scolastico` = `materie`.`id_anno_scolastico`) and (`scuole`.`id_scuola` = `classi`.`id_scuola`));

-- --------------------------------------------------------

--
-- Struttura per la vista `registri_insegnanti`
--
DROP TABLE IF EXISTS `registri_insegnanti`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `registri_insegnanti` AS select `materie`.`id_materia` AS `id_materia`,`scuole`.`tipo_scuola_acronimo` AS `tipo_scuola_acronimo`,`scuole`.`nome_scuola` AS `nome_scuola`,`anni_scolastici`.`anno_scolastico` AS `anno_scolastico`,`classi`.`nome_classe` AS `nome_classe`,`insegnanti`.`cognome` AS `cognome`,`insegnanti`.`nome` AS `nome`,`materie`.`materia` AS `materia`,`insegnanti`.`id_insegnante` AS `id_insegnante`,`anni_scolastici`.`id_anno_scolastico` AS `id_anno_scolastico`,`scuole`.`id_scuola` AS `id_scuola`,`classi`.`id_classe` AS `id_classe` from ((((`materie` join `insegnanti`) join `classi`) join `anni_scolastici`) join `scuole`) where ((`materie`.`id_classe` = `insegnanti`.`id_classe`) and (`materie`.`id_anno_scolastico` = `insegnanti`.`id_anno_scolastico`) and (`insegnanti`.`id_insegnante` = `materie`.`id_insegnante`) and (`classi`.`id_classe` = `insegnanti`.`id_classe`) and (`anni_scolastici`.`id_anno_scolastico` = `classi`.`id_anno_scolastico`) and (`anni_scolastici`.`id_scuola` = `classi`.`id_scuola`) and (`anni_scolastici`.`id_anno_scolastico` = `insegnanti`.`id_anno_scolastico`) and (`scuole`.`id_scuola` = `anni_scolastici`.`id_scuola`)) order by `anni_scolastici`.`anno_scolastico` desc,`insegnanti`.`cognome`,`insegnanti`.`nome`,`classi`.`nome_classe`,`materie`.`materia`;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allievi_risultati_periodo`
--
ALTER TABLE `allievi_risultati_periodo`
 ADD PRIMARY KEY (`id_risultato`);

--
-- Indexes for table `anagrafe_insegnanti`
--
ALTER TABLE `anagrafe_insegnanti`
 ADD PRIMARY KEY (`idanagrafe_insegnanti`), ADD KEY `fk_insegnanti_idx` (`id_insegnante`);

--
-- Indexes for table `anagrafe_studenti`
--
ALTER TABLE `anagrafe_studenti`
 ADD PRIMARY KEY (`idanagrafe_studenti`), ADD KEY `fk_studenti_idx` (`id_studente`);

--
-- Indexes for table `anni_scolastici`
--
ALTER TABLE `anni_scolastici`
 ADD PRIMARY KEY (`id_anno_scolastico`), ADD KEY `scuola_fkey` (`id_scuola`);

--
-- Indexes for table `aule`
--
ALTER TABLE `aule`
 ADD PRIMARY KEY (`id_aula`), ADD KEY `scuole_fkey` (`id_scuola`);

--
-- Indexes for table `change_password_request`
--
ALTER TABLE `change_password_request`
 ADD PRIMARY KEY (`id_request`), ADD KEY `from_user` (`from_user`), ADD KEY `administrator` (`id_admin`);

--
-- Indexes for table `classi`
--
ALTER TABLE `classi`
 ADD PRIMARY KEY (`id_classe`), ADD UNIQUE KEY `classe_as_unique` (`nome_classe`,`anno_scolastico`), ADD UNIQUE KEY `unique_cl_as_id` (`id_classe`,`anno_scolastico`,`id_anno_scolastico`), ADD UNIQUE KEY `UK_4qrm24n0twq6kvphiqqe0wg67` (`nome_classe`,`anno_scolastico`), ADD UNIQUE KEY `UK_b6e6uopoepdc92u94c4ej2hu9` (`id_classe`,`anno_scolastico`,`id_anno_scolastico`), ADD KEY `fk_classi_id_anno_scolastico` (`id_anno_scolastico`), ADD KEY `fk_classi_id_scuola` (`id_scuola`);

--
-- Indexes for table `email_attachments`
--
ALTER TABLE `email_attachments`
 ADD PRIMARY KEY (`id_attachment`), ADD KEY `id_email` (`id_email`);

--
-- Indexes for table `email_recipients`
--
ALTER TABLE `email_recipients`
 ADD PRIMARY KEY (`id_recipient`), ADD KEY `idx_id_email` (`id_email`);

--
-- Indexes for table `email_server_params`
--
ALTER TABLE `email_server_params`
 ADD PRIMARY KEY (`id_email_server`);

--
-- Indexes for table `email_store`
--
ALTER TABLE `email_store`
 ADD PRIMARY KEY (`id_email`), ADD KEY `idx_id_user` (`id_user`);

--
-- Indexes for table `insegnanti`
--
ALTER TABLE `insegnanti`
 ADD PRIMARY KEY (`id_insegnante`), ADD UNIQUE KEY `UK_pgdsuc5nq3qyhthqc3vdjlo1c` (`id_insegnante`,`id_classe`), ADD KEY `fk_insegnanti_id_anno_scolastico` (`id_anno_scolastico`), ADD KEY `fk_insegnanti_id_classe` (`id_classe`);

--
-- Indexes for table `lezioni`
--
ALTER TABLE `lezioni`
 ADD PRIMARY KEY (`id_lezione`), ADD KEY `foreign_materie_fkey` (`id_materia`);

--
-- Indexes for table `log_msg_body`
--
ALTER TABLE `log_msg_body`
 ADD PRIMARY KEY (`id_msg_body`);

--
-- Indexes for table `log_msg_types`
--
ALTER TABLE `log_msg_types`
 ADD PRIMARY KEY (`id_msg_type`), ADD UNIQUE KEY `unique_msg_type` (`msg_type`(255));

--
-- Indexes for table `materie`
--
ALTER TABLE `materie`
 ADD PRIMARY KEY (`id_materia`), ADD UNIQUE KEY `unique_materia` (`materia`,`id_classe`,`anno_scolastico`,`id_anno_scolastico`), ADD UNIQUE KEY `UK_85r9yxkwkoknjokw4iv5o0vnc` (`materia`,`id_classe`,`anno_scolastico`,`id_anno_scolastico`), ADD KEY `fk_materie_id_anno_scolastico` (`id_anno_scolastico`), ADD KEY `fk_materie_id_classe` (`id_classe`), ADD KEY `fk_materie_id_insegnante` (`id_insegnante`);

--
-- Indexes for table `mysql_servers_groups`
--
ALTER TABLE `mysql_servers_groups`
 ADD PRIMARY KEY (`id_server_group`);

--
-- Indexes for table `mysql_server_params`
--
ALTER TABLE `mysql_server_params`
 ADD PRIMARY KEY (`id_server`), ADD KEY `idx_server_groups` (`id_server_group`);

--
-- Indexes for table `orario_insegnante`
--
ALTER TABLE `orario_insegnante`
 ADD PRIMARY KEY (`id_orario`), ADD UNIQUE KEY `unique_id_orario` (`id_orario`), ADD KEY `as_fkey_3` (`id_anno_scolastico`), ADD KEY `insegnanti_fkey` (`id_insegnante`);

--
-- Indexes for table `orario_lezioni_as`
--
ALTER TABLE `orario_lezioni_as`
 ADD PRIMARY KEY (`id_orario_lezioni`), ADD UNIQUE KEY `unique_aula_ora` (`id_scansione`,`id_aula`), ADD UNIQUE KEY `unique_materia_ora` (`id_materia`,`id_scansione`), ADD UNIQUE KEY `UK_cwygnabfwfbbyh9waqsfiqb6w` (`id_scansione`,`id_aula`), ADD UNIQUE KEY `UK_pq9a30g6rexrnkn2pp0fghaql` (`id_materia`,`id_scansione`), ADD KEY `as_fkey_4` (`id_anno_scolastico`), ADD KEY `aula_fkey` (`id_aula`), ADD KEY `classe_fkey_1` (`id_classe`);

--
-- Indexes for table `ore_assenze`
--
ALTER TABLE `ore_assenze`
 ADD PRIMARY KEY (`id_lezione`,`num_ora`,`id_studente`), ADD KEY `studenti_fkey` (`id_studente`);

--
-- Indexes for table `parametri_orario_as`
--
ALTER TABLE `parametri_orario_as`
 ADD PRIMARY KEY (`id_param_orario`), ADD UNIQUE KEY `unique_as` (`id_anno_scolastico`), ADD UNIQUE KEY `UK_growv382xdmr7aifr2l42p8d9` (`id_anno_scolastico`);

--
-- Indexes for table `periodi_anno_scolastico`
--
ALTER TABLE `periodi_anno_scolastico`
 ADD PRIMARY KEY (`id_periodo`,`id_scuola`,`id_anno_scolastico`), ADD KEY `fk_periodi_anno_scolastico_id_anno_scolastico` (`id_anno_scolastico`), ADD KEY `fk_periodi_anno_scolastico_id_scuola` (`id_scuola`);

--
-- Indexes for table `registri_granted`
--
ALTER TABLE `registri_granted`
 ADD PRIMARY KEY (`id_grant`), ADD KEY `utente_fkey` (`id_utente`), ADD KEY `materia_fkey` (`id_materia`), ADD KEY `ruolo_fkey` (`id_ruolo`);

--
-- Indexes for table `ruoli_granted_to_utenti`
--
ALTER TABLE `ruoli_granted_to_utenti`
 ADD PRIMARY KEY (`id_ruoli_granted`), ADD KEY `fk_utente` (`id_utente`), ADD KEY `fk_ruolo` (`id_ruolo`);

--
-- Indexes for table `ruoli_utenti`
--
ALTER TABLE `ruoli_utenti`
 ADD PRIMARY KEY (`id_ruolo`);

--
-- Indexes for table `scansione_orario_as`
--
ALTER TABLE `scansione_orario_as`
 ADD PRIMARY KEY (`id_scansione`), ADD KEY `fkey_as` (`id_anno_scolastico`);

--
-- Indexes for table `scuole`
--
ALTER TABLE `scuole`
 ADD PRIMARY KEY (`id_scuola`);

--
-- Indexes for table `studenti`
--
ALTER TABLE `studenti`
 ADD PRIMARY KEY (`id_studente`), ADD KEY `classi_fkey_1` (`id_classe`);

--
-- Indexes for table `tipologia_giudizi`
--
ALTER TABLE `tipologia_giudizi`
 ADD PRIMARY KEY (`id_giudizio`), ADD UNIQUE KEY `unique_giudizio` (`giudizio`,`value_giudizio`), ADD UNIQUE KEY `UK_6sltix3hjo75ueoa8kut56k8q` (`giudizio`,`value_giudizio`);

--
-- Indexes for table `utenti_logger`
--
ALTER TABLE `utenti_logger`
 ADD PRIMARY KEY (`id_log`), ADD KEY `utenti_fkey` (`id_utente`);

--
-- Indexes for table `utenti_scuola`
--
ALTER TABLE `utenti_scuola`
 ADD PRIMARY KEY (`id_utente`), ADD UNIQUE KEY `unique_cognomenome` (`cognome`(255),`nome`(255)), ADD UNIQUE KEY `unique_email` (`email`(255)), ADD UNIQUE KEY `unique_password` (`password`(255));

--
-- Indexes for table `voti_lezioni_studente`
--
ALTER TABLE `voti_lezioni_studente`
 ADD PRIMARY KEY (`id_lezione`,`id_voto`,`id_studente`), ADD KEY `studenti_fkey_1` (`id_studente`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allievi_risultati_periodo`
--
ALTER TABLE `allievi_risultati_periodo`
MODIFY `id_risultato` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=446;
--
-- AUTO_INCREMENT for table `anagrafe_insegnanti`
--
ALTER TABLE `anagrafe_insegnanti`
MODIFY `idanagrafe_insegnanti` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `anagrafe_studenti`
--
ALTER TABLE `anagrafe_studenti`
MODIFY `idanagrafe_studenti` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `anni_scolastici`
--
ALTER TABLE `anni_scolastici`
MODIFY `id_anno_scolastico` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `aule`
--
ALTER TABLE `aule`
MODIFY `id_aula` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `change_password_request`
--
ALTER TABLE `change_password_request`
MODIFY `id_request` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `classi`
--
ALTER TABLE `classi`
MODIFY `id_classe` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `email_attachments`
--
ALTER TABLE `email_attachments`
MODIFY `id_attachment` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `email_recipients`
--
ALTER TABLE `email_recipients`
MODIFY `id_recipient` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'chiave primaria',AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `email_server_params`
--
ALTER TABLE `email_server_params`
MODIFY `id_email_server` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `email_store`
--
ALTER TABLE `email_store`
MODIFY `id_email` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=84;
--
-- AUTO_INCREMENT for table `insegnanti`
--
ALTER TABLE `insegnanti`
MODIFY `id_insegnante` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `lezioni`
--
ALTER TABLE `lezioni`
MODIFY `id_lezione` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=806;
--
-- AUTO_INCREMENT for table `log_msg_body`
--
ALTER TABLE `log_msg_body`
MODIFY `id_msg_body` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `log_msg_types`
--
ALTER TABLE `log_msg_types`
MODIFY `id_msg_type` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `materie`
--
ALTER TABLE `materie`
MODIFY `id_materia` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT for table `mysql_servers_groups`
--
ALTER TABLE `mysql_servers_groups`
MODIFY `id_server_group` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `mysql_server_params`
--
ALTER TABLE `mysql_server_params`
MODIFY `id_server` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `orario_insegnante`
--
ALTER TABLE `orario_insegnante`
MODIFY `id_orario` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `orario_lezioni_as`
--
ALTER TABLE `orario_lezioni_as`
MODIFY `id_orario_lezioni` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `parametri_orario_as`
--
ALTER TABLE `parametri_orario_as`
MODIFY `id_param_orario` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `periodi_anno_scolastico`
--
ALTER TABLE `periodi_anno_scolastico`
MODIFY `id_periodo` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `registri_granted`
--
ALTER TABLE `registri_granted`
MODIFY `id_grant` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ruoli_granted_to_utenti`
--
ALTER TABLE `ruoli_granted_to_utenti`
MODIFY `id_ruoli_granted` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=125;
--
-- AUTO_INCREMENT for table `ruoli_utenti`
--
ALTER TABLE `ruoli_utenti`
MODIFY `id_ruolo` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `scansione_orario_as`
--
ALTER TABLE `scansione_orario_as`
MODIFY `id_scansione` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=299;
--
-- AUTO_INCREMENT for table `scuole`
--
ALTER TABLE `scuole`
MODIFY `id_scuola` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `studenti`
--
ALTER TABLE `studenti`
MODIFY `id_studente` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=236;
--
-- AUTO_INCREMENT for table `tipologia_giudizi`
--
ALTER TABLE `tipologia_giudizi`
MODIFY `id_giudizio` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `utenti_logger`
--
ALTER TABLE `utenti_logger`
MODIFY `id_log` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15560;
--
-- AUTO_INCREMENT for table `utenti_scuola`
--
ALTER TABLE `utenti_scuola`
MODIFY `id_utente` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=59;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `anagrafe_insegnanti`
--
ALTER TABLE `anagrafe_insegnanti`
ADD CONSTRAINT `fk_insegnanti` FOREIGN KEY (`id_insegnante`) REFERENCES `insegnanti` (`id_insegnante`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `anagrafe_studenti`
--
ALTER TABLE `anagrafe_studenti`
ADD CONSTRAINT `fk_studenti` FOREIGN KEY (`id_studente`) REFERENCES `studenti` (`id_studente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `anni_scolastici`
--
ALTER TABLE `anni_scolastici`
ADD CONSTRAINT `scuola_fkey` FOREIGN KEY (`id_scuola`) REFERENCES `scuole` (`id_scuola`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `aule`
--
ALTER TABLE `aule`
ADD CONSTRAINT `scuole_fkey` FOREIGN KEY (`id_scuola`) REFERENCES `scuole` (`id_scuola`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `change_password_request`
--
ALTER TABLE `change_password_request`
ADD CONSTRAINT `change_password_request_ibfk_1` FOREIGN KEY (`from_user`) REFERENCES `utenti_scuola` (`id_utente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `classi`
--
ALTER TABLE `classi`
ADD CONSTRAINT `fk_classi_id_anno_scolastico` FOREIGN KEY (`id_anno_scolastico`) REFERENCES `anni_scolastici` (`id_anno_scolastico`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_classi_id_scuola` FOREIGN KEY (`id_scuola`) REFERENCES `scuole` (`id_scuola`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `email_attachments`
--
ALTER TABLE `email_attachments`
ADD CONSTRAINT `email_attachments_ibfk_1` FOREIGN KEY (`id_email`) REFERENCES `email_store` (`id_email`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limiti per la tabella `email_recipients`
--
ALTER TABLE `email_recipients`
ADD CONSTRAINT `email_recipients_ibfk_1` FOREIGN KEY (`id_email`) REFERENCES `email_store` (`id_email`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limiti per la tabella `email_store`
--
ALTER TABLE `email_store`
ADD CONSTRAINT `email_store_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utenti_scuola` (`id_utente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `insegnanti`
--
ALTER TABLE `insegnanti`
ADD CONSTRAINT `fk_insegnanti_id_anno_scolastico` FOREIGN KEY (`id_anno_scolastico`) REFERENCES `anni_scolastici` (`id_anno_scolastico`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_insegnanti_id_classe` FOREIGN KEY (`id_classe`) REFERENCES `classi` (`id_classe`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `lezioni`
--
ALTER TABLE `lezioni`
ADD CONSTRAINT `foreign_materie_fkey` FOREIGN KEY (`id_materia`) REFERENCES `materie` (`id_materia`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `materie`
--
ALTER TABLE `materie`
ADD CONSTRAINT `fk_materie_id_anno_scolastico` FOREIGN KEY (`id_anno_scolastico`) REFERENCES `anni_scolastici` (`id_anno_scolastico`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_materie_id_classe` FOREIGN KEY (`id_classe`) REFERENCES `classi` (`id_classe`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_materie_id_insegnante` FOREIGN KEY (`id_insegnante`) REFERENCES `insegnanti` (`id_insegnante`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `mysql_server_params`
--
ALTER TABLE `mysql_server_params`
ADD CONSTRAINT `mysql_server_params_ibfk_1` FOREIGN KEY (`id_server_group`) REFERENCES `mysql_servers_groups` (`id_server_group`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `orario_insegnante`
--
ALTER TABLE `orario_insegnante`
ADD CONSTRAINT `as_fkey_3` FOREIGN KEY (`id_anno_scolastico`) REFERENCES `anni_scolastici` (`id_anno_scolastico`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `insegnanti_fkey` FOREIGN KEY (`id_insegnante`) REFERENCES `insegnanti` (`id_insegnante`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `orario_lezioni_as`
--
ALTER TABLE `orario_lezioni_as`
ADD CONSTRAINT `as_fkey_4` FOREIGN KEY (`id_anno_scolastico`) REFERENCES `anni_scolastici` (`id_anno_scolastico`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `aula_fkey` FOREIGN KEY (`id_aula`) REFERENCES `aule` (`id_aula`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `classe_fkey_1` FOREIGN KEY (`id_classe`) REFERENCES `classi` (`id_classe`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `materia_fkey` FOREIGN KEY (`id_materia`) REFERENCES `materie` (`id_materia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `scansione_oraria_fkey` FOREIGN KEY (`id_scansione`) REFERENCES `scansione_orario_as` (`id_scansione`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `ore_assenze`
--
ALTER TABLE `ore_assenze`
ADD CONSTRAINT `lezioni_fkey` FOREIGN KEY (`id_lezione`) REFERENCES `lezioni` (`id_lezione`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `studenti_fkey` FOREIGN KEY (`id_studente`) REFERENCES `studenti` (`id_studente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `parametri_orario_as`
--
ALTER TABLE `parametri_orario_as`
ADD CONSTRAINT `as_fkey_5` FOREIGN KEY (`id_anno_scolastico`) REFERENCES `anni_scolastici` (`id_anno_scolastico`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `periodi_anno_scolastico`
--
ALTER TABLE `periodi_anno_scolastico`
ADD CONSTRAINT `fk_periodi_anno_scolastico_id_anno_scolastico` FOREIGN KEY (`id_anno_scolastico`) REFERENCES `anni_scolastici` (`id_anno_scolastico`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_periodi_anno_scolastico_id_scuola` FOREIGN KEY (`id_scuola`) REFERENCES `scuole` (`id_scuola`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `registri_granted`
--
ALTER TABLE `registri_granted`
ADD CONSTRAINT `registri_granted_ibfk_1` FOREIGN KEY (`id_materia`) REFERENCES `materie` (`id_materia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `registri_granted_ibfk_2` FOREIGN KEY (`id_ruolo`) REFERENCES `ruoli_utenti` (`id_ruolo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `utente_fkey` FOREIGN KEY (`id_utente`) REFERENCES `utenti_scuola` (`id_utente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `ruoli_granted_to_utenti`
--
ALTER TABLE `ruoli_granted_to_utenti`
ADD CONSTRAINT `fk_ruolo` FOREIGN KEY (`id_ruolo`) REFERENCES `ruoli_utenti` (`id_ruolo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_utente` FOREIGN KEY (`id_utente`) REFERENCES `utenti_scuola` (`id_utente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `scansione_orario_as`
--
ALTER TABLE `scansione_orario_as`
ADD CONSTRAINT `fkey_as` FOREIGN KEY (`id_anno_scolastico`) REFERENCES `anni_scolastici` (`id_anno_scolastico`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `studenti`
--
ALTER TABLE `studenti`
ADD CONSTRAINT `classi_fkey_1` FOREIGN KEY (`id_classe`) REFERENCES `classi` (`id_classe`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `utenti_logger`
--
ALTER TABLE `utenti_logger`
ADD CONSTRAINT `utenti_fkey` FOREIGN KEY (`id_utente`) REFERENCES `utenti_scuola` (`id_utente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `voti_lezioni_studente`
--
ALTER TABLE `voti_lezioni_studente`
ADD CONSTRAINT `lezioni_fkey_1` FOREIGN KEY (`id_lezione`) REFERENCES `lezioni` (`id_lezione`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `studenti_fkey_1` FOREIGN KEY (`id_studente`) REFERENCES `studenti` (`id_studente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
