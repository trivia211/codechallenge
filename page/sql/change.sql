-- * sqlchange1 *
INSERT INTO challenges values(NULL, 'brown', "2. Brown mozgás");
SELECT LAST_INSERT_ID() INTO @sgid;
INSERT INTO challengeExercises (challengeId, no) VALUES (@sgid, 1), (@sgid, 2), (@sgid, 3);
