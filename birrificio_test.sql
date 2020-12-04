-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 01, 2020 at 01:45 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.3.21

-- Database: birrificio_test
SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS recensioni;
DROP TABLE IF EXISTS articoli_ordine;
DROP TABLE IF EXISTS ordini;
DROP TABLE IF EXISTS utenti;
DROP TABLE IF EXISTS birre;


CREATE TABLE IF NOT EXISTS birre (
  id int(11) NOT NULL AUTO_INCREMENT,
  nome varchar(64) NOT NULL,
  tipo set('Pils','Bock','Weizen','Saison','Blanche','Tripel','Lambic','Bitter','Barley_Wine','Stout','American_IPA','American_Pale_Ale','Imperial_Stout') NOT NULL,
  grado float UNSIGNED NOT NULL,
  descrizione text DEFAULT NULL,
  costo float NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY (nome)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS utenti (
  id int(11) NOT NULL AUTO_INCREMENT,
  username varchar(64) NOT NULL,
  password varchar(64) NOT NULL,
  nome varchar(64) DEFAULT NULL,
  cognome varchar(64) DEFAULT NULL,
  data_nascita date DEFAULT NULL,
  PRIMARY KEY (Id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS ordini (
  id int(11) NOT NULL AUTO_INCREMENT,
  utente int(11) NOT NULL,
  data date NOT NULL,
  totale float NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_ordine_utente
  FOREIGN KEY (utente) REFERENCES utenti(id) ON DELETE CASCADE ON UPDATE CASCADE 
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS articoli_ordine (
  id int(11) NOT NULL AUTO_INCREMENT,
  birra int(11) NOT NULL,
  quantità int(11) NOT NULL,
  parziale double NOT NULL,
  ordine int(11) NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_articoli_ordine_birra
  FOREIGN KEY (birra) REFERENCES birre (id) ON DELETE CASCADE ON UPDATE CASCADE, 
  CONSTRAINT fk_articoli_ordine_ordine
  FOREIGN KEY (ordine) REFERENCES ordini (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS recensioni (
  id int(11) NOT NULL AUTO_INCREMENT,
  utente int(11) NOT NULL,
  birra int(11) NOT NULL,
  descrizione text DEFAULT NULL,
  voto int(11) NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_recensioni_birra
  FOREIGN KEY (birra) REFERENCES birre (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_recensioni_utente
  FOREIGN KEY (utente) REFERENCES utenti (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;




-- INSERT DATA
INSERT INTO utenti (id, username, password, nome, cognome, data_nascita) VALUES
(1, 'admin', 'admin', NULL, NULL, NULL),
(2, 'giacomo', 'sassaro', 'Giacomo', 'Sassaro', '1999-05-17');

INSERT INTO birre (id, nome, tipo, grado, descrizione, costo) VALUES
(1, 'Nastro Azzurro', 'Pils', 5.1, 'La Nastro Azzurro è una birra premium pilsner italiana prodotta a partire dagli anni sessanta dal birrificio Peroni di Roma', 3),
(2, 'Heineken', 'Pils', 4.1, 'La birra Heineken è una birra molto bevuta e venduta in Italia e in tutto il mondo.Siamo di fronte ad una lager assolutamente monodimensionale nel suo proporsi: il luppolo ed il malto sono piuttosto deboli ma fortunatamente l\'alcol non è fastidioso e tende a venir fuori solo sulla distanza. In bocca la punta d\'amaro può non piacere (basta abbassarne la temperatura di servizio) ma è sicuramente il suo, unico, tratto distintivo.', 3.5),
(3, 'Birra Moretti', 'Pils', 3.1, 'Birra Moretti è il nome di una birra italiana. L\'azienda produttrice fu fondata nel 1859 a Udine da Luigi Moretti; nel 1996 è stata venduta alla società olandese Heineken che ne detiene il marchio. La Birra Moretti è una delle birre più vendute in Italia ed è discretamente famosa anche all\'estero.', 2),
(4, 'Guinness', 'Stout', 4.2, 'La Guinness è una birra di tipo stout prodotta dalla Arthur Guinness Son & Co., una fabbrica di birra irlandese fondata a Dublino nel 1759 da Arthur Guinness nella celebre St. James\'s Gate Brewery', 5.5);

INSERT INTO ordini (id, utente, data, totale) VALUES
(1, 2, '2020-12-01', 15),
(2, 2, '2020-10-06', 50);

INSERT INTO articoli_ordine (id, birra, quantità, parziale, ordine) VALUES
(1, 4, 4, 25, 1),
(2, 2, 2, 4, 1);

INSERT INTO recensioni (id, utente, birra, descrizione, voto) VALUES
(1, 2, 1, 'buona', 5),
(2, 2, 4, 'speciale', 10);