<?php
$title = ': Login';

// query the database for the album records
$result = exec_sql_query(
    $db,
    "SELECT albums.id AS 'albums.id', albums.artist AS 'albums.artist', albums.year AS 'albums.year', tags.genre1 AS 'tags.genre1', tags.genre2 AS 'tags.genre2'

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

  <title><?php echo $title; ?> Login</title>

  <link rel="stylesheet" type="text/css" href="/public/styles/site.css" media="all">
</head>


<body>
  <?php include 'includes/header.php'; ?>
  <main class="login-form">

      <?php
      // Access Controls - Interface: Only logged in users may upload
      if (is_user_logged_in()) { ?>
          <h2>You are already signed in!</h2>

      <?php } else {
        // user is not logged in. show login form
      ?>

        <h2>Sign In</h2>

        <p>Please login to your account to acces more features!</p>

      <?php echo login_form('/form#uploads', $session_messages);
      } ?>
    </section>

  </main>

</body>

</html>
