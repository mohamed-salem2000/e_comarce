<?php

include "database_connection.php";

$query = "SELECT * FROM cart WHERE user_id='1'";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$row_count = $statement->rowCount();


?>

<header class="header">
   <div class="flex">
      <a href="#" class="logo">foodies</a>
      <nav class="navbar">
         <a href="admin.php">add products</a>
         <a href="category.php">view products</a>
      </nav>
      <a href="cart.php" class="cart">cart <span><?php echo $row_count; ?></span> </a>
      <div id="menu-btn" class="fas fa-bars"></div>
   </div>
</header>
