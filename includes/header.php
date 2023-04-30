<header>
  <h1 id="title">ALBUM COVERS<?php echo htmlspecialchars($title); ?></h1>

  <nav id="menu">
    <ul>
      <li class="<?php echo $nav_home_class; ?>"><a href="/"><img src="../public/images/cd.png" alt="filter"></a></li>
      <li class="<?php echo $nav_citations_class; ?>"><a href="/form"><img src="../public/images/upload.png" alt="filter"></a></li>


    <!-- Sign In -->

      <?php if (is_user_logged_in()) { ?>
        <!-- icon made by me -->
        <li class="sign-out-icon"><a href="<?php echo logout_url(); ?>"><img src="/public/images/login.png" alt="login-icon"></a></li>
      <?php } ?>

    <!-- Sign In -->

    <?php if (!is_user_logged_in()) { ?>
        <!-- icon made by me -->
        <li class="sign-in-icon">
        <form class="entry-form" method="get" action="/login">
          <button class="sign-in-button" type="submit" ; ?><a href="<?php echo logout_url(); ?>"><img src="/public/images/login.png" alt="login-icon"></a></li>
        </form>
    <?php } ?>

    <!-- Use filter button to open the sidenav / made by myself-->
  <span onclick="openNav()"><img src="../public/images/filter.png" alt="filter"></span>

    </ul>
  </nav>

</header>
