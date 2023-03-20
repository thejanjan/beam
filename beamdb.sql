DROP DATABASE beamdb;
CREATE DATABASE IF NOT EXISTS beamdb;
USE beamdb;

CREATE TABLE user(
	username VARCHAR(20) NOT NULL,
	avatar_url VARCHAR(200) DEFAULT NULL,
	timestamp TIME NOT NULL,

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
  image VARCHAR(200),

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

INSERT INTO game (name, description, releasedate, cost, publisher, developer, website, image) VALUES
("Birch Forest", "Find the village doctor to experience a live root canal in this thrilling dental experience!!", "2023-03-13", "40.00", "Jehovah's Witness", "r0adrunner", "www.google.com", "https://cdn.discordapp.com/attachments/204434027774476288/1087195375514955867/ricky_-_Micah_Nichols.png"),
    ("Blunky's Boing", "Follow along with Blunky and Co as they find out the true meaning of friendship and Boingy. Fun!", "2023-06-15", "25.00", "bethesda", "Fidel castro", "iloveyoulikeafatladylovesapples.com", "https://cdn.discordapp.com/attachments/204434027774476288/1087195375116484618/PXL_20230319_020943927_-_Sketched.jpg"),
    ("Wizard Growth", "In this game, you will be the master of exploiting the sales market! With your magical prowess, you sell growth serum to aspiring wizards, but make sure to not put your ingredients on the label! ", "2026-09-16", "23.45", "Riot Games ", "Sketched", "www.magicalgrowth.com ", "https://cdn.discordapp.com/attachments/204434027774476288/1087195374860652575/Potions_-_Trip.png"),
    ("Sneakerhead Sim", "Grow your own sneaker business from the ground up in the cutthroat design industry! Take the first step to global footwear domination in this realistic management simulator.", "2024-04-02", "24.95", "CONSUMERSOFTPRODUCTS", "Nike's Brother, Mike", "https://neko.gay/", "https://cdn.discordapp.com/attachments/204434027774476288/1087195374533488700/image0-4_-_Sayori_Argyle.jpg"),
    ("Ibuprofen Simulator", "Ever wanted to feel what it's like to take ibuprofen? Congrats, now you can! Ibuprofen Simulator simulates what it's like to take ibuprofen! Now including VR support <3", "2023-04-20", "0.01", "EA", "Corporate Clash Crew", "https://corporateclash.net/play", "https://cdn.discordapp.com/attachments/204434027774476288/1087195373556203601/chip_ibuprofen_-_Autumn_Rivers.jpg"),
    ("When Lemons Attack", "The world around you is riddled with werewolves, hunters, angels, and a container of lemon scented wet wipes. It is up to you to change your fate, lest you succumb to the creatures around you.", "2023-06-21", "3.99", "Pray On Spaghetti", "Jack Geoff", "furrygamesandwipes.uwu", "https://cdn.discordapp.com/attachments/204434027774476288/1087195374327955516/E1991BFA-4C17-4891-AA18-552A7699F743_-_Lormen.jpeg"),
    ("Hot Hot Slug Mama", "In this ADULT game you'll meet tons of SLIMY GOOBERS ready to SLOB all over you. Get ready for WILD SLUG ACTION like you've never seen before!", "2036-08-14", "7.49", "Snailmail LLC", "A really smart slug", "https://www.bugzuk.com/store/snails-slugs", "https://cdn.discordapp.com/attachments/204434027774476288/1087195359543033866/Screenshot_20230319_163406_Google_-_Sayori_Argyle.png"),
    ("Super Corn Gremlin 2", "Play the long awaited sequel to Super Corn Gremlin now! With more unique puzzles, platforming challenges, and corn-toon violence! Powered by Unity.", "2023-07-07", "0.00", "Corn Studios", "Carly Rae Goldsmith", "https://cornhub.website/", "https://cdn.discordapp.com/attachments/204434027774476288/1087195373908537444/Corn_boi_Clear_Background_-_Edan_Kasan.png"),
    ("Cougar Mountain DX!", "The classic platformer has been ported to PC! Play as Bumpy, a 22-year old beaver caught in the allure of Cougar Mountain... you must jump, spin, and delve your way to the heart of this conspiracy!", "2018-06-09", "14.99", "Chucklefish", "BearWare Studios", "cougarmountain.net", "https://cdn.discordapp.com/attachments/204434027774476288/1087195374109872228/cougar_mountain_dx_-_huckleton.png"),
    ("Blue Moon", "With the help of the local inhabitants, build a ladder and discover the mysteries of the hypnotic blue moon that polarizes an isolated village.", "2023-08-30", "19.15", "Arc System Works", "Frankie Sinatra", "www.luna0000FF.com", "https://cdn.discordapp.com/attachments/204434027774476288/1087195373057093672/70cb48a4bbf5dda5a2220e38841826c5_-_Atlas.jpg"),
    ("ARCADIA", "Join Janje and her friends on an 8-bit adventure of a lifetime! Protect the kingdom of Archa from demons, and bring peace to the land. You might even make some unexpected friends along the way!", "2025-03-29", "19.99", "Keeby inc.", "Keeby (no inc.)", "https://kirby.nintendo.com/", "https://cdn.discordapp.com/attachments/204434027774476288/1087195373308760164/ARCADIA_-_mar.png");