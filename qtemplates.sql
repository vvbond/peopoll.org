-- Create a list of questions templates:

-- 1. Single choice questions:
INSERT INTO qtemplates (qtype, numans, name)
VALUES('single',0,'Letters'),
('single',0,'Numeric'),
('single',0,'Bins');

-- 1.1 Binary templates.
INSERT INTO qtemplates (qtype, numans, name)
VALUES('single',2,'True-False'),
('single',2,'Yes-No'),
('single',2,'Agree-Disagree'),
('single',2,'More-Less');

-- 1.2 Ternary templates.
INSERT INTO qtemplates (qtype, numans, name)
VALUES('single',3,"Yes-No-Unsure"),
('single',3,'Agree-Disagree-Indifferent'),
('single',3,'More-Less-Equal');

-- 2. Multiple choice questions:
INSERT INTO qtemplates (qtype, numans, name)
VALUES('multi',0,'Letters'),
('multi',0,'Numeric'),
('multi',0,'Bins');

-- Temporary template for Natasha:
INSERT INTO qtemplates (qtype, numans, name)
VALUES('multi',8,'Learning Characteristics');

-- ANSWERS TO THE TEMPLATE QUESTIONS.
-- Letters.
INSERT INTO a2q (qtid, atxt)
VALUES('1', 'A'),('1', 'B'),('1', 'C'),('1', 'D'),('1', 'E'),
('1', 'F'),('1', 'G'),('1', 'H'),('1', 'I'),('1', 'J');

-- Numeric scale.
INSERT INTO a2q (qtid, atxt)
VALUES('2', '1'),('2', '2'),('2', '3'),('2', '4'),('2', '5'),
('2', '6'),('2', '7'),('2', '8'),('2', '9'),('2', '10');

-- Default bins:
INSERT INTO a2q(qtid, atxt)
VALUES(3,'1-10'),(3,'11-20'),(3,'21-30'),(3,'31-40'),(3,'41-50'),
(3,'51-60'),(3,'61-70'),(3,'71-80'),(3,'81-90'),(3,'91-100');

-- Binary.
INSERT INTO a2q (qtid, atxt)
VALUES('4', 'true'),('4', 'false'),
('5', 'yes'),('5', 'no'),
('6', 'agree'),('6', 'disagree'),
('7', 'more'),('7', 'less');

-- Ternary.
INSERT INTO a2q (qtid, atxt)
VALUES('8', 'yes'),('8', 'no'),('8', "not sure"),
('9', 'agree'),('9', 'disagree'),('9', "indifferet"),
('10', 'more'),('10', 'less'),('10', "equal");

-- MULTIPLE CHOICE QUESTIONS.
-- Letters.
INSERT INTO a2q (qtid, atxt)
VALUES('11', 'A'),('11', 'B'),('11', 'C'),('11', 'D'),('11', 'E'),
('11', 'F'),('11', 'G'),('11', 'H'),('11', 'I'),('11', 'J');

-- Numeric scale.
INSERT INTO a2q (qtid, atxt)
VALUES('12', '1'),('12', '2'),('12', '3'),('12', '4'),('12', '5'),
('12', '6'),('12', '7'),('12', '8'),('12', '9'),('12', '10');

-- Default bins:
INSERT INTO a2q(qtid, atxt)
VALUES(13,'1-10'),(13,'11-20'),(13,'21-30'),(13,'31-40'),(13,'41-50'),
(13,'51-60'),(13,'61-70'),(13,'71-80'),(13,'81-90'),(13,'91-100');

-- Temporary for Natasha:
INSERT INTO a2q(qtid, atxt)
VALUES(14,'Visual OR'),(14,'Verbal'),(14,'Sequential OR'),(14,'Global'),(14,'Sensing OR'),
(14,'Intuitive'),(14,'Active OR'),(14,'Reflective');
