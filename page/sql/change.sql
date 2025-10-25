-- * sqlchange1 *
INSERT INTO challenges values(3, 'brown', "3. Brown mozgás");
INSERT INTO challengeExercises (challengeId, no) VALUES (3, 1), (3, 2), (3, 3);

-- * sqlchange2 *
INSERT INTO challenges values(4, 'hunt', "4. Vadászat");
INSERT INTO challengeExercises (challengeId, no) VALUES (4, 1), (4, 2), (4, 3), (4, 4);

-- * sqlchange3 *
INSERT INTO challenges values(5, 'halado1', "Haladó I.");
INSERT INTO challengeExercises (challengeId, no) VALUES (5, 1);
