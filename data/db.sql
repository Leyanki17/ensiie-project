DROP TABLE IF EXISTS "users", chansons ,likes;

CREATE TABLE "users"
(
id SERIAL NOT NULL UNIQUE PRIMARY KEY,
nom VARCHAR(120) NOT NULL, 
"login" VARCHAR(120) NOT NULL,
"password" VARCHAR(256) NOT NULL,
statut Varchar(256) NOT NULL, 
avatar Varchar(1024)
);

CREATE TABLE chansons
(
id SERIAL NOT NULL UNIQUE PRIMARY KEY,
titre VARCHAR(120) NOT NULL,
artistes VARCHAR(120) NOT NULL,
style VARCHAR(20) NOT NULL,
link Varchar(200) NOT NULL,
album VARCHAR(60) NOT NULL,
dates VARCHAR(4) Not NULL,
id_user INTEGER NOT NULL,
CONSTRAINT fk_user
	FOREIGN KEY(id_user)
	REFERENCES "users"(id)

);


CREATE TABLE playlist
(
id SERIAL NOT NULL UNIQUE PRIMARY KEY,
nom VARCHAR(60) NOT NULL,
id_user INTEGER NOT NULL,
CONSTRAINT fk_user
	FOREIGN KEY(id_user)
	REFERENCES "users"(id)

);

CREATE TABLE likes
(
 id_user INTEGER NOT NULL,
 id_chanson INTEGER NOT NULL,
 
 PRIMARY KEY (id_user, id_chanson),
 CONSTRAINT fk_user
	FOREIGN KEY(id_user)
	REFERENCES "users"(id),
CONSTRAINT fk_chanson
	FOREIGN KEY(id_chanson)
	REFERENCES chansons(id)

);

INSERT INTO "users" (nom, "login", password, "statut") VALUES ('Jordan', 'phoenix','$2y$10$7MnOgj/InpTjksucOH7oQeVeHTRhvEOT127Z.x7K3gJxuf1DDEPfu','admin');
INSERT INTO "users" (nom, "login", password, "statut") VALUES ('Nicolas', 'Nico','$2y$10$7MnOgj/InpTjksucOH7oQeVeHTRhvEOT127Z.x7K3gJxuf1DDEPfu','admin');
INSERT INTO "users" (nom, "login", password, "statut") VALUES ('toto', 'toto','$2y$10$KL2S6L1FEGyrXNmDiymx0ejU4OwXKijDPeFa55qO0FdKtHVFdvWpq','user' );
INSERT INTO "users" (nom, "login", password, "statut") VALUES ('tata', 'dame','$2y$10$KL2S6L1FEGyrXNmDiymx0ejU4OwXKijDPeFa55qO0FdKtHVFdvWpq','user');



INSERT INTO "chansons" (titre, artistes, style, link, album, dates, id_user) VALUES ('Perfect', 'Ed sheeran', 'POP','musics/test.mp3','Dive', '2017', 1);
INSERT INTO "chansons" (titre, artistes, style, link, album, dates, id_user) VALUES ('Dear Mom', 'D.A.X', 'R&B', 'musics/test.mp3', 'Dear Mom', '2021', 1);
INSERT INTO "chansons" (titre, artistes, style, link, album, dates, id_user) VALUES ('My heart hurts', 'D.A.X', 'R&B', 'musics/test.mp3', 'I will say it for you', '2020', 2);

INSERT INTO "chansons" (titre, artistes, style, link, album, dates, id_user) VALUES ('Afterglow', 'Ed sheeran', 'POP', 'musics/test.mp3', 'Afterglow', '2021', 3);
INSERT INTO "chansons" (titre, artistes, style, link, album, dates, id_user) VALUES ('Zina', 'Babylone', 'Africaine', 'musics/test.mp3',  'Byra', '2011', 3);
INSERT INTO "chansons" (titre, artistes, style, link, album, dates, id_user) VALUES ('Slow Dancing in the burning room', 'musics/test.mp3',  'John mayer', 'POP', 'Continuum', '2006', 4);