<?php
  // check if a tag filter button is clicked
  if (isset($_GET['tag'])) {
    $tag = $_GET['tag'];
    $result = exec_sql_query(
      $db,
      "SELECT albums.name AS 'albums.name', albums.id AS 'albums.id', albums.artist AS 'albums.artist', albums.year AS 'albums.year', tags.genre AS 'tags.genre'
      FROM album_tags INNER JOIN albums ON (album_tags.album_id = albums.id)
      INNER JOIN tags ON (album_tags.tags_id = tags.id)
      WHERE tags.genre = :tag;",
      array(':tag' => $tag)
    );
  } else {
    $result = exec_sql_query(
      $db,
      "SELECT albums.name AS 'albums.name', albums.id AS 'albums.id', albums.artist AS 'albums.artist', albums.year AS 'albums.year', tags.genre AS 'tags.genre'
      FROM album_tags INNER JOIN albums ON (album_tags.album_id = albums.id)
      INNER JOIN tags ON (album_tags.tags_id = tags.id);"
    );
  }
  $records = $result->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?php echo $title; ?> - INFO 2300</title>

  <link rel="stylesheet" type="text/css" href="/public/styles/site.css" media="all">
</head>

<body>
  <?php include 'includes/header.php'; ?>
  <div class="spacer">
  </div>
  <h1>Albums by Genre</h1>

  <!-- display genre filter buttons -->
  <div>
    <?php
      $tags = exec_sql_query($db, "SELECT DISTINCT genre FROM tags")->fetchAll(PDO::FETCH_COLUMN);
      foreach ($tags as $tag) {
        echo "<a href='?tag=".htmlspecialchars($tag)."'>".htmlspecialchars($tag)."</a> ";
      }
    ?>
  </div>

  <main class = "entry">
    <section class = "gallery">
      <?php
          // Only show the clipart gallery if we have records to display.
        if (count($records) > 0) { ?>
        <ul>
          <?php foreach ($records as $record) {
            $img_url = '/public/uploads/covers/' . $record['albums.id'] . '.png';
            ?>
            <li>
                <h3><?php echo htmlspecialchars($record['albums.name']); ?></h3>
                <!-- <picture>
                  <img src="../public/uploads/placeholder.jpeg" alt="placeholder">
                </picture> -->
                <form class="entry-form" method="get" action="/details">
                <input type = "hidden" name = "record" value = "<?php echo htmlspecialchars($record['albums.id']); ?>">
                    <button class="thumbnail" type="submit" aria-label="update <?php echo htmlspecialchars($record['albums.name']); ?> " title ="Details for <?php echo htmlspecialchars($record['albums.name']); ?>">
                    <!-- image -->
                    <div class="thumbnail" type="submit" aria-label="update <?php echo htmlspecialchars($record['albums.name']); ?> " title ="Details for <?php echo htmlspecialchars($record['albums.name']); ?>">
                    <img src="<?php echo htmlspecialchars($img_url); ?>" alt="<?php echo htmlspecialchars($record['albums.name']); ?>">
                    </div>
                    <!-- </button> -->
              </form>
                <div class="entry-tags-genre">
                  <?php echo htmlspecialchars($record['tags.genre']); ?>
                </div>
              </div>
              <p class="entry-albums-artist"><?php echo htmlspecialchars($record['albums.artist']); ?></p>
              </li>
              <?php
              } ?>
            </ul>
            <?php
          } else { ?>
            <p>Your album cover selection is <em>empty</em>. Try uploading some album covers.</p>
          <?php } ?>
        </section>
    </main>
</body>
</html>
