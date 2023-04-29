<header>
  <h1 id="title"><?php echo htmlspecialchars($title); ?>Album Covers</h1>

  <nav id="menu">
    <ul>
      <li class="<?php echo $nav_home_class; ?>"><a href="/">Home</a></li>
      <li class="<?php echo $nav_citations_class; ?>"><a href="/form">Upload</a></li>


    <!-- Sign In -->
    <div class = "logout">
      <?php if (is_user_logged_in()) { ?>
        <!-- icon made by me -->
        <li class="sign-out-icon"><a href="<?php echo logout_url(); ?>"><img src="/public/images/login.png" alt="login-icon"></a></li>
      <?php } ?>
    </div>

    <!-- Sign In -->
    <div class = "login">
      <?php if (!is_user_logged_in()) { ?>
        <!-- icon made by me -->
        <li class="sign-in-icon"><a href="<?php echo logout_url(); ?>"><img src="/public/images/login.png" alt="login-icon"></a></li>
      <?php } ?>
    </div>
    </ul>
  </nav>

</header>
