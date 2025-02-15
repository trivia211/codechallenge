CREATE DATABASE codechallenge DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_hungarian_ci;
USE codechallenge;

CREATE TABLE players (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id), UNIQUE(name)) ENGINE = 'InnoDB';

INSERT INTO players VALUES (NULL, "Barna Domi", "$2y$10$OZadWyciwP89f5quDtBV6.68oVhnECtsmg1NjVxYOAuKFXKxLeK/y");
INSERT INTO players VALUES (NULL, "Benedek Domi", "$2y$10$qx0rhga1PPArgSU52BsesOU/M3I9f1zy1YA33ZVuKUzSIRVDORT1e");
INSERT INTO players VALUES (NULL, "Sanyi", "$2y$10$UG6UGzj70y8oUji0.FFxtOhg4JpfLgSzzkrQ0JSb8mcwLZcUWbhD6");
INSERT INTO players VALUES (NULL, "Adri", "$2y$10$okGVPg6DYvYJSwCYAb1CP.erhrRAOe4/W9RBV.wj4qHLpWFHhg0D2");

CREATE TABLE challenges (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, title VARCHAR(100) NOT NULL, PRIMARY KEY(id), UNIQUE(name), UNIQUE(title)) ENGINE = 'InnoDB';
CREATE TABLE challengeExercises(id INT UNSIGNED AUTO_INCREMENT NOT NULL, challengeId INT UNSIGNED NOT NULL, no TINYINT UNSIGNED NOT NULL, PRIMARY KEY(id), FOREIGN KEY(challengeId) REFERENCES challenges(id) ON DELETE CASCADE, UNIQUE(challengeId, no)) ENGINE = 'InnoDB';

INSERT INTO challenges VALUES (1, 'rudolf', "1. Rudolf");
INSERT INTO challengeExercises (challengeId, no) VALUES (1, 1),(1, 2),(1, 3);

INSERT INTO challenges values(2, 'squidgame', "2. Tintahaljáték");
INSERT INTO challengeExercises (challengeId, no) VALUES (2, 1), (2, 2), (2, 3), (2, 4);

CREATE TABLE solutions (id INT UNSIGNED AUTO_INCREMENT NOT NULL, playerId INT UNSIGNED NOT NULL, exerciseId INT UNSIGNED NOT NULL, code TEXT NOT NULL, PRIMARY KEY(id), addTime DATETIME(4) NOT NULL DEFAULT NOW(4), FOREIGN KEY(playerId) REFERENCES players(id) ON DELETE CASCADE, FOREIGN KEY(exerciseId) REFERENCES challengeExercises(id)) ENGINE = 'InnoDB';

CREATE TABLE results (id INT UNSIGNED AUTO_INCREMENT NOT NULL, playerId INT UNSIGNED NOT NULL, challengeId INT UNSIGNED NOT NULL, result ENUM("1", "2", "3", "4") NOT NULL, PRIMARY KEY(id), FOREIGN KEY(playerId) REFERENCES players(id) ON DELETE CASCADE, FOREIGN KEY(challengeId) REFERENCES challenges(id) ON DELETE CASCADE, UNIQUE(playerId, challengeId)) ENGINE = 'InnoDB';
