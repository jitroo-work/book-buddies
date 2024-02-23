SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS author(
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS book (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(255),
	isbn VARCHAR(255),
	image_name VARCHAR(255),
	price DOUBLE,
	description VARCHAR(500),
	author_id INT(6) UNSIGNED,
	FOREIGN KEY (author_id) REFERENCES author(id)
);

CREATE TABLE `users` (
  `id` int(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `users`
  ADD UNIQUE KEY `username` (`username`);

-- INSERT INTO `users` (`first_name`, `middle_name`, `last_name`, `email`, `username`, `password`) VALUES
-- ('', '', '', '','', '');


INSERT INTO author(name) VALUES ("Mitch Albom");
INSERT INTO book (title, isbn, image_name, price, description, author_id)
	VALUES ("The Five People You Meet in Heaven","9781401308582","book1.jpg",603,
		"Eddie is a wounded war veteran, an old man who has lived, in his mind,
		an uninspired life. His job is fixing rides at a seaside amusement park.
		On his 83rd birthday, a tragic accident kills him, as he tries to save a
		little girl from a falling cart. He awakes in the afterlife, where he learns
		that heaven is not a destination.",
		1);
INSERT INTO book (title, isbn, image_name, price, description, author_id)
	VALUES ("The Next Person You Meet in Heaven","0062294458","book2.jpg",532,
		"In this enchanting sequel to the number one bestseller The Five People
		You Meet in Heaven, Mitch Albom tells the story of Eddie’s heavenly
		reunion with Annie—the little girl he saved on earth—in an unforgettable
		novel of how our lives and losses intersect.",
		1);
INSERT INTO book (title, isbn, image_name, price, description, author_id)
	VALUES ("The Time Keeper","0316311537","book3.jpg",360,
		"In Mitch Albom's exceptional work of fiction, the inventor of the world's
		first clock is punished for trying to measure God's greatest gift.
		He is banished to a cave for centuries and forced to listen to the voices
		of all who come after him seeking more days, more years.",
		1);

INSERT INTO author(name) VALUES ("Nicholas Sparks");
INSERT INTO book (title, isbn, image_name, price, description, author_id)
	VALUES ("The Notebook","1455558028","book4.jpg",386,
		"Every so often a love story so captures our hearts that it becomes
		more than a story -- it becomes an experience to remember forever.
		The Notebook is such a book. It is a celebration of how passion can
		be ageless and timeless, a tale that moves us to laughter and tears and
		makes us believe in true love all over again.",
		2);

INSERT INTO book (title, isbn, image_name, price, description, author_id)
	VALUES ("The Best of Me","9780446547635","book5.jpg",351,
		"In this #1 New York Times bestselling novel of first love and second chances,
		former high school sweethearts confront the painful truths of their past to
		build a promising future—together.",
		2);

INSERT INTO book (title, isbn, image_name, price, description, author_id)
	VALUES ("A Walk to Remember","0446608955","book6.jpg",294,
		"A high school rebel and a minister's daughter find strength in each other
		in this star-crossed tale of 'young but everlasting love'",
		2);
