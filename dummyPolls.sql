-- create a poll:
INSERT INTO polls (name, active, dtexpire)
VALUES('test poll 1', 1, '2014-05-28 00:00');
-- add 3 questions:
INSERT INTO questions (pid, qnum, qtxt,qtype)
VALUES(1,1,'question 1','single');
INSERT INTO questions (pid, qnum, qtxt,qtype)
VALUES(1,2,'question 2','single');
INSERT INTO questions (pid, qnum, qtxt,qtype)
VALUES(1,3,'question 3','single');
COMMIT;
-- add some answers to question 1:
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(1,1,1,'answer 1', 0);
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(1,1,2,'answer 2', 0);
-- add some answers to question 2:
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(1,2,1,'answer 1', 0);
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(1,2,2,'answer 2', 0);
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(1,2,3,'answer 3', 0);
-- add some answers to question 3:
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(1,3,1,'answer 1', 0);
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(1,3,2,'answer 2', 0);
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(1,3,3,'answer 3', 0);
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(1,3,4,'answer 4', 0);
COMMIT;

-- another poll:
INSERT INTO polls (name, active, dtexpire)
VALUES('test poll 2', 1, '2014-06-01 00:00');
-- add 4 questions:
INSERT INTO questions (pid, qnum, qtxt,qtype)
VALUES(2,1,'question 1','single');
INSERT INTO questions (pid, qnum, qtxt,qtype)
VALUES(2,2,'question 2','tf');
INSERT INTO questions (pid, qnum, qtxt,qtype)
VALUES(2,3,'question 3','multi');
INSERT INTO questions (pid, qnum, qtxt,qtype)
VALUES(2,4,'question 4','quanti');
-- add some answers to question 1 (single):
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(2,1,1,'answer 1', 0);
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(2,1,2,'answer 2', 0);
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(2,1,3,'answer 3', 0);
-- add true/false answers to question 2 (true/false):
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(2,2,1,'true', 0);
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(2,2,2,'false', 0);
-- add some answers to question 3 (multi):
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(2,3,1,'answer 1', 0);
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(2,3,2,'answer 2', 0);
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(2,3,3,'answer 3', 0);
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(2,3,4,'answer 4', 0);
-- add the answer for the quantitative question 4:
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(2,4,1,'answer 1', 0);
COMMIT;
