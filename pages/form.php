<?php
$title = ': Upload Form';

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
  $upload_tags_genre1 = NULL;
  $upload_tags_genre2 = NULL;
  $upload_file_name = NULL;

  // Users must be logged in to upload files!
  if (isset($_POST["upload"])) {

    $upload_albums_source = trim($_POST['source']); // untrusted
    if (empty($upload_albums_source)) {
      $upload_albums_source = NULL;
    }

    $upload_albums_artist = trim($_POST['artist']);
    if (empty($upload_albums_artist)) {
      $upload_albums_artist = NULL;
    }

    $upload_albums_year = trim($_POST['year']);
    if (empty($upload_albums_year)) {
      $upload_albums_year = NULL;
    }

    $upload_tags_genre1 = trim($_POST['genre1']);
    if (empty($upload_tags_genre1)) {
      $upload_tags_genre1 = NULL;
    }

    $upload_tags_genre2 = trim($_POST['genre2']);
    if (empty($upload_tags_genre2)) {
      $upload_tags_genre2 = NULL;
    }

    $upload_albums_name = trim($_POST['name']);
    if (empty($upload_albums_name)) {
      $upload_albums_name = NULL;
    }

    // get the info about the uploaded files.
    $upload = $_FILES['file_name'];

    // Assume the form is valid...
    $form_valid = True;

    // file is required
    if ($upload['error'] == UPLOAD_ERR_OK) {
      // The upload was successful!

      // Get the name of the uploaded file without any path
      $upload_file_name = basename($upload['name']);

      // Get the file extension of the uploaded file and convert to lowercase for consistency in DB
      $upload_albums_ext = strtolower(pathinfo($upload_file_name, PATHINFO_EXTENSION));

      // This site only accepts SVG files!
      if (!in_array($upload_albums_ext, array('png'))) {
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
        "INSERT INTO albums (name, artist, year, source, ext) VALUES (:name, :artist, :year, :source, :ext)",
        array(
          ':name' => $upload_albums_name,
          ':artist' => $upload_albums_artist,
          ':year' => $upload_albums_year,
          ':source' => $upload_albums_source,
          ':ext' => $upload_albums_ext
        )
      );

      $result2 = exec_sql_query(
        $db,
        "INSERT INTO tags (genre1, genre2) VALUES (:genre1, :genre2)",
        array(
          ':genre1' => $upload_tags_genre1,
          ':genre2' => $upload_tags_genre2
        )
      );

      $result3 = exec_sql_query(
        $db,
        "INSERT INTO album_tags (album_id, tags_id) VALUES ( (SELECT id FROM albums WHERE (name = :name)), (SELECT id FROM tags WHERE (genre1 = :genre1 AND genre2 = :genre2) ));",
        array(
          ":name" => $upload_albums_name,
          ':genre1' => $upload_tags_genre1,
          ':genre2' => $upload_tags_genre2
        )
      );


      if ($result && $result2) {
        // get the newly inserted record's id
        $record_id = $db->lastInsertId('id');

        // uploaded file should be in folder with same name as table with the primary key as the filename.
        // Note: THIS IS NOT A URL; this is a FILE PATH on the server!
        //       Do NOT include / at the beginning of the path; path should be a relative path.
        //          NO: /public/...
        //         YES: public/...
        $upload_storage_path = 'public/uploads/albums/' . $record_id . '.' . $upload_albums_ext;

        // Move the file to the public/uploads/clipart folder
        // Note: THIS FUNCTION REQUIRES A PATH. NOT A URL!
        if (move_uploaded_file($upload["tmp_name"], $upload_storage_path) == False) {
          error_log("Failed to permanently store the uploaded file on the file server. Please check that the server folder exists.");
        }
      }
    }
  }
}

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
      <h2>Add an Album Cover Entry!</h2>
    <section class="upload" id="upload">

      <?php
      // Access Controls - Interface: Only logged in users may upload
      if (is_user_logged_in()) { ?>
          <h3>Please feel free to add your album entry!</h3>
          <p>You must fill in all entries of the form! For the secondary genre, please put the second closest category of music for the album.</p>

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
              <label for="upload_file_name">Album Cover File:</label>
              <!-- This site only accepts PNG files! -->
              <input id="upload_file_name" type="file" name="file_name" accept=".png">

            </div>

            <div class="label-input">
              <label for="upload_albums_name">Album Name:</label>
              <input id='upload_albums_name' type="text" name="name" placeholder="Name of the Album">
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
              <label for="upload_tags_genre1">Genre 1</label>
              <input id='upload_tags_genre1' type="text" name="genre1" placeholder="Genre of Album">
            </div>

            <div class="label-input">
              <label for="upload_tags_genre2">Genre 2</label>
              <input id='upload_tags_genre2' type="text" name="genre2" placeholder="Genre of Album">
            </div>


            <div class="align-right">
              <button type="submit" name="upload">Upload</button>
            </div>
            </form>

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
