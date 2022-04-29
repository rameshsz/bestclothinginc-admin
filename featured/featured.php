<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" type="text/css" href="featured.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter" />
  <link href="http://fonts.cdnfonts.com/css/inclitodo" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.typekit.net/ata5zyl.css">
  <?php require_once 'c:/xampp/htdocs/bestclothinginc/functions.php';
  ?>
</head>

<body>
  <div id="banner">
    <img id="logo" src="../images/logo.png" alt="" />
  </div>
  <header>
    <ul>
      <li><a href="../" id=>Home</a></li>
      <li><a href="#" id="selected">Featured</a></li>
      <li><a href="#">Men</a></li>
      <li><a href="#">Women</a></li>
      <li><a href="#">About</a></li>
      <li><img class="icon" id="icon" src="../images/b.png" /></li>
    </ul>
  </header>
  <section class="product-list">
    <div>
      <h1>Featured Items</h1>
    </div>
    <div class="product-container">
      <?php
      $message = getFeatured();
      ?>
      <!-- first product -->
      <div class="card">
        <div class="brand"><?php echo $message[0]['prod_brand']; ?></div>
        <div class="title"> <?php echo $message[0]['prod_name']; ?> </div>
        <div class="image"><img src=<?php echo $message[0]['prod_img']; ?> /></div>
        <div class="text">$<?php echo $message[0]['prod_price']; ?></div>
      </div>
      <!-- second product -->
      <div class="card">
        <div class="brand"><?php echo $message[1]['prod_brand']; ?></div>
        <div class="title"><?php echo $message[1]['prod_name']; ?></div>
        <div class="image"><img src=<?php echo $message[1]['prod_img']; ?> /></div>
        <div class="text">$<?php echo $message[1]['prod_price']; ?></div>
      </div>
      <!-- third product -->
      <div class="card">
        <div class="brand"><?php echo $message[2]['prod_brand']; ?></div>
        <div class="title"><?php echo $message[2]['prod_name']; ?></div>
        <div class="image"><img src=<?php echo $message[2]['prod_img']; ?> /></div>
        <div class="text">$<?php echo $message[2]['prod_price']; ?></div>
      </div>
      <!-- fourth product -->
      <div class="card">
        <div class="brand"><?php echo $message[3]['prod_brand']; ?></div>
        <div class="title"><?php echo $message[3]['prod_name']; ?></div>
        <div class="image"><img src=<?php echo $message[3]['prod_img']; ?> /></div>
        <div class="text">$<?php echo $message[3]['prod_price']; ?></div>
      </div>
      <!-- fifth product -->
      <div class="card">
        <div class="brand"><?php echo $message[4]['prod_brand']; ?></div>
        <div class="title"><?php echo $message[4]['prod_name']; ?></div>
        <div class="image"><img src=<?php echo $message[4]['prod_img']; ?> /></div>
        <div class="text">$<?php echo $message[4]['prod_price']; ?></div>
      </div>
      <!-- sixth product -->
      <div class="card">
        <div class="brand"><?php echo $message[5]['prod_brand']; ?></div>
        <div class="title"><?php echo $message[5]['prod_name']; ?></div>
        <div class="image"><img src=<?php echo $message[5]['prod_img']; ?> /></div>
        <div class="text">$<?php echo $message[5]['prod_price']; ?></div>
      </div>
    </div>
  </section>
</body>

</html>