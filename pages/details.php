<?php
$title = ': More Details';
      // if we have a GET request, then show the user the form
      // get the record id for the grade
      $get_id = ($_GET['record'] == '' ? NULL : (int)$_GET['record']); // untrusted

      // What record are we looking at?
      $record_id = $get_id;

      // Get the record using the `id` from the DB.
      $record = NULL;
      if ($record_id != NULL) {
        $records = exec_sql_query(
          $db,
          "SELECT albums.id AS 'albums.id', albums.name AS 'albums.name',albums.artist AS 'albums.artist', albums.year AS 'albums.year', tags.genre1 AS 'tags.genre1', tags.genre2 AS 'tags.genre2'

          FROM album_tags JOIN tags ON (album_tags.tags_id = tags.id)
          JOIN albums ON (album_tags.album_id = albums.id) WHERE (album_id = :id);",

          array(
            ':id' => $get_id
          )
        )->fetchAll();

        // Did we find the record?
        if (count($records) > 0) {
          $record = $records[0]; // first record
        }
      }

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?php echo $title; ?></title>

  <link rel="stylesheet" type="text/css" href="/public/styles/site.css" media="all">
</head>

<body>
<?php include 'includes/header.php'; ?>
  <main class="details">


  <?php if ($record == null) { ?>

      <p>No album found. Return to the <a href="/">album display</a>.</p>

  <?php } else { ?>

      <tr>
            <td>
              <?php
              $albums_result = exec_sql_query(
                $db,
                "SELECT albums.name AS 'albums.name', albums.id AS 'albums.id', albums.artist AS 'albums.artist', albums.year AS 'albums.year', tags.genre1 AS 'tags.genre1', tags.genre2 AS 'tags.genre2'
                FROM album_tags INNER JOIN albums ON (album_tags.album_id = albums.id)
                INNER JOIN tags ON (album_tags.tags_id = tags.id)
                WHERE tags.genre1 = :tag OR tags.genre2 = :tag;",
                array(':tag' => $tag)

              );

              $albums_records = $albums_result->fetchAll()[0];
              ?>
            </td>

    <div class = "text">
      <h3> Albums Details about <?php echo htmlspecialchars($record['albums.name']); ?> </h3>

      <p>Album Name: <?php echo htmlspecialchars($record['albums.name']); ?></p>

      <p>Album Artist: <?php echo htmlspecialchars($record['albums.artist']); ?></p>

      <p>Album Genre: <?php echo htmlspecialchars($record['tags.genre1']); ?>   <?php echo htmlspecialchars($record['tags.genre2']); ?></p>

      <p>Year Released: <?php echo htmlspecialchars($record['albums.year']); ?><p>
    </div>





      <?php
          // Only show the clipart gallery if we have records to display.
        if (count($records) > 0) { ?>
        <ul>
          <?php foreach ($records as $record) {
            $img_url = '/public/uploads/albums/' . $record_id . '.png';
            ?>

                    <img src="<?php echo htmlspecialchars($img_url); ?>" alt="<?php echo htmlspecialchars($record['albums.name']); ?>">
                    <!-- </button> -->
              </form>
                <!-- <div class="entry-tags-genre">
                  <?php echo htmlspecialchars($record['tags.genre']); ?>
                </div>
              </div>
              <p class="entry-albums-artist"><?php echo htmlspecialchars($record['albums.artist']); ?></p> -->
              <?php
              } ?>
            </ul>
            <?php
          } else { ?>
            <p>Your album cover selection is <em>empty</em>. Try uploading some album covers.</p>
          <?php } ?>

          <p>Return to the full <a href="/">album display</a>.</p>
        </section>
    </main>
    </div>

      <?php } ?>



  </main>
</body>

</html>
