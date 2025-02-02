-- * sqlchange 1 *

INSERT INTO challenges values(null, 'squidgame', "2. Tintahaljáték");
SELECT LAST_INSERT_ID() INTO @sgid;
INSERT INTO challengeExercises VALUES(NULL, @sgid, 1);
INSERT INTO challengeExercises VALUES(NULL, @sgid, 2);
INSERT INTO challengeExercises VALUES(NULL, @sgid, 3);
INSERT INTO challengeExercises VALUES(NULL, @sgid, 4);
