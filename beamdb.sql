DROP DATABASE beamdb;
CREATE DATABASE IF NOT EXISTS beamdb;
USE beamdb;

CREATE TABLE user(
	username VARCHAR(20) NOT NULL,
	avatar_url VARCHAR(80) DEFAULT NULL,
	timestamp DATE,

	PRIMARY KEY(username)
);

CREATE TABLE friendstatus(
  user_a VARCHAR(20),
  user_b VARCHAR(20),
  status ENUM("request", "yes", "no", "block"),

  FOREIGN KEY(user_a) REFERENCES user(username),
  FOREIGN KEY(user_b) REFERENCES user(username)
);

CREATE TABLE privatemessage(
	message_id INT AUTO_INCREMENT,
  sender VARCHAR(20),
  receiver VARCHAR(20),

  PRIMARY KEY(message_id),
  FOREIGN KEY(sender) REFERENCES user(username),
  FOREIGN KEY(receiver) REFERENCES user(username)
);

CREATE TABLE game(
  game_id INT AUTO_INCREMENT,
  name VARCHAR(20),
  description VARCHAR(200),
  releasedate DATE,
  cost DECIMAL(8, 2),
  publisher VARCHAR(20),
  developer VARCHAR(20),
  website VARCHAR(50),
  image VARCHAR(80),

  PRIMARY KEY(game_id)
);

CREATE TABLE review(
	review_id INT AUTO_INCREMENT,
	game_id INT,
	username VARCHAR(20),
	rating INT,
	description VARCHAR(2000),

	PRIMARY KEY(review_id),
	FOREIGN KEY(game_id) REFERENCES game(game_id),
	FOREIGN KEY(username) REFERENCES user(username)
);

CREATE TABLE reviewrating(
	review_id INT,
	rater_name VARCHAR(20),
	rating ENUM("funny", "true", "tragic"),

	FOREIGN KEY(review_id) REFERENCES review(review_id),
	FOREIGN KEY(rater_name) REFERENCES user(username)
);

CREATE TABLE topic(
	topic_id INT AUTO_INCREMENT,
	game_id INT,
	username VARCHAR(20),
	topic_name VARCHAR(20),
	timestamp DATE,

	PRIMARY KEY(topic_id),
	FOREIGN KEY(game_id) REFERENCES game(game_id),
	FOREIGN KEY(username) REFERENCES user(username)
);

CREATE TABLE post(
	topic_id INT,
	username VARCHAR(20),
	message VARCHAR(200),
	timestamp DATE,

	PRIMARY KEY(topic_id),
	FOREIGN KEY(username) REFERENCES user(username)
);
