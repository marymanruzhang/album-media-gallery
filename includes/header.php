<header>
  <h1 id="title">ALBUM COVERS<?php echo htmlspecialchars($title); ?></h1>

  <nav id="menu-2">
    <ul>
      <!-- icon from https://pngtree.com/so/cd-icons -->
      <li class="<?php echo $nav_home_class; ?>"><a href="/"><img src="../public/images/cd.png" alt="filter"></a></li>
      <li class="<?php echo $nav_citations_class; ?>"><a href="/form"><img src="../public/images/upload.png" alt="filter"></a></li>


    <!-- Sign Out -->
      <?php if (is_user_logged_in()) { ?>
        <!-- free icon from https://www.vecteezy.com/vector-art/574782-logout-sign-icon -->
        <li class="sign-out-icon"><a href="<?php echo logout_url(); ?>"><img src="/public/images/logout.png" alt="login-icon"></a></li>
      <?php } ?>

    <!-- Sign In -->
    <?php if (!is_user_logged_in()) { ?>
        <!-- free icon from https://www.pikpng.com/pngvi/iTbwoTx_login-icon-line-icons-iconscout-login-icon-images/ -->
        <li class="sign-in-icon">
        <form class="entry-form" method="get" action="/login">
          <button class="sign-in-button" type="submit" ; ?><a href="<?php echo logout_url(); ?>"><img src="/public/images/login.png" alt="login-icon"></a></li>
        </form>
    <?php } ?>


    </ul>
  </nav>

</header>
