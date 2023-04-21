-- Albums --
CREATE TABLE albums (
    id INTEGER NOT NULL UNIQUE,
    name TEXT NOT NULL,
    artist TEXT NOT NULL,
    year INTEGER NOT NULL,
    source TEXT NOT NULL,
    ext TEXT NOT  NULL,
    PRIMARY KEY(id AUTOINCREMENT)
);

INSERT INTO
    albums(id, name, artist, year, source, ext)
VALUES
    (1, 'Purpose', 'Taeyeon', 2019, 'https://en.wikipedia.org/wiki/Purpose_%28Taeyeon_album%29', 'png');

INSERT INTO
    albums(id, name, artist, year, source, ext)
VALUES
    (2, 'Young and Beautiful', 'Lana Del Rey', 2013, 'https://en.wikipedia.org/wiki/Young_and_Beautiful_%28Lana_Del_Rey_song%29#/media/File:Young_and_Beautiful_cover_art.jpg', 'png');

INSERT INTO
    albums(id, name, artist, year, source, ext)
VALUES
    (3, 'Justice', 'Justin Bieber', 2021, 'https://en.wikipedia.org/wiki/Justice_%28Justin_Bieber_album%29#/media/File:Justin_Bieber_-_Justice.png', 'png');

INSERT INTO
    albums(id, name, artist, year, source, ext)
VALUES
    (4, 'Free time', 'Ruel', 2019, 'https://en.wikipedia.org/wiki/Free_Time_%28EP%29#/media/File:Ruel_-_Free_Time.png', 'png');

INSERT INTO
    albums(id, name, artist, year, source, ext)
VALUES
    (5, 'Savage (EP)', 'Aespa', 2021, 'https://en.wikipedia.org/wiki/Savage_%28EP%29#/media/File:Aespa_%E2%80%93_Savage.jpg', 'png');



-- INSERT INTO
--     albums(id, name, artist, year)
-- VALUES
--     (6, '30', 'Adele', 2021);

-- INSERT INTO
--     albums(id, name, artist, year)
-- VALUES
--     (7, '19', 'Adele', 2008);

-- INSERT INTO
--     albums(id, name, artist, year)
-- VALUES
--     (8, 'Narrated for You', 'Alec Benjamin', 2018);

-- INSERT INTO
--     albums(id, name, artist, year)
-- VALUES
--     (9, 'Thank you Next', 'Ariana Grande', 2019);

-- INSERT INTO
--     albums(id, name, artist, year)
-- VALUES
--     (10, 'Lowlife Princess: Noir', 'BiBi', 2022);

-- INSERT INTO
--     albums(id, name, artist, year)
-- VALUES
--     (11, 'When we all fall asleep, where do we go?', 'Billie Eilish', 2019);

-- INSERT INTO
--     albums(id, name, artist, year)
-- VALUES
--     (12, '24k', 'Bruno Mars', 2016);

-- Album tags (connects types of genre with the album entry) --
CREATE TABLE album_tags (
    id INTEGER NOT NULL UNIQUE,
    album_id INTEGER NOT NULL,
    tags_id INTEGER NOT NULL,
    PRIMARY KEY(id AUTOINCREMENT) FOREIGN KEY (album_id) REFERENCES albums(id)
    FOREIGN KEY (tags_id) REFERENCES tags(id)
);

INSERT INTO
    album_tags (id, album_id, tags_id)
VALUES
    (1, 1, 1);

INSERT INTO
    album_tags (id, album_id, tags_id)
VALUES
    (2, 2, 2);

INSERT INTO
    album_tags (id, album_id, tags_id)
VALUES
    (3, 3, 3);

INSERT INTO
    album_tags (id, album_id, tags_id)
VALUES
    (4, 4, 4);

INSERT INTO
    album_tags (id, album_id, tags_id)
VALUES
    (5, 5, 5);

-- INSERT INTO
--     album_tags (id, album_id, tags_id)
-- VALUES
--     (6, 6, 6);
-- INSERT INTO
--     album_tags (id, album_id, tags_id)
-- VALUES
--     (7, 7, 7);
-- INSERT INTO
--     album_tags (id, album_id, tags_id)
-- VALUES
--     (8, 8, 8);
-- INSERT INTO
--     album_tags (id, album_id, tags_id)
-- VALUES
--     (9, 9, 9);
-- INSERT INTO
--     album_tags (id, album_id, tags_id)
-- VALUES
--     (10, 10, 10);

-- Genre tags (all the different genres) --
CREATE TABLE tags (
    id INTEGER NOT NULL UNIQUE,
    genre TEXT NOT NULL,
    PRIMARY KEY(id AUTOINCREMENT)
);

INSERT INTO
    tags (id, genre)
VALUES
    (1, 'K-Ballad');

INSERT INTO
    tags (id, genre)
VALUES
    (2, 'Pop');

INSERT INTO
    tags (id, genre)
VALUES
    (3, 'Pop');

INSERT INTO
    tags (id, genre)
VALUES
    (4, 'Pop');

INSERT INTO
    tags (id, genre)
VALUES
    (5, 'K-Pop');

INSERT INTO
    tags (id, genre)
VALUES
    (6, 'K-pop');

INSERT INTO
    tags (id, genre)
VALUES
    (7, 'Alternative Pop');

INSERT INTO
    tags (id, genre)
VALUES
    (8, 'Alternative Pop');

INSERT INTO
    tags (id, genre)
VALUES
    (9, 'Alternative Pop');

INSERT INTO
    tags (id, genre)
VALUES
    (10, 'Alternative Pop');


--- Users ---
CREATE TABLE users (
  id INTEGER NOT NULL UNIQUE,
  name TEXT NOT NULL,
  email TEXT NOT NULL,
  username TEXT NOT NULL UNIQUE,
  password TEXT NOT NULL,
  PRIMARY KEY(id AUTOINCREMENT)
);

-- password: monkey
INSERT INTO
  users (id, name, email, username, password)
VALUES
  (
    1,
    'Kyle Harms',
    'kyle.harms@cornell.edu',
    'kyle',
    '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.' -- monkey
  );

-- password: monkey
INSERT INTO
  users (id, name, email, username, password)
VALUES
  (
    2,
    'Sharon Jeong',
    'sharon@example.com',
    'sharon',
    '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.' -- monkey
  );

--- Sessions ---
CREATE TABLE sessions (
  id INTEGER NOT NULL UNIQUE,
  user_id INTEGER NOT NULL,
  session TEXT NOT NULL UNIQUE,
  last_login TEXT NOT NULL,
  PRIMARY KEY(id AUTOINCREMENT) FOREIGN KEY(user_id) REFERENCES users(id)
);

--- Groups ----
CREATE TABLE groups (
  id INTEGER NOT NULL UNIQUE,
  name TEXT NOT NULL UNIQUE,
  PRIMARY KEY(id AUTOINCREMENT)
);

INSERT INTO
  groups (id, name)
VALUES
  (1, 'admin');

--- Group Membership ---
CREATE TABLE user_groups (
  id INTEGER NOT NULL UNIQUE,
  user_id INTEGER NOT NULL,
  group_id INTEGER NOT NULL,
  PRIMARY KEY(id AUTOINCREMENT) FOREIGN KEY(group_id) REFERENCES groups(id),
  FOREIGN KEY(user_id) REFERENCES users(id)
);

-- User 'kyle' is a member of the 'admin' group.
INSERT INTO
  user_groups (user_id, group_id)
VALUES
  (1, 1);
