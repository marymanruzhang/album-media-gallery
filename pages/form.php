<?php
$title = 'Album Cover Upload Form';
$nav_plopbox_class = 'active_page';

// Access Control - Only logged in users may upload
if (is_user_logged_in()) {

  // Set maximum file size for uploaded files.
  // MAX_FILE_SIZE must be set to bytes
  // 1 MB = 1000000 bytes
  define("MAX_FILE_SIZE", 1000000);

  $upload_feedback = array(
    'general_error' => False,
    'too_large' => False
  );

  // upload fields
  $upload_albums_source = NULL;
  $upload_albums_ext = NULL;
  $upload_albums_name = NULL;
  $upload_albums_artist = NULL;
  $upload_albums_year = NULL;
  $upload_tags_genre = NULL;

  // Users must be logged in to upload files!
  if (isset($_POST["upload"])) {

    $upload_albums_source = trim($_POST['source']); // untrusted
    if (empty($upload_albums_source)) {
      $upload_albums_source = NULL;
    }

    // get the info about the uploaded files.
    $upload = $_FILES['file'];

    // Assume the form is valid...
    $form_valid = True;

    // file is required
    if ($upload['error'] == UPLOAD_ERR_OK) {
      // The upload was successful!

      // Get the name of the uploaded file without any path
      $upload_albums_name = basename($upload['name']);
      // $upload_albums_artist = basename($upload['artist']);
      // $upload_albums_year = basename($upload['year']);
      // $upload_tags_genre = basename($upload['genre']);

      // Get the file extension of the uploaded file and convert to lowercase for consistency in DB
      $upload_albums_ext = strtolower(pathinfo($upload_albums_name, PATHINFO_EXTENSION));

      // This site only accepts SVG files!
      if (!in_array($upload_albums_ext, array('png', 'jpg', 'jpeg'))) {
        $form_valid = False;
        $upload_feedback['general_error'] = True;
      }

    } else if (($upload['error'] == UPLOAD_ERR_INI_SIZE) || ($upload['error'] == UPLOAD_ERR_FORM_SIZE)) {
      // file was too big, let's try again
      $form_valid = False;
      $upload_feedback['too_large'] = True;
    } else {
      // upload was not successful
      $form_valid = False;
      $upload_feedback['general_error'] = True;
    }

    if ($form_valid) {
      // insert upload into DB
      $result = exec_sql_query(
        $db,
        "INSERT INTO albums (name, artist, year, source, ext) VALUES (:name, :artist, :year, :source, :ext);
        INSERT INTO tags (genre) VALUES (:genre);",
        array(
          ':name' => $upload_albums_name,
          ':artist' => $upload_albums_artist,
          ':year' => $upload_albums_year,
          ':source' => $upload_albums_source,
          ':ext' => $upload_albums_ext,
          ':genre' => $upload_tags_genre
        )
      );


      if ($result) {
        // We successfully inserted the record into the database, now we need to
        // move the uploaded file to it's final resting place: public/uploads directory

        // get the newly inserted record's id
        $record_id = $db->lastInsertId('id');

        // uploaded file should be in folder with same name as table with the primary key as the filename.
        // Note: THIS IS NOT A URL; this is a FILE PATH on the server!
        //       Do NOT include / at the beginning of the path; path should be a relative path.
        //          NO: /public/...
        //         YES: public/...
        $upload_storage_path = 'public/uploads/covers/' . $record_id . '.' . $upload_albums_ext;

        // Move the file to the public/uploads/clipart folder
        // Note: THIS FUNCTION REQUIRES A PATH. NOT A URL!
        if (move_uploaded_file($upload["tmp_name"], $upload_storage_path) == False) {
          error_log("Failed to permanently store the uploaded file on the file server. Please check that the server folder exists.");
        }
      }
    }
  }
}

// query the database for the album records
$result = exec_sql_query(
    $db,
    "SELECT albums.id AS 'albums.id', albums.artist AS 'albums.artist', albums.year AS 'albums.year', tags.genre AS 'tags.genre'

    FROM album_tags INNER JOIN albums ON (album_tags.album_id = albums.id)
    INNER JOIN tags ON (album_tags.tags_id = tags.id) ORDER BY name ASC;"
  );
  $records = $result->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?php echo $title; ?> Add an Album Entry</title>

  <link rel="stylesheet" type="text/css" href="/public/styles/site.css" media="all">
</head>


<body>
  <?php include 'includes/header.php'; ?>
  <main class="form">

    <section class="upload-form">
      <h2><?php echo $title; ?></h2>
    <section class="upload" id="upload">

      <?php
      // Access Controls - Interface: Only logged in users may upload
      if (is_user_logged_in()) { ?>
        <?php if(!$show_confirmation) { ?>
          <h2>Please feel free to add your album entry!</h2>

          <form action="/form" method="post" enctype="multipart/form-data">

            <!-- MAX_FILE_SIZE must precede the file input field -->

            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>">

            <?php if ($upload_feedback['too_large']) { ?>
              <p class="feedback">We're sorry. The file failed to upload because it was too big. Please select a file that&apos;s no larger than 1MB.</p>
            <?php } ?>

            <?php if ($upload_feedback['general_error']) { ?>
              <p class="feedback">We're sorry. Something went wrong. Please select an PNG file to upload.</p>
            <?php } ?>

            <div class="label-input">
              <label for="upload-file">Album Cover File:</label>
              <!-- This site only accepts PNG and JPG files! -->
              <input id="upload-file" type="file" name="file" accept=".png, .jpg, .jpeg">

            </div>

            <div class="label-input">
              <label for="upload_albums_name">Album Name:</label>
              <input id='upload_albums_name' type="text" name="source" placeholder="Name of the Album">
            </div>

            <div class="label-input">
              <label for="upload_albums_artist">Artist:</label>
              <input id='upload_albums_artist' type="text" name="artist" placeholder="Artist of the Album">
            </div>

            <div class="label-input">
              <label for="upload_albums_year">Year:</label>
              <input id='upload_albums_year' type="text" name="year" placeholder="Album Release Year">
            </div>

            <div class="label-input">
              <label for="upload_albums_source">Source URL:</label>
              <input id='upload_albums_source' type="url" name="source" placeholder="URL where cover image is found">
            </div>

            <div class="label-input">
              <label for="upload_tags_genre">Genre</label>
              <input id='upload_tags_genre' type="text" name="genre" placeholder="Genre of Album">
            </div>

          <!-- <p class="feedback <?php echo $form_feedback_classes['genre']; ?>">Please select a music genre.</p>
          <div class="form-group label-input" role="group" aria-labelledby="genre_head">
          <select name = "dropdown">
            <option value = "genre" selected><?php echo htmlspecialchars($record['tags.genre']); ?></option>
         </select> -->

            <div class="align-right">
              <button type="submit" name="upload">Upload</button>
            </div>
            </form>
          <?php } else { ?>

            <!-- Show the form or the confirmation message. -->
              <section>
                <h2>Thanks for your entry!</h2>

                <p><a href="/">Go View your Entry in our Display</a> or submit another entry <a href="/form"></p>
              </section>
          <?php } ?>

      <?php } else {
        // user is not logged in. show login form
      ?>

        <h2>Sign In</h2>

        <p>Please login to upload album covers to the Album Cover Display Series</p>

      <?php echo login_form('/form#upload', $session_messages);
      } ?>
    </section>

  </main>

</body>

</html>
