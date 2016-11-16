-- create a homework poll:
INSERT INTO polls (name, active, dtexpire)
VALUES('Homework', 0, '2014-06-21 00:00');
-- add 3 questions:
INSERT INTO questions (pid, qnum, qtxt,qtype)
VALUES(5,1,'Have you done your homework?','single');
-- add some answers to question 1:
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(5,1,1,'Yes!', 0);
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(5,1,2,'No', 0);
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(5,1,3,'Tried...', 0);
COMMIT;

-- create a prediction poll:
INSERT INTO polls (name, active, dtexpire)
VALUES('DAX forecast', 0, '2014-06-21 00:00');
-- add 3 questions:
INSERT INTO questions (pid, qnum, qtxt,qtype)
VALUES(2,1,'Your trade recommendation 20-24 Jun 2014:','single');
-- add some answers to question 1:
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(2,1,1,'Buy', 0);
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(2,1,2,'Hold', 0);
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(2,1,3,'Sell', 0);
COMMIT;

-- create a lottery poll:
INSERT INTO polls (name, active, dtexpire)
VALUES('Expected utility experiment', 0, '2014-06-26 00:00');
-- add 2 questions:
-- 1.
INSERT INTO questions (pid, qnum, qtxt,qtype)
VALUES(3,1,'Choose a gamble:','single');
-- answers to question 1:
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(3,1,1,'A: Win 4000 Euro with probability 0.2', 0);
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(3,1,2,'B: Win 3000 Euro with probability 0.25', 0);
COMMIT;
-- 2.
INSERT INTO questions (pid, qnum, qtxt,qtype)
VALUES(3,2,'Choose another gamble:','single');
-- answers to question 2:
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(3,2,1,'C: Win 4000 Euro with probability 0.8', 0);
INSERT INTO answers (pid, qnum, anum, atxt, votes)
VALUES(3,2,2,'D: Win 3000 Euro with certainty', 0);
COMMIT;
