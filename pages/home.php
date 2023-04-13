<?php
    // query DB

      $result = exec_sql_query(
        $db,
        "SELECT albums.id AS 'albums.id', albums.artist AS 'albums.artist', albums.year AS 'albums.year', tags.genre AS 'tags.genre'

        FROM album_tags INNER JOIN albums ON (album_tags.album_id = albums.id)
        INNER JOIN tags ON (album_tags.tags_id = tags.id);"
      );
      $records = $result->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Album Media Catalog</title>
</head>

<body>
  <h3>Album Cover Catalog</h3>



<ul>
      <?php foreach ($records as $record) { ?>
        <li class="entry">
          <div class="entry-header">
            <h3><?php echo htmlspecialchars($record['albums.name']); ?></h3>
            <!-- <picture>
              <img src="../public/uploads/placeholder.jpeg" alt="placeholder">
            </picture> -->
            <form class="edit center-flex" method="get" action="/details">
                <input type = "hidden" name = "record" value = "<?php echo htmlspecialchars($record['albums.id']); ?>">
                <button class="center-flex" type="submit" aria-label="update <?php echo htmlspecialchars($record['albums.name']); ?> " title="Details for <?php echo htmlspecialchars($record['albums.name']); ?> grade">
                  <img src="../public/uploads/placeholder.jpeg" alt="placeholder" />
                </button>
           </form>
            <div class="entry-tags-genre">
              <?php echo htmlspecialchars($record['tags.genre']); ?>
            </div>
          </div>
          <p class="entry-albums-artist"><?php echo htmlspecialchars($record['albums.artist']); ?></p>
        </li>
      <?php } ?>
    </ul>


</body>

</html>
