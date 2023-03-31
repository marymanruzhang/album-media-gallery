<?php
    // query DB
      $result = exec_sql_query(
        $db,
        "SELECT albums.name AS 'albums.name', tags.genre AS 'tags.genre'

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
            <picture>
              <img src="../public/uploads/placeholder.jpeg" alt="placeholder">
            </picture>
            <div class="entry-album-tags">
              <?php echo htmlspecialchars($record['album_tag.genre']); ?>
            </div>
          </div>
          <p class="entry-genre-tags"><?php echo htmlspecialchars($record['tags.artist']); ?></p>
        </li>
      <?php } ?>
    </ul>


</body>

</html>
