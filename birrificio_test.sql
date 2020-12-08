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
  tipo set('Pils','Bock','Weizen','Saison','Blanche','Tripel','Lambic','Bitter','Golden_Ale','Stout','American_IPA','American_Pale_Ale','Fruit_Beer', 'Imperial_Stout') NOT NULL,
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
  admin_flag boolean NOT NULL DEFAULT FALSE,
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
INSERT INTO utenti (id, username, password, admin_flag, nome, cognome, data_nascita) VALUES
(1, 'admin', 'admin', TRUE, NULL, NULL, NULL),
(2, 'giacomo', 'sassaro', FALSE, 'Giacomo', 'Sassaro', '1999-05-17');

INSERT INTO birre (id, nome, img_path, tipo, grado, descrizione, costo) VALUES
(1, 'Open Baladin Gold', 'img/open_baladin_gold.png','American_Pale_Ale', 7.5, 'Una birra dal carattere forte e accattivante. Open Gold è anche un grande progetto di cultura e condivisione birraria essendo la prima “open source” d’Italia, avendone pubblicato la ricetta online per gli homebrewer. Di colore oro carico, si propone con una schiuma cremosa e compatta. Al naso si ritrova l’agrumato dei luppoli americani. In bocca sono evidenti gli spunti agrumati di pompelmo che ben si accompagna al piacevole aroma amarognolo del luppolo.', 3.8),
(2, 'Nazionale', 'img/nazionale.png', 'Golden_Ale', 6.5, 'La prima birra 100% italiana, ottenuta da materie prime nazionali.\nBirra volutamente semplice: acqua, malto d’orzo, luppolo, lievito e due spezie italiane (bergamotto e coriandolo), che si incontrano con armonia e originalità.\nUna birra che suggerirà abbinamenti più o meno arditi ma che rappresenta “in primis” una tappa fondamentale nella produzione italiana della birra artigianale.', 4.1),
(3, 'Suzy Dry', 'img/suzy_dry.png','Fruit_Beer', 6.5, 'Birra alla prugna. Al naso ha note delicate e fresche di uva fragola e fiori bianchi. In bocca si sovrappongono aromi leggermente vinosi e morbidi sentori di prugna, sostenuti da una gradevole quanto blanda acidità che rende la birra beverina, rendendo la gradazione alcolica difficilmente riconoscibile. Il finale chiude sulla freschezza delle note pepate che ben si armonizzano con la delicatezza dei cereali utilizzati per produrla.', 13.9),
(4, 'Isaac', 'img/isaac.png', 'Blanche', 5, 'Dal bicchiere ti invitano la sua schiuma pannosa, il colore volutamente torbido e leggero di albicocca e un profumo di lievito ed agrumi che vanno a perdersi in armonie speziate di coriandolo e arance sbucciate.\nÈ ideale per un aperitivo e si accompagna a cibi freschi, ad antipasti leggeri di verdure e molto bene anche con il pesce.\nFresca al palato ha corpo leggero ed è molto beverina.', 4.1),
(5, 'Mercurio', 'img/mercurio.png', 'Saison', 5.8, 'Mercurio è una birra dedicata alla primavera, alla sua leggerezza e all\'incredibile capacità di stupirti ogni volta che la incontri! L\'aroma risulta dominato dalla freschezza della fermentazione lattica che si intreccia in un intrigante incontro con un classico lievito saison, a sigillare il loro matrimonio troviamo un infusione di fiori di melograno ed ibisco. L\'imbocco è subito acidulo, la segale compartecipa a meraviglia con l\'animo indomito dei lieviti conferendole note rustiche seguite da una bella secchezza che viene abbracciata da sentori agrumati e di frutti di bosco. Il finale è secco, estremamente pulito con un acidità controllata.', 4.8),
(6, 'Neon City', 'img/neon_city.png', 'Imperial_Stout', 10.9, 'Realizzata in collaborazione con i birrai Lettoni di Ārpus Brewing Co., questa Stout Imperiale viene prodotta impiegando un infuso di fagioli Tonka e caffè brasiliano Bela Vista della torrefazione Kalve Roastery. Aroma agrodolce con marshmallow, fave di Tonka, malti tostati, vaniglia, caramello, caffè ed alcune prugne secche. Al palato, piena e morbida e con la componente alcolica ben nascosta, è cioccolatosa e ricorda a tratti una crostata con uvetta, mirtilli e ciliegie rosse. Finale torrefatto con un retrogusto amaro-piccante.', 5.5),
(7, 'Novapils', 'img/novapils.png', 'Pils', 5, 'NovaPils è una birra dal colore giallo paglierino, in stile Pils. Al naso, i luppoli utilizzati le conferiscono fresche note erbacee e floreali. Al palato si dimostra piacevole e dissetante, con un buon apporto amaricante che stimola la bevuta. Leggera e beverina, adatta a tutte le occasioni.', 3.75),
(8, 'Open Gold', 'img/open_baladin_gold.png','American_Pale_Ale', 7.5, 'Una birra dal carattere forte e accattivante. Open Gold è anche un grande progetto di cultura e condivisione birraria essendo la prima “open source” d’Italia, avendone pubblicato la ricetta online per gli homebrewer. Di colore oro carico, si propone con una schiuma cremosa e compatta. Al naso si ritrova l’agrumato dei luppoli americani. In bocca sono evidenti gli spunti agrumati di pompelmo che ben si accompagna al piacevole aroma amarognolo del luppolo.', 3.8),
(9, 'Nazionsssale', 'img/nazionale.png', 'Golden_Ale', 6.5, 'La prima birra 100% italiana, ottenuta da materie prime nazionali.\nBirra volutamente semplice: acqua, malto d’orzo, luppolo, lievito e due spezie italiane (bergamotto e coriandolo), che si incontrano con armonia e originalità.\nUna birra che suggerirà abbinamenti più o meno arditi ma che rappresenta “in primis” una tappa fondamentale nella produzione italiana della birra artigianale.', 4.1),
(10, 'Suzsssy Dry', 'img/suzy_dry.png','Fruit_Beer', 6.5, 'Birra alla prugna. Al naso ha note delicate e fresche di uva fragola e fiori bianchi. In bocca si sovrappongono aromi leggermente vinosi e morbidi sentori di prugna, sostenuti da una gradevole quanto blanda acidità che rende la birra beverina, rendendo la gradazione alcolica difficilmente riconoscibile. Il finale chiude sulla freschezza delle note pepate che ben si armonizzano con la delicatezza dei cereali utilizzati per produrla.', 13.9),
(11, 'Isassssac', 'img/isaac.png', 'Blanche', 5, 'Dal bicchiere ti invitano la sua schiuma pannosa, il colore volutamente torbido e leggero di albicocca e un profumo di lievito ed agrumi che vanno a perdersi in armonie speziate di coriandolo e arance sbucciate.\nÈ ideale per un aperitivo e si accompagna a cibi freschi, ad antipasti leggeri di verdure e molto bene anche con il pesce.\nFresca al palato ha corpo leggero ed è molto beverina.', 4.1);



INSERT INTO ordini (id, utente, data, totale) VALUES
(1, 2, '2020-12-01', 15),
(2, 2, '2020-10-06', 50);

INSERT INTO articoli_ordine (id, birra, quantità, parziale, ordine) VALUES
(1, 4, 4, 25, 1),
(2, 2, 2, 4, 1);

INSERT INTO recensioni (id, utente, birra, descrizione, voto) VALUES
(1, 2, 1, 'buona', 5),
(2, 2, 4, 'speciale', 10);