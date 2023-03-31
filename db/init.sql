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
    (1, 'Free time', 'Ruel', 2019);

INSERT INTO
    albums(id, name, artist, year)
VALUES
    (2, '25', 'Adele', 2015);

INSERT INTO
    albums(id, name, artist, year)
VALUES
    (1, '21', 'Adele', 2011);

INSERT INTO
    albums(id, name, artist, year)
VALUES
    (2, '30', 'Adele', 2021);

INSERT INTO
    albums(id, name, artist, year)
VALUES
    (1, '19', 'Adele', 2008);

INSERT INTO
    albums(id, name, artist, year)
VALUES
    (2, 'Narrated for You', 'Alec Benjamin', 2018);

INSERT INTO
    albums(id, name, artist, year)
VALUES
    (2, 'Thank you Next', 'Ariana Grande', 2019);

INSERT INTO
    albums(id, name, artist, year)
VALUES
    (2, 'Lowlife Princess: Noir', 'BiBi', 2022);

INSERT INTO
    albums(id, name, artist, year)
VALUES
    (2, 'When we all fall asleep, where do we go?', 'Billie Eilish', 2019);

INSERT INTO
    albums(id, name, artist, year)
VALUES
    (2, '24k', 'Bruno Mars', 2016);

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
VALUES (2, 2, 2);


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
