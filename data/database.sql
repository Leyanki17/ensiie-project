DROP TABLE IF EXISTS "user", music ,playlist,likes, ajout;

CREATE TABLE "user"
(
id SERIAL NOT NULL UNIQUE PRIMARY KEY,
nom VARCHAR(120) NOT NULL, 
pass VARCHAR(256) NOT NULL,
Statut Varchar(256) NOT NULL, 
description Varchar(1024)
);

CREATE TABLE music
(
id SERIAL NOT NULL UNIQUE PRIMARY KEY,
titre VARCHAR(120) NOT NULL,
artites VARCHAR(120) NOT NULL,
style VARCHAR(20) NOT NULL,
album VARCHAR(60) NOT NULL,
dates VARCHAR(4) Not NULL,
id_user INTEGER NOT NULL,
CONSTRAINT fk_user
	FOREIGN KEY(id_user)
	REFERENCES "user"(id)

);

CREATE TABLE playlist
(
id SERIAL NOT NULL UNIQUE PRIMARY KEY,
nom VARCHAR(60) NOT NULL,
id_user INTEGER NOT NULL,
CONSTRAINT fk_user
	FOREIGN KEY(id_user)
	REFERENCES "user"(id)

);

CREATE TABLE likes
(
 id_user INTEGER NOT NULL,
 id_music INTEGER NOT NULL,
 
 PRIMARY KEY (id_user, id_music),
 CONSTRAINT fk_user
	FOREIGN KEY(id_user)
	REFERENCES "user"(id),
CONSTRAINT fk_music
	FOREIGN KEY(id_music)
	REFERENCES music(id)

);


CREATE TABLE ajout
(
 id_music INTEGER NOT NULL,
 id_playlist INTEGER NOT NULL,
 
 PRIMARY KEY (id_playlist, id_music),
 CONSTRAINT fk_playlist
	FOREIGN KEY(id_playlist)
	REFERENCES playlist(id),
CONSTRAINT fk_music
	FOREIGN KEY(id_music)
	REFERENCES music(id)
);
