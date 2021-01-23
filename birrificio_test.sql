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
  tipo set('Pils','Bock','Weizen','Saison','Blanche','Tripel','Lambic','Bitter','Golden_Ale','Stout','American_IPA','American_Pale_Ale','Fruit_Beer','Imperial_Stout', 'Double_IPA') NOT NULL,
  grado float UNSIGNED NOT NULL,
  descrizione text DEFAULT NULL,
  costo float NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY (nome)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS utenti (
  id int(11) NOT NULL AUTO_INCREMENT,
  username varchar(64) NOT NULL UNIQUE,
  password varchar(64) NOT NULL,
  admin_flag boolean NOT NULL DEFAULT FALSE,
  nome varchar(64) DEFAULT NULL,
  cognome varchar(64) DEFAULT NULL,
  email varchar(64) DEFAULT NULL,
  PRIMARY KEY (Id)
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
INSERT INTO utenti (id, username, password, admin_flag, nome, cognome, email) VALUES
(1, 'admin', 'admin', TRUE, NULL, NULL, NULL),
(2, 'user', 'user', FALSE, 'user1', 'user1', 'user1@latanadel.luppolo.com'),
(3, 'user2', 'user2', FALSE, 'user2', 'user2', 'user1@latanadel.luppolo.com'),
(4, 'user3', 'user3', FALSE, 'user3', 'user3', 'user1@latanadel.luppolo.com'),
(5, 'giacomo', 'sassaro', FALSE, 'Giacomo', 'Sassaro', 'peroni@latanadel.luppolo.com'),
(6, 'ayoub', 'maher', FALSE, 'Ayoub', 'Maher', 'tennents@latanadel.luppolo.com'),
(7, 'gianpics', 'tovo', FALSE, 'Gianpiero Giuseppe', 'Tovo', 'corona@latanadel.luppolo.com'),
(8, 'denisa', 'hida', FALSE, 'Denisa', 'Hida', 'ichnusa@latanadel.luppolo.com');


INSERT INTO birre (id, nome, img_path, tipo, grado, descrizione, costo) VALUES
(1, 'Open Baladin Gold', 'img/open_baladin_gold.png','American_Pale_Ale', 7.5, 'Una birra dal carattere forte e accattivante. Open Gold è anche un grande progetto di cultura e condivisione birraria essendo la prima “open source” d’Italia, avendone pubblicato la ricetta online per gli homebrewer. Di colore oro carico, si propone con una schiuma cremosa e compatta. Al naso si ritrova l’agrumato dei luppoli americani. In bocca sono evidenti gli spunti agrumati di pompelmo che ben si accompagna al piacevole aroma amarognolo del luppolo.', 3.8),
(2, 'Nazionale', 'img/nazionale.png', 'Golden_Ale', 6.5, 'La prima birra 100% italiana, ottenuta da materie prime nazionali.\nBirra volutamente semplice: acqua, malto d’orzo, luppolo, lievito e due spezie italiane (bergamotto e coriandolo), che si incontrano con armonia e originalità.\nUna birra che suggerirà abbinamenti più o meno arditi ma che rappresenta “in primis” una tappa fondamentale nella produzione italiana della birra artigianale.', 4.1),
(3, 'Suzy Dry', 'img/suzy_dry.png','Fruit_Beer', 6.5, 'Birra alla prugna. Al naso ha note delicate e fresche di uva fragola e fiori bianchi. In bocca si sovrappongono aromi leggermente vinosi e morbidi sentori di prugna, sostenuti da una gradevole quanto blanda acidità che rende la birra beverina, rendendo la gradazione alcolica difficilmente riconoscibile. Il finale chiude sulla freschezza delle note pepate che ben si armonizzano con la delicatezza dei cereali utilizzati per produrla.', 13.9),
(4, 'Isaac', 'img/isaac.png', 'Blanche', 5, 'Dal bicchiere ti invitano la sua schiuma pannosa, il colore volutamente torbido e leggero di albicocca e un profumo di lievito ed agrumi che vanno a perdersi in armonie speziate di coriandolo e arance sbucciate.\nÈ ideale per un aperitivo e si accompagna a cibi freschi, ad antipasti leggeri di verdure e molto bene anche con il pesce.\nFresca al palato ha corpo leggero ed è molto beverina.', 4.1),
(5, 'Mercurio', 'img/mercurio.png', 'Saison', 5.8, 'Mercurio è una birra dedicata alla primavera, alla sua leggerezza e all\'incredibile capacità di stupirti ogni volta che la incontri! L\'aroma risulta dominato dalla freschezza della fermentazione lattica che si intreccia in un intrigante incontro con un classico lievito saison, a sigillare il loro matrimonio troviamo un infusione di fiori di melograno ed ibisco. L\'imbocco è subito acidulo, la segale compartecipa a meraviglia con l\'animo indomito dei lieviti conferendole note rustiche seguite da una bella secchezza che viene abbracciata da sentori agrumati e di frutti di bosco. Il finale è secco, estremamente pulito con un acidità controllata.', 4.8),
(6, 'Neon City', 'img/neon_city.png', 'Imperial_Stout', 10.9, 'Realizzata in collaborazione con i birrai Lettoni di Ārpus Brewing Co., questa Stout Imperiale viene prodotta impiegando un infuso di fagioli Tonka e caffè brasiliano Bela Vista della torrefazione Kalve Roastery. Aroma agrodolce con marshmallow, fave di Tonka, malti tostati, vaniglia, caramello, caffè ed alcune prugne secche. Al palato, piena e morbida e con la componente alcolica ben nascosta, è cioccolatosa e ricorda a tratti una crostata con uvetta, mirtilli e ciliegie rosse. Finale torrefatto con un retrogusto amaro-piccante.', 5.5),
(7, 'Novapils', 'img/novapils.png', 'Pils', 5, 'NovaPils è una birra dal colore giallo paglierino, in stile Pils. Al naso, i luppoli utilizzati le conferiscono fresche note erbacee e floreali. Al palato si dimostra piacevole e dissetante, con un buon apporto amaricante che stimola la bevuta. Leggera e beverina, adatta a tutte le occasioni.', 3.75),
(8, 'Golosa', 'img/golosa.png','American_Pale_Ale', 5.5, 'Dal colore ambrato Golosa è una birra facile, leggera e ruffianella realizzata con luppoli americani delicatamente dosati per conferire una grande bevibilità ed equilibrio tra i sentori aromatici del luppolo e quelli del malto. Fresca e leggera, al palato si percepiscono piacevoli note amare e fruttate, con in evidenza sentori floreali e di frutta esotica.', 4.25),
(9, 'Tupamaros', 'img/tupamaros.png', 'Double_IPA', 8, 'La nostra Tupamaros ha una luppolatura decisamente esagerata come richiede lo stile. Sentori agrumati e di frutta tropicale caratterizzano il naso di questa nostra birra amara ma equilibrata, complessa e persistente. In bocca è secca ed incredibilmente facile da bere nonostante i suoi otto gradi alcolici (ben nascosti!). Termina con note resinose e balsamiche. Birra estrema, ricca di aromi e sapori intensi regalati dalle migliori varietà di luppolo americano presenti in grandi quantità in questa bomba luppolata', 5.15),
(10, 'Asfalto', 'img/asfalto.png','Double_IPA', 7.5, 'Asfalto è una birra in stile Double IPA dal colore ambrato, prodotta con doppio dry hopping di luppoli del Pacifico e scorza di bergamotto. I sentori sono freschi e pungenti con in evidenza note amare intense e persistenti al palato, sentori fruttati ed agrumati. Ottima in abbinamento a carni grigliate. ', 4.10),
(11, 'Open Baladin White', 'img/open_baladin_white.png', 'Blanche', 5, 'Schiuma pannosa. Al naso si sprigionano gradevoli profumi di agrumi, lievito e frumento. Corpo delicato e ben bilanciato per favorirne la bevibilità. In bocca si propone molto fresca e saporita di note di agrumi e coriandolo; la parte amaricata è data da un uso equilibrato di luppolo e radice di genziana, quest’ultima utilizzata in infusione a freddo. ', 3.8);

INSERT INTO recensioni (id, utente, birra, descrizione, voto) VALUES
(1, 2, 1, 'buona', 5),
(2, 2, 4, 'speciale', 10),
(3,7,3,"diam nunc, ullamcorper eu,",8),(4,4,5,"aliquam adipiscing lacus. Ut nec urna et arcu imperdiet",5),(5,4,4,"eu arcu. Morbi sit amet massa. Quisque porttitor eros nec tellus.",10),(6,2,11,"dapibus id, blandit at, nisi. Cum",5),(7,3,6,"sodales elit erat vitae risus. Duis a mi",5),(8,4,6,"scelerisque scelerisque dui. Suspendisse ac metus vitae velit egestas lacinia. Sed congue,",3),(9,4,4,"Nam tempor diam",8),(10,7,3,"eu, accumsan sed, facilisis vitae, orci.",3),(11,7,3,"at",6),(12,7,1,"sem,",7),(13,8,11,"Aenean",8),(14,4,1,"elit erat vitae risus. Duis a mi",8),(15,2,5,"Suspendisse aliquet molestie tellus. Aenean egestas hendrerit",4),(16,4,8,"fames ac turpis egestas. Aliquam fringilla cursus purus. Nullam scelerisque neque",10),(17,7,4,"ut",1),(18,7,7,"lectus, a sollicitudin orci sem eget massa. Suspendisse eleifend. Cras sed",9),(19,4,7,"dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor.",8),(20,2,4,"tortor, dictum eu, placerat",7),(21,4,7,"volutpat. Nulla dignissim. Maecenas ornare egestas ligula. Nullam feugiat",3),(22,8,1,"blandit viverra. Donec tempus, lorem fringilla ornare placerat, orci lacus",6),(23,7,3,"dignissim tempor arcu. Vestibulum ut eros non enim commodo hendrerit.",4),(24,2,5,"eu neque pellentesque massa lobortis ultrices.",1),(25,6,7,"nascetur",8),(26,7,8,"a, auctor non, feugiat nec, diam. Duis mi enim,",4),(27,5,10,"amet diam eu",10),(28,8,10,"ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed",2),(29,2,3,"eu tellus. Phasellus elit pede, malesuada vel, venenatis vel,",3),(30,8,1,"non quam. Pellentesque habitant",6),(31,7,6,"in, cursus et, eros. Proin ultrices. Duis volutpat nunc sit amet",10),(32,6,5,"risus, at fringilla purus mauris",6),(33,3,7,"semper erat, in consectetuer ipsum nunc",7),(34,8,2,"sapien imperdiet",10),(35,8,3,"mollis",9),(36,7,8,"mollis vitae, posuere",2),(37,2,5,"ridiculus",5),(38,2,10,"eget, venenatis a,",3),(39,8,1,"augue. Sed molestie.",5),(40,7,4,"sem ut cursus luctus, ipsum leo elementum sem, vitae aliquam",9),(41,6,5,"Phasellus",6),(42,2,8,"Suspendisse non leo. Vivamus nibh dolor, nonummy ac, feugiat non, lobortis quis,",8),(43,3,6,"vel, convallis in,",6),(44,6,8,"Nulla semper",4),(45,4,1,"vulputate velit eu sem. Pellentesque ut",2),(46,3,4,"orci.",9),(47,6,5,"Nulla tempor augue ac ipsum. Phasellus",1),(48,5,10,"aliquet odio. Etiam",5),(49,6,3,"viverra. Maecenas iaculis aliquet diam. Sed",8),(50,2,11,"eleifend nec, malesuada ut, sem. Nulla interdum. Curabitur dictum. Phasellus in felis.",5),(51,3,1,"magna. Phasellus",3),(52,8,10,"vulputate",10),(53,7,9,"mauris eu",2),(54,7,1,"sapien molestie orci tincidunt adipiscing. Mauris molestie",8),(55,7,2,"ornare tortor at risus. Nunc",3),(56,5,1,"ullamcorper, nisl arcu iaculis enim, sit amet ornare lectus",3),(57,4,11,"a neque. Nullam ut nisi a odio semper",10),(58,3,10,"Donec egestas. Aliquam nec enim. Nunc ut erat. Sed",7),(59,3,11,"lobortis quam a felis ullamcorper viverra. Maecenas iaculis",3),(60,6,3,"diam.",3),(61,5,8,"Nullam enim. Sed",8),(62,3,1,"Nullam enim. Sed",5),(63,8,7,"mollis vitae, posuere at, velit. Cras lorem",5),(64,4,7,"habitant morbi tristique senectus et netus et",7),(65,2,8,"lobortis. Class aptent taciti sociosqu ad litora torquent",10),(66,8,2,"ultrices. Vivamus rhoncus. Donec est. Nunc ullamcorper, velit in",10),(67,7,5,"urna. Nullam lobortis",8),(68,5,9,"massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero. Integer",5),(69,6,2,"vel sapien imperdiet ornare. In faucibus. Morbi vehicula.",2),(70,7,10,"interdum feugiat. Sed",5),(71,2,9,"aliquet diam. Sed",10),(72,7,2,"Ut tincidunt orci quis lectus. Nullam suscipit, est ac facilisis facilisis,",3),(73,7,9,"non, bibendum sed, est. Nunc",6),(74,2,11,"elit fermentum risus, at fringilla purus",2),(75,3,1,"aliquam eu, accumsan sed, facilisis vitae, orci. Phasellus dapibus quam quis diam.",1),(76,3,10,"nec, leo. Morbi neque tellus, imperdiet non, vestibulum",1),(77,5,8,"Donec non justo. Proin non massa non ante",5),(78,8,10,"ante",4),(79,8,8,"Proin mi. Aliquam gravida mauris ut mi. Duis risus odio, auctor",5),(80,7,3,"lectus",4),(81,7,5,"montes, nascetur ridiculus",1),(82,3,1,"cursus. Integer mollis. Integer",9),(83,6,1,"orci tincidunt",6),(84,5,2,"et magnis dis parturient montes, nascetur",5),(85,3,7,"tempus scelerisque, lorem ipsum sodales purus, in",3),(86,7,8,"Duis a mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet,",5),(87,7,9,"Duis gravida. Praesent",6),(88,4,4,"nec, diam.",8),(89,7,8,"sem semper erat, in",6),(90,2,11,"dui. Fusce diam",1),(91,8,1,"netus et malesuada fames ac turpis egestas. Fusce aliquet magna a",3),(92,7,7,"justo nec ante. Maecenas mi",7),(93,8,10,"consectetuer",8),(94,3,1,"a ultricies adipiscing, enim mi tempor lorem, eget mollis",10),(95,4,3,"tempus scelerisque, lorem ipsum sodales purus, in molestie tortor nibh sit",10),(96,3,10,"amet, risus. Donec nibh enim, gravida sit",10),(97,2,4,"nibh. Aliquam ornare, libero",5),(98,7,6,"Nulla tincidunt, neque vitae semper egestas, urna justo faucibus lectus,",3),(99,3,10,"non, cursus non, egestas a, dui. Cras pellentesque. Sed dictum. Proin",7),(100,3,5,"gravida sagittis. Duis gravida. Praesent eu nulla at sem molestie",7),(101,4,1,"varius. Nam porttitor scelerisque neque. Nullam",6),(102,8,2,"malesuada ut, sem. Nulla interdum. Curabitur",1);