<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Web</title>
    <!--font awsome cdn link-->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    />
    <!--css link-->
    <link rel="stylesheet" href="/DACS2/css/style.css" />
  </head>
  <body>
    <!--Header-->

    <header class="header">
      <section class="flex">
        <a href="/DACS2/home.php" class="logo">Education</a>

        <form action="" method="post" class="search-form">
          <input type="text" name="search_box" placeholder="Search courses" />
          <button
            type="submit"
            class="fas fa-search"
            name="search_box"
          ></button>
        </form>
        <div class="icons">
          <div id="menu-btn" class="fas fa-bars"></div>
          <div id="search-btn" class="fas fa-search"></div>
          <div id="user-btn" class="fas fa-user"></div>
          <div id="toggle-btn" class="fas fa-sun"></div>
        </div>

        <div class="profile">
          <img src="/DACS2/images/pic-1.jpg" alt="" />
          <h3>Hoa handsome</h3>
          <span>Student</span>
          <a href="/DACS2/profile.php" class="btn">view profile</a>
          <div class="flex-btn">
            <a href="/DACS2/login.php" class="option-btn">login</a>
            <a href="/DACS2/register.php" class="option-btn">register</a>
          </div>
        </div>
      </section>
    </header>
  </body>
</html>
