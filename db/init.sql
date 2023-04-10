-- Albums --
CREATE TABLE albums (
    id INTEGER NOT NULL UNIQUE,
    name TEXT NOT NULL,
    artist TEXT NOT NULL,
    year INTEGER NOT NULL,
    PRIMARY KEY(id AUTOINCREMENT)
);

INSERT INTO
    albums(id, name, artist, year)
VALUES
    (1, 'Purpose', 'Taeyeon', 2019);

INSERT INTO
    albums(id, name, artist, year)
VALUES
    (2, 'Young and Beautiful', 'Lana Del Rey', 2013);

INSERT INTO
    albums(id, name, artist, year)
VALUES
    (3, 'Free time', 'Ruel', 2019);

INSERT INTO
    albums(id, name, artist, year)
VALUES
    (4, '25', 'Adele', 2015);

INSERT INTO
    albums(id, name, artist, year)
VALUES
    (5, '21', 'Adele', 2011);

INSERT INTO
    albums(id, name, artist, year)
VALUES
    (6, '30', 'Adele', 2021);

INSERT INTO
    albums(id, name, artist, year)
VALUES
    (7, '19', 'Adele', 2008);

INSERT INTO
    albums(id, name, artist, year)
VALUES
    (8, 'Narrated for You', 'Alec Benjamin', 2018);

INSERT INTO
    albums(id, name, artist, year)
VALUES
    (9, 'Thank you Next', 'Ariana Grande', 2019);

INSERT INTO
    albums(id, name, artist, year)
VALUES
    (10, 'Lowlife Princess: Noir', 'BiBi', 2022);

INSERT INTO
    albums(id, name, artist, year)
VALUES
    (11, 'When we all fall asleep, where do we go?', 'Billie Eilish', 2019);

INSERT INTO
    albums(id, name, artist, year)
VALUES
    (12, '24k', 'Bruno Mars', 2016);

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
INSERT INTO
    album_tags (id, album_id, tags_id)
VALUES
    (6, 6, 6);
INSERT INTO
    album_tags (id, album_id, tags_id)
VALUES
    (7, 7, 7);
INSERT INTO
    album_tags (id, album_id, tags_id)
VALUES
    (8, 8, 8);
INSERT INTO
    album_tags (id, album_id, tags_id)
VALUES
    (9, 9, 9);
INSERT INTO
    album_tags (id, album_id, tags_id)
VALUES
    (10, 10, 10);

-- Genre tags (all the different genres) --
CREATE TABLE tags (
    id INTEGER NOT NULL UNIQUE,
    genre TEXT NOT NULL,
    PRIMARY KEY(id AUTOINCREMENT)
);

INSERT INTO
    tags (id, genre)
VALUES
    (1, 'Rock');

INSERT INTO
    tags (id, genre)
VALUES
    (2, 'Pop');

INSERT INTO
    tags (id, genre)
VALUES
    (3, 'Hip Hop');

INSERT INTO
    tags (id, genre)
VALUES
    (4, 'RnB');

INSERT INTO
    tags (id, genre)
VALUES
    (5, 'K-Ballad');

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
