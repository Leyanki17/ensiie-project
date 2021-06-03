DROP TABLE IF EXISTS "users", music ,playlist,likes, ajout;

CREATE TABLE "users"
(
id SERIAL NOT NULL UNIQUE PRIMARY KEY,
nom VARCHAR(120) NOT NULL, 
"login" VARCHAR(120) NOT NULL,
"password" VARCHAR(256) NOT NULL,
statut Varchar(256) NOT NULL, 
"description" Varchar(1024)
);

CREATE TABLE chansons
(
id SERIAL NOT NULL UNIQUE PRIMARY KEY,
titre VARCHAR(120) NOT NULL,
artistes VARCHAR(120) NOT NULL,
style VARCHAR(20) NOT NULL,
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


CREATE TABLE ajout
(
 id_chanson INTEGER NOT NULL,
 id_playlist INTEGER NOT NULL,
 
 PRIMARY KEY (id_playlist, id_chanson),
 CONSTRAINT fk_playlist
	FOREIGN KEY(id_playlist)
	REFERENCES playlist(id),
CONSTRAINT fk_chanson
	FOREIGN KEY(id_chanson)
	REFERENCES chansons(id)
);


INSERT INTO "users" (nom, "login", password, "statut","description") VALUES ('Jordan', 'phoenix','$2y$10$7MnOgj/InpTjksucOH7oQeVeHTRhvEOT127Z.x7K3gJxuf1DDEPfu','admin', 'C''est un admin le first');
INSERT INTO "users" (nom, "login", password, "statut","description") VALUES ('Nicolas', 'Nico','$2y$10$7MnOgj/InpTjksucOH7oQeVeHTRhvEOT127Z.x7K3gJxuf1DDEPfu','admin', 'C''est un admin le second');
INSERT INTO "users" (nom, "login", password, "statut","description") VALUES ('toto', 'toto','$2y$10$KL2S6L1FEGyrXNmDiymx0ejU4OwXKijDPeFa55qO0FdKtHVFdvWpq','user', 'C''estun user ');
INSERT INTO "users" (nom, "login", password, "statut","description") VALUES ('tata', 'dame','$2y$10$KL2S6L1FEGyrXNmDiymx0ejU4OwXKijDPeFa55qO0FdKtHVFdvWpq','user', 'C''est un user');



INSERT INTO "chansons" (titre, artistes, style, album, dates, id_user) VALUES ('Perfect', 'Ed sheeran', 'POP', 'Dive', '2017', 1);
INSERT INTO "chansons" (titre, artistes, style, album, dates, id_user) VALUES ('Dear Mom', 'D.A.X', 'R&B', 'Dear Mom', '2021', 1);
INSERT INTO "chansons" (titre, artistes, style, album, dates, id_user) VALUES ('My heart hurts', 'D.A.X', 'R&B', 'I will say it for you', '2020', 2);

INSERT INTO "chansons" (titre, artistes, style, album, dates, id_user) VALUES ('Afterglow', 'Ed sheeran', 'POP', 'Afterglow', '2021', 3);
INSERT INTO "chansons" (titre, artistes, style, album, dates, id_user) VALUES ('Zina', 'Babylone', 'Africaine', 'Byra', '2011', 3);
INSERT INTO "chansons" (titre, artistes, style, album, dates, id_user) VALUES ('Slow Dancing in the burning room', 'John mayer', 'POP', 'Continuum', '2006', 4);

 

-- CREATE TABLE "user" (
--     id SERIAL PRIMARY KEY ,
--     firstname VARCHAR NOT NULL ,
--     lastname VARCHAR NOT NULL ,
--     birthday date
-- );

-- INSERT INTO "user"(firstname, lastname, birthday) VALUES ('John', 'Doe', '1967-11-22');
-- INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Yvette', 'Angel', '1932-01-24');
-- INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Amelia', 'Waters', '1981-12-01');
-- INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Manuel', 'Holloway', '1979-07-25');
-- INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Alonzo', 'Erickson', '1947-11-13');
-- INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Otis', 'Roberson', '1995-01-09');
-- INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Jaime', 'King', '1924-05-30');
-- INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Vicky', 'Pearson', '1982-12-12)');
-- INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Silvia', 'Mcguire', '1971-03-02');
-- INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Brendan', 'Pena', '1950-02-17');
-- INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Jackie', 'Cohen', '1967-01-27');
-- INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Delores', 'Williamson', '1961-07-19');