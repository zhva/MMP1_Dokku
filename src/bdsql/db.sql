CREATE TABLE users (
    id              serial PRIMARY KEY,
    login           varchar(50) NOT NULL UNIQUE,
    email           varchar(50) NOT NULL UNIQUE,
    password_hash   varchar(100) NOT NULL
);

CREATE TABLE class (
    api_id         SMALLINT NOT NULL UNIQUE,
    name           varchar(50) NOT NULL,
    slug           varchar(50) NOT NULL UNIQUE
);

CREATE TABLE decks (
    id              serial PRIMARY KEY,
    deck_name       varchar(100),
    deck_code       varchar(200) NOT NULL,
    description     varchar(500),
    rating          SMALLINT CONSTRAINT rating_value CHECK (rating >= 0 AND rating < 6),
    class_id        SMALLINT REFERENCES class(api_id) ON DELETE CASCADE ON UPDATE CASCADE,
    dust_cost       SMALLINT CONSTRAINT non_negative CHECK (dust_cost >= 0),
    last_modified   TIMESTAMP,
    user_id         integer NOT NULL REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE

);

/*------------------------------------------------------------------------------------------------*/
INSERT INTO users (login, email, password_hash)
  VALUES('ViectaKeNo', 'ViectaKeNo@gmail.com', '$2y$10$Srz.8WtF5rI2vW9ZOJyda.xyl80DlNEQzwAsTl8WMmqsS70mKf2B6');

INSERT INTO users (login, email, password_hash)
  VALUES('IspeLDworf', 'IspeLDworf@gmail.com', '$2y$10$zWy3SQszBGlw/03f3tF9lexYsH4hYYJoJiGazLvlh8QZHY3R51kui');

INSERT INTO users (login, email, password_hash)
  VALUES('UmbrellaBla', 'UmbrellaBla@gmail.com', '$2y$10$CCmmBzDJuTkyJLO1lkTPwe2iAEh.paONYAqCDwj6s1iIOFvXR4vAK');

INSERT INTO users (login, email, password_hash)
  VALUES('GrumpyKitten', 'GrumpyKitten@gmail.com', '$2y$10$49M/huN82/SutHL4bcj/Kenj7B6NM.54NO52fTz0u0GiL9nxmkk/y');

INSERT INTO users (login, email, password_hash)
  VALUES('test', 'test@gmail.com', '$2y$10$kKJZgl/YREjXhiJMJfqWZO7VOXt306aa86sfTcch7vIRD2/4vmWFe');
/*------------------------------------------------------------------------------------------------*/

INSERT INTO class (api_id, name, slug)
  VALUES(14, 'Demon Hunter', 'demonhunter');
INSERT INTO class (api_id, name, slug)
  VALUES(2, 'Druid', 'druid');
INSERT INTO class (api_id, name, slug)
  VALUES(3, 'Hunter', 'hunter');
INSERT INTO class (api_id, name, slug)
  VALUES(4, 'Mage', 'mage');
INSERT INTO class (api_id, name, slug)
  VALUES(5, 'Paladin', 'paladin');
INSERT INTO class (api_id, name, slug)
  VALUES(6, 'Priest', 'priest');
INSERT INTO class (api_id, name, slug)
  VALUES(7, 'Rogue', 'rogue');
INSERT INTO class (api_id, name, slug)
  VALUES(8, 'Shaman', 'shaman');
INSERT INTO class (api_id, name, slug)
  VALUES(9, 'Warlock', 'warlock');
INSERT INTO class (api_id, name, slug)
  VALUES(10, 'Warrior', 'warrior');

/*------------------------------------------------------------------------------------------------*/

INSERT INTO decks (deck_name, deck_code, description, rating, class_id, dust_cost, last_modified, user_id)
  VALUES('Big Beast Hunter', 'AAECAR8I5e8DxfsDlPwD25EE4Z8EwLkE57kEm8kEC%2BrpA8OABKmfBNejBOWkBMCsBO2xBIiyBJa3BOC5BIPIBAA%3D', 'This deck is #2 Legend', 5, 3, 10680, '2022-04-23 04:05:06', 1);
INSERT INTO decks (deck_name, deck_code, description, rating, class_id, dust_cost, last_modified, user_id)
  VALUES('Charge Control Warrior', 'AAECAQcIx%2FkDv4AEvIoEiqUE5bAEjbUElrcEjskEC47tA%2FiABPmMBPqMBIigBImgBKygBPyiBIu3BIy3BI7UBAA%3D', 'This deck is #1 Legend', 5, 10, 13080, '2022-04-18 11:25:18', 2);
INSERT INTO decks (deck_name, deck_code, description, rating, class_id, dust_cost, last_modified, user_id)
  VALUES('Pirate Thief Rogue', 'AAECAaIHBqH5A7%2BABO2ABPuKBK%2B2BNi2BAy9gAT2nwT3nwTuoAS6pAS7pAT7pQT5rASvswS3swSywQSKyQQA', 'This deck is Top 50 Legend', 4, 7, 11520, '2022-04-12 10:11:36', 3);
INSERT INTO decks (deck_name, deck_code, description, rating, class_id, dust_cost, last_modified, user_id)
  VALUES('Burn Shaman', 'AAECAaoIBqbvA4b6A8ORBMeyBJbUBJjUBAzj7gOU8APW9QPTgAS5kQSVkgTblAT5nwT8tASWtwSywQSH1AQA', 'This deck is #176 Legend', 3, 3, 13440, '2022-04-22 18:21:03', 4);
