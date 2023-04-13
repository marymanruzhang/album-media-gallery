<?php
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
          "SELECT albums.id AS 'albums.id', albums.artist AS 'albums.artist', albums.year AS 'albums.year', tags.genre AS 'tags.genre'

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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link rel="stylesheet" type="text/css" href="/public/styles/site.css" media="all">

  <title>Album Media Catalog</title>
</head>

<body>
  <h3>Details</h3>

  <main class="details">

  <?php if ($record == null) { ?>

      <p>No record found. Return to the <a href="/">album display</a>.</p>

  <?php } else { ?>

      <tr>
            <td>
              <?php
              // $courses_result = exec_sql_query(
              //   $db,
              //   "SELECT * FROM albums WHERE (id = :id);",
              //   array(
              //     ':id' => $get_id
              //   )
              // );
              $albums_result = exec_sql_query(
                $db,
                "SELECT albums.id AS 'albums.id', albums.artist AS 'albums.artist', albums.year AS 'albums.year', tags.genre AS 'tags.genre'

                FROM album_tags JOIN tags ON (album_tags.tags_id = tags.id)
                JOIN albums ON (album_tags.album_id = albums.id) WHERE (album_id = :id);",

                array(
                  ':id' => $get_id
                )
              );

              $albums_records = $albums_result->fetchAll()[0];


              // echo htmlspecialchars($record['album_tags.album_id']);
              ?>
            </td>
            <td>
              <?php echo htmlspecialchars($record['albums.name']); ?>
            </td>
            <td>
              <?php echo htmlspecialchars($record['tags.genre']); ?>
            </td>
            <td>
              <?php echo htmlspecialchars($record['albums.year']); ?>
            </td>
            <td>
              <?php echo htmlspecialchars($record['albums.artist']); ?>
            </td>
      </tr>

      <p>(<?php echo htmlspecialchars($record_id); ?>).</p>

      <p></p>

      <p>Return to the <a href="/">album display</a>.


      <?php } ?>



  </main>
</body>

</html>
