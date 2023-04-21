<header>
  <h1 id="title"><?php echo htmlspecialchars($title); ?> - INFO 2300</h1>

  <nav id="menu">
    <ul>
      <li class="<?php echo $nav_home_class; ?>"><a href="/">Home</a></li>
      <li class="<?php echo $nav_citations_class; ?>"><a href="/form">Upload Form</a></li>

      <?php if (is_user_logged_in()) { ?>
        <li class="float-right"><a href="<?php echo logout_url(); ?>">Sign Out</a></li>
      <?php } ?>
    </ul>
  </nav>
</header>
