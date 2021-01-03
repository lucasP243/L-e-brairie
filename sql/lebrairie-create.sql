-- CREATE SCRIPT - LEBRAIRIE
-- AUTHOR : Lucas Pinard

CREATE DATABASE IF NOT EXISTS lebrairie;
ALTER DATABASE lebrairie CHARACTER SET utf8 COLLATE utf8_general_ci;
USE lebrairie;


-- TABLES
DROP TABLE IF EXISTS in_order;
DROP TABLE IF EXISTS receipt;
DROP TABLE IF EXISTS useraccount;
DROP TABLE IF EXISTS book;
DROP TABLE IF EXISTS author;
DROP TABLE IF EXISTS editor;
DROP TABLE IF EXISTS genre;

CREATE TABLE author (
	author_id INT AUTO_INCREMENT PRIMARY KEY,
    author_name VARCHAR(50) NOT NULL
) ENGINE=INNODB;

CREATE TABLE editor (
	editor_id INT AUTO_INCREMENT PRIMARY KEY,
    editor_name VARCHAR(50) NOT NULL
) ENGINE=INNODB;

CREATE TABLE genre (
	genre_id INT AUTO_INCREMENT PRIMARY KEY,
    genre_name VARCHAR(50) NOT NULL
) ENGINE=INNODB;

CREATE TABLE book (
	book_id INT AUTO_INCREMENT PRIMARY KEY,
    book_title VARCHAR(100) NOT NULL,
    book_cover VARCHAR(100) NOT NULL,
    book_price DECIMAL(4,2) NOT NULL,
    book_stock INTEGER NOT NULL,
    book_summary TEXT DEFAULT NULL,
    author_id INT NOT NULL,
    editor_id INT NOT NULL,
    genre_id INT NOT NULL
) ENGINE=INNODB;

CREATE TABLE useraccount (
	useraccount_id INT AUTO_INCREMENT PRIMARY KEY,
    useraccount_email VARCHAR(256) NOT NULL,
    useraccount_passwordhash CHAR(32) NOT NULL,
    useraccount_firstname VARCHAR(50) NOT NULL,
    useraccount_lastname VARCHAR(50) NOT NULL,
    useraccount_dob DATE NOT NULL,
    useraccount_creation DATETIME NOT NULL,
    useraccount_lastlogin DATETIME DEFAULT NULL
) ENGINE=INNODB;

CREATE TABLE receipt (
	receipt_id INT AUTO_INCREMENT PRIMARY KEY,
    receipt_date DATETIME NOT NULL,
    receipt_totalamount DECIMAL(12,2) NOT NULL,
    useraccount_id INT NOT NULL
) ENGINE=INNODB;

CREATE TABLE in_order (
	receipt_id INT,
    book_id INT,
    book_quantity INT NOT NULL
) ENGINE=INNODB;


-- CONSTRAINTS

ALTER TABLE book
ADD CONSTRAINT fk_book_author 
FOREIGN KEY (author_id) REFERENCES author(author_id);

ALTER TABLE book
ADD CONSTRAINT fk_book_editor 
FOREIGN KEY (editor_id) REFERENCES editor(editor_id);

ALTER TABLE book
ADD CONSTRAINT fk_book_genre 
FOREIGN KEY (genre_id) REFERENCES genre(genre_id);

ALTER TABLE useraccount
ADD CONSTRAINT u_useraccount_email 
UNIQUE (useraccount_email);

ALTER TABLE receipt
ADD CONSTRAINT fk_receipt_useraccount FOREIGN KEY (useraccount_id) REFERENCES useraccount(useraccount_id);

ALTER TABLE in_order
ADD CONSTRAINT pk_inorder PRIMARY KEY (receipt_id, book_id);

ALTER TABLE in_order
ADD CONSTRAINT fk_inorder_receipt FOREIGN KEY (receipt_id) REFERENCES receipt(receipt_id) 
ON DELETE CASCADE;

ALTER TABLE in_order
ADD CONSTRAINT fk_inorder_book FOREIGN KEY (book_id) REFERENCES book(book_id);


-- ROUTINES

DELIMITER $$

DROP TRIGGER IF EXISTS lebrairie.before_insert_account $$
CREATE TRIGGER lebrairie.before_insert_useraccount 
BEFORE INSERT ON useraccount FOR EACH ROW
BEGIN
	SET NEW.useraccount_email = LOWER(NEW.useraccount_email);
    SET NEW.useraccount_firstname = CONCAT(UPPER(SUBSTR(NEW.useraccount_firstname, 1, 1)), LOWER(SUBSTR(NEW.useraccount_firstname, 2)));
    SET NEW.useraccount_lastname = UPPER(NEW.useraccount_lastname);
    SET NEW.useraccount_creation = NOW();
END $$

DROP TRIGGER IF EXISTS lebrairie.before_insert_inorder $$
CREATE TRIGGER lebrairie.before_insert_inorder
BEFORE INSERT ON in_order FOR EACH ROW
BEGIN
	DECLARE _book_stock INTEGER;
    
    SELECT book_stock INTO _book_stock
    FROM book
    WHERE book_id = NEW.book_id;
    
    IF _book_stock < NEW.book_quantity THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Item out of stock.';
	ELSE
		UPDATE book
        SET book_stock = _book_stock - NEW.book_quantity
        WHERE book_id = NEW.book_id;
    END IF;
END $$

DROP FUNCTION IF EXISTS lebrairie.login_user $$
CREATE FUNCTION lebrairie.login_user(__input_email VARCHAR(256), __input_hash CHAR(64)) RETURNS BOOLEAN
DETERMINISTIC MODIFIES SQL DATA
BEGIN
	DECLARE _useraccount_hash CHAR(64);
    
	SELECT useraccount_passwordhash INTO _useraccount_hash
    FROM useraccount
    WHERE useraccount_email = LOWER(__input_email);
    
    IF (_useraccount_hash IS NOT NULL AND __input_hash = _useraccount_hash) THEN
		UPDATE useraccount
        SET useraccount_lastlogin = NOW()
        WHERE useraccount_email = LOWER(__input_email);
        RETURN TRUE;
    ELSE
		RETURN FALSE;
    END IF;
END $$

DELIMITER ;