INSERT INTO decks (deck_name, deck_code, description, rating, class_id, dust_cost, last_modified, user_id)
  VALUES('Naga Mage', 'AAECAf0EBLL3A9D5A%2FT8A6neBA3U6gPQ7AOu9wOogQT8ngSEsgSIsgS8sgSHtwSWtwTcuQThuQSywQQA', 'This deck is #9 Legend', 5, 4, 6000, '2022-04-12 22:45:28', 1);
INSERT INTO decks (deck_name, deck_code, description, rating, class_id, dust_cost, last_modified, user_id)
  VALUES('Kazakuzan Control Paladin', 'AAECAZ8FCJHsA6bvA9D5A%2BCLBISwBLCyBJjUBJCkBQvM6wPw9gOL%2BAPunwTQrASWtwTQvQTXvQSS1ASh1ASRpAUA', 'This deck is early #60 Legend', 3, 5, 11880, '2022-05-10 19:08:15', 1);
INSERT INTO decks (deck_name, deck_code, description, rating, class_id, dust_cost, last_modified, user_id)
  VALUES('Budget Naga Face Hunter', 'AAECAR8AD9zqA9vtA%2Ff4A8X7A8OABLugBMukBOGkBL%2BsBJ2wBO2xBIiyBOC5BIPIBIHJBAA%3D', 'This deck is meeeeee', 2, 3, 2040, '2022-05-12 17:58:33', 2);
INSERT INTO decks (deck_name, deck_code, description, rating, class_id, dust_cost, last_modified, user_id)
  VALUES('Shellfish Priest', 'AAECAa0GBtTtA%2BiLBImyBJbUBJjUBIakBQyZ6wPo7wOH9wOMgQStigSKowSitgSjtgSktgS4tgS%2B3AT28QQA', 'This deck is #2 Legend', 5, 6, 10560, '2022-05-07 09:42:57', 3);
INSERT INTO decks (deck_name, deck_code, description, rating, class_id, dust_cost, last_modified, user_id)
  VALUES('Mech Paladin', 'AAECAa35Awby7QPn8AO98QO7igSwkQTxkQQMmOoD1%2B0Dg%2FsDxYAEj58EsZ8E56AE4qIE26MEiLAEh7cEnNQEAA%3D%3D', 'This deck is #4 Legend', 5, 5, 9600, '2022-05-22 12:12:12', 1);
INSERT INTO decks (deck_name, deck_code, description, rating, class_id, dust_cost, last_modified, user_id)
  VALUES('Beast Druid', 'AAECAZICAuWwBJa3BA6I9APJ9QP09gOB9wOE9wOsgASvgAShjQTnpASXpQSQtQT6vQSuwASywQQA', 'This deck is #33 Legend', 4, 2, 7200, '2022-05-22 15:44:29', 2);
INSERT INTO decks (deck_name, deck_code, description, rating, class_id, dust_cost, last_modified,user_id)
  VALUES('Naga Aggro Demon-Hunter', 'AAECAea5Awbn8APQ%2BQO7igSHiwS1swT7vwQMwvEDifcDyIAEhI0Etp8EyZ8EtKAEirAEjrAEiLIEh7cEmLoEAA%3D%3D', 'This deck is EARLY #1 Legend', 5, 14, 7800, '2022-05-22 23:59:59', 3);
INSERT INTO decks (deck_name, deck_code, description, rating, class_id, dust_cost, last_modified,user_id)
  VALUES('Control Warrior', 'AAECAQcMpu8D0PkDvIoEiKAEiaAEpa0EhLAE5bAE1bIEi7cEjskEmNQECY7tA%2FiABPmMBPqMBNKsBIy3BJa3BLLBBI7UBAA%3D', 'This deck is #5 Legend', 4, 10, 15360, '2022-05-21 22:49:09', 5);
INSERT INTO decks (deck_name, deck_code, description, rating, class_id, dust_cost, last_modified, user_id)
  VALUES('Burn Shaman IKE', 'AAECAaoIBob6A6iBBMORBISyBOe1BJjUBAzE%2BQPTgAS5kQT5kQSVkgTblAT5nwT8tAS8tgSWtwSF1ASH1AQA', 'This deck is #15 Legend in Sunken City', 3, 3, 10080, '2022-04-14 16:32:03', 5);
INSERT INTO decks (deck_name, deck_code, description, rating, class_id, dust_cost, last_modified, user_id)
  VALUES('Vanndar Druid', 'AAECAZICCLCKBLSKBImLBKeNBO%2BkBKWtBISwBNu5BAuvgASljQSJnwSunwTanwS6rATJrATPrAT%2FvQSuwATaoQUA', 'This deck is #3 Legend. Best deck for OTK', 4, 5, 15120, '2022-04-13 12:28:14', 5);
INSERT INTO decks (deck_name, deck_code, description, rating, class_id, dust_cost, last_modified, user_id)
  VALUES('Naga Hero Power Mage', 'AAECAf0EBtTqA9jsA6CKBJbUBJjUBKneBAzQ7APT7APW7AOu9wP8ngSIsgS8sgSHtwSWtwTcuQThuQSywQQA', 'This deck is from APXVOID', 5, 2, 12420, '2022-04-01 04:19:45', 5);

/*------------------------------------------------------------------------------------------------*/
