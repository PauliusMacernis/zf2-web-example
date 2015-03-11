DROP TABLE IF EXISTS tests;
CREATE TABLE tests(
  id INTEGER(11) AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  `locale` CHAR(5) DEFAULT 'en_US',
  description TINYTEXT,
  duration SMALLINT DEFAULT 60, -- the duration of the test in minutes
  creator INTEGER(11),
  active BOOLEAN,
  definition TEXT, -- serialized definition of test questions and answers
  cdate TIMESTAMP DEFAULT 0, -- created date
  mdate TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP, -- modified date
  UNIQUE KEY(name,locale)
);