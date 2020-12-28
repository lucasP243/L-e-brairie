-- INIT SCRIPT - LEBRAIRIE
-- AUTHOR : Lucas Pinard

USE lebrairie;

INSERT INTO genre (genre_name)
VALUES
	('Roman'),
    ('Théâtre'),
    ('Poésie'),
    ('Manga')
;

INSERT INTO author (author_name)
VALUES
	('Pierre Boule'),
    ('Maxime Chattam'),
    ('Fiodor Dostoïevski'),
    ('Sarah Lotz'),
    ('Charles Baudelaire'),
    ('Louis Aragon'),
    ('Victor Hugo'),
    ('William Shakespeare'),
    ('Molière'),
    ('Alfred de Musset'),
    ('Pierre Corneille'),
    ('Hirohiko Araki'),
    ('CLAMP'),
    ('Jun Mochizuki'),
    ('Naomura Toru'),
    ('Matsuri Hino')
;

INSERT INTO editor (editor_name)
VALUES
	('Pocket'),
    ('Le Livre de Poche'),
    ('Larousse'),
    ('Gallimard'),
    ('Librio'),
    ('Étonnants Classiques'),
    ('Jump Comics'),
    ('Pika'),
    ('Ki-oon'),
    ('Soleil Manga'), 
    ('Panini Manga')
;

INSERT INTO book (book_title, book_cover, book_price, book_stock, author_id, editor_id, genre_id)
VALUES
(
	'La planète des singes', 'la-planete-des-singes', 5.99, 5, 
	(SELECT author_id FROM author WHERE author_name = 'Pierre Boule'), 
	(SELECT editor_id FROM editor WHERE editor_name = 'Pocket'), 
	(SELECT genre_id FROM genre WHERE genre_name = 'Roman')
),
(
	'Léviatemps', 'leviatemps', 8.70, 5, 
	(SELECT author_id FROM author WHERE author_name = 'Maxime Chattam'), 
	(SELECT editor_id FROM editor WHERE editor_name = 'Pocket'), 
	(SELECT genre_id FROM genre WHERE genre_name = 'Roman')
),
(
	'Que ta volonté soit faite', 'que-ta-volonte-soit-faite', 7.60, 5,
	(SELECT author_id FROM author WHERE author_name = 'Maxime Chattam'), 
	(SELECT editor_id FROM editor WHERE editor_name = 'Pocket'), 
	(SELECT genre_id FROM genre WHERE genre_name = 'Roman')
),
(
	'Crime et Châtiment', 'crime-et-chatiment', 7.60, 5,
	(SELECT author_id FROM author WHERE author_name = 'Fiodor Dostoïevski'), 
	(SELECT editor_id FROM editor WHERE editor_name = 'Le Livre de Poche'), 
	(SELECT genre_id FROM genre WHERE genre_name = 'Roman')
),
(
	'Trois', 'trois', 8.20, 5,
	(SELECT author_id FROM author WHERE author_name = 'Sarah Lotz'), 
	(SELECT editor_id FROM editor WHERE editor_name = 'Pocket'), 
	(SELECT genre_id FROM genre WHERE genre_name = 'Roman')
),
(
	'Les Fleurs du Mal', 'les-fleurs-du-mal', 3.50, 5,
	(SELECT author_id FROM author WHERE author_name = 'Charles Baudelaire'), 
	(SELECT editor_id FROM editor WHERE editor_name = 'Larousse'), 
	(SELECT genre_id FROM genre WHERE genre_name = 'Poésie')
),
(
	'Elsa', 'elsa', 6.50, 5,
	(SELECT author_id FROM author WHERE author_name = 'Louis Aragon'), 
	(SELECT editor_id FROM editor WHERE editor_name = 'Gallimard'), 
	(SELECT genre_id FROM genre WHERE genre_name = 'Poésie')
),
(
	'Les Contemplations', 'les-contemplations', 11.30, 5,
	(SELECT author_id FROM author WHERE author_name = 'Victor Hugo'), 
	(SELECT editor_id FROM editor WHERE editor_name = 'Gallimard'), 
	(SELECT genre_id FROM genre WHERE genre_name = 'Poésie')
),
(
	'Hamlet', 'hamlet', 2.00, 5,
	(SELECT author_id FROM author WHERE author_name = 'William Shakespeare'), 
	(SELECT editor_id FROM editor WHERE editor_name = 'Librio'), 
	(SELECT genre_id FROM genre WHERE genre_name = 'Théâtre')
),
(
	'Les Fourberies de Scapin', 'les-fourberies-de-scapin', 3.00, 5,
	(SELECT author_id FROM author WHERE author_name = 'Molière'), 
	(SELECT editor_id FROM editor WHERE editor_name = 'Larousse'), 
	(SELECT genre_id FROM genre WHERE genre_name = 'Théâtre')
),
(
	'Le Misanthrope', 'le-misanthrope', 3.05, 5,
	(SELECT author_id FROM author WHERE author_name = 'Molière'), 
	(SELECT editor_id FROM editor WHERE editor_name = 'Étonnants Classiques'), 
	(SELECT genre_id FROM genre WHERE genre_name = 'Théâtre')
),
(
	'On ne badine pas avec l\'amour', 'on-ne-badine-pas-avec-l-amour', 1.55, 5,
	(SELECT author_id FROM author WHERE author_name = 'Alfred de Musset'), 
	(SELECT editor_id FROM editor WHERE editor_name = 'Pocket'), 
	(SELECT genre_id FROM genre WHERE genre_name = 'Théâtre')
),
(
	'Le Cid', 'le-cid', 1.50, 5,
	(SELECT author_id FROM author WHERE author_name = 'Pierre Corneille'), 
	(SELECT editor_id FROM editor WHERE editor_name = 'Pocket'), 
	(SELECT genre_id FROM genre WHERE genre_name = 'Théâtre')
),
(
	'JoJo\'s Bizarre Adventure : Steel Ball Run - Tome 11', 'jojo-s-bizarre-adventure-steel-ball-run-11', 6.99, 5,
	(SELECT author_id FROM author WHERE author_name = 'Hirohiko Araki'), 
	(SELECT editor_id FROM editor WHERE editor_name = 'Jump Comics'), 
	(SELECT genre_id FROM genre WHERE genre_name = 'Manga')
),
(
	'Tsubasa RESERVoir CHRoNiCLE - Tome 17', 'tsubasa-reservoir-chronicle-17', 6.95, 5,
	(SELECT author_id FROM author WHERE author_name = 'CLAMP'), 
	(SELECT editor_id FROM editor WHERE editor_name = 'Pika'), 
	(SELECT genre_id FROM genre WHERE genre_name = 'Manga')
),
(
	'Pandora Hearts - Tome 12', 'pandora-hearts-12', 7.65, 5,
	(SELECT author_id FROM author WHERE author_name = 'Jun Mochizuki'), 
	(SELECT editor_id FROM editor WHERE editor_name = 'Ki-oon'), 
	(SELECT genre_id FROM genre WHERE genre_name = 'Manga')
),
(
	'Gambling School - Tome 3', 'gambling-school-3', 7.99, 5,
	(SELECT author_id FROM author WHERE author_name = 'Naomura Toru'), 
	(SELECT editor_id FROM editor WHERE editor_name = 'Soleil Manga'), 
	(SELECT genre_id FROM genre WHERE genre_name = 'Manga')
),
(
	'Vampire Knight - Tome 11', 'vampire-knight-11', 6.99, 5,
	(SELECT author_id FROM author WHERE author_name = 'Matsuri Hino'), 
	(SELECT editor_id FROM editor WHERE editor_name = 'Panini Manga'), 
	(SELECT genre_id FROM genre WHERE genre_name = 'Manga')
);

INSERT INTO useraccount (useraccount_firstname, useraccount_lastname, useraccount_email, useraccount_passwordhash, useraccount_dob)
VALUES
(
	'Admini', 'Strateur',
    'admin@webmaster.fr',
    MD5('Adm1n...'),
    '1970-01-01'
);