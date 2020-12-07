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
  img_path varchar(255) DEFAULT 'img/beer_img.jpg',
  tipo set('Pils','Bock','Weizen','Saison','Blanche','Tripel','Lambic','Bitter','Golden_Ale','Stout','American_IPA','American_Pale_Ale','Fruit_Beer') NOT NULL,
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

INSERT INTO birre (id, nome, img_path, tipo, grado, descrizione, costo) VALUES
(1, 'Open Baladin Gold', 'img/open_baladin_gold.png','American_Pale_Ale', 7.5, 'Una birra dal carattere forte e accattivante. Open Gold è anche un grande progetto di cultura e condivisione birraria essendo la prima “open source” d’Italia, avendone pubblicato la ricetta online per gli homebrewer. Di colore oro carico, si propone con una schiuma cremosa e compatta. Al naso si ritrova l’agrumato dei luppoli americani. In bocca sono evidenti gli spunti agrumati di pompelmo che ben si accompagna al piacevole aroma amarognolo del luppolo.', 3.8),
(2, 'Nazionale', 'img/nazionale.png', 'Golden_Ale', 6.5, 'La prima birra 100% italiana, ottenuta da materie prime nazionali.\nBirra volutamente semplice: acqua, malto d’orzo, luppolo, lievito e due spezie italiane (bergamotto e coriandolo), che si incontrano con armonia e originalità.\nUna birra che suggerirà abbinamenti più o meno arditi ma che rappresenta “in primis” una tappa fondamentale nella produzione italiana della birra artigianale.', 4.1),
(3, 'Suzy Dry', 'img/suzy_dry.png','Fruit_Beer', 6.5, 'Birra alla prugna. Al naso ha note delicate e fresche di uva fragola e fiori bianchi. In bocca si sovrappongono aromi leggermente vinosi e morbidi sentori di prugna, sostenuti da una gradevole quanto blanda acidità che rende la birra beverina, rendendo la gradazione alcolica difficilmente riconoscibile. Il finale chiude sulla freschezza delle note pepate che ben si armonizzano con la delicatezza dei cereali utilizzati per produrla.', 13.9),
(4, 'Isaac', 'img/isaac.png', 'Blanche', 5, 'Dal bicchiere ti invitano la sua schiuma pannosa, il colore volutamente torbido e leggero di albicocca e un profumo di lievito ed agrumi che vanno a perdersi in armonie speziate di coriandolo e arance sbucciate.\nÈ ideale per un aperitivo e si accompagna a cibi freschi, ad antipasti leggeri di verdure e molto bene anche con il pesce.\nFresca al palato ha corpo leggero ed è molto beverina.', 4.1);

INSERT INTO ordini (id, utente, data, totale) VALUES
(1, 2, '2020-12-01', 15),
(2, 2, '2020-10-06', 50);

INSERT INTO articoli_ordine (id, birra, quantità, parziale, ordine) VALUES
(1, 4, 4, 25, 1),
(2, 2, 2, 4, 1);

INSERT INTO recensioni (id, utente, birra, descrizione, voto) VALUES
(1, 2, 1, 'buona', 5),
(2, 2, 4, 'speciale', 10);