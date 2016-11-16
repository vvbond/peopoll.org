CREATE TABLE polls (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(255) NOT NULL,
    open BOOLEAN NOT NULL,
    liveview BOOLEAN NOT NULL DEFAULT true,
    dtcreate TIMESTAMP NOT NULL,
    dtexpire TIMESTAMP NOT NULL,
    userid INT UNSIGNED
) DEFAULT CHARACTER SET utf8;

CREATE TABLE questions (
    pid INT UNSIGNED NOT NULL,
    qnum INT(2) UNSIGNED NOT NULL,
    qtxt varchar(255) NOT NULL,
    qtype enum('tf','single','multi','quanti') NOT NULL,
    PRIMARY KEY (pid, qnum)
)

CREATE TABLE answers (
    pid INT UNSIGNED NOT NULL,
    qnum INT(2) UNSIGNED NOT NULL,
    anum INT(2) UNSIGNED NOT NULL,
    atxt varchar(255) NOT NULL,
    votes SMALLINT UNSIGNED,
    PRIMARY KEY (pid, qnum, anum)
) DEFAULT CHARACTER SET utf8;


CREATE TABLE tags (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tag varchar(50) NOT NULL
) DEFAULT CHARACTER SET utf8;


CREATE TABLE pollstags (
    pid INT UNSIGNED NOT NULL,
    tid INT UNSIGNED NOT NULL
)

-- CLICKER TABLES.
CREATE TABLE clickers (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(255) NOT NULL UNIQUE,
    active BOOLEAN NOT NULL,
    liveview BOOLEAN NOT NULL DEFAULT false,
    dtcreate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    dtexpire TIMESTAMP NOT NULL,
    userid INT UNSIGNED,
    SID VARCHAR(100) NOT NULL,
    numans TINYINT UNSIGNED NOT NULL DEFAULT 4,
    binsMin INT DEFAULT 1,
    binsMax INT DEFAULT 100,
    qtype enum('single','multi','quanti') NOT NULL DEFAULT 'single',
    qtid TINYINT UNSIGNED NOT NULL DEFAULT 1,
    qnum TINYINT UNSIGNED NOT NULL DEFAULT 0
) DEFAULT CHARACTER SET utf8;


-- QUESTIONS TEMPLATES.
-- qtype: 1 - single, 2 - multi, 3 - quanti.
-- numans: number of answers.
CREATE TABLE qtemplates (
    qtid TINYINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    qtype enum('single','multi','quanti'), 
    numans TINYINT NOT NULL,
    name varchar(50)
) DEFAULT CHARACTER SET utf8;

-- Answer labels.
CREATE TABLE a2q(
    qtid TINYINT UNSIGNED NOT NULL,
    atxt VARCHAR(255) NOT NULL
) DEFAULT CHARACTER SET utf8;

-- Answers table for clicker.
CREATE TABLE clicks (
    cid INT UNSIGNED NOT NULL,
    qnum TINYINT UNSIGNED NOT NULL,
    anum TINYINT UNSIGNED NOT NULL,
    atxt varchar(255) NOT NULL,
    votes SMALLINT UNSIGNED DEFAULT 0,
    PRIMARY KEY (cid, qnum, anum)
) DEFAULT CHARACTER SET utf8;
