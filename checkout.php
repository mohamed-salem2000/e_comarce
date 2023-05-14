<?php

include 'database_connection.php';

if(isset($_POST['order_btn'])){

   $name = $_POST['name'];
   $number = $_POST['number'];
   $email = $_POST['email'];
   $method = $_POST['method'];
   $flat = $_POST['flat'];
   $street = $_POST['street'];
   $city = $_POST['city'];
   $state = $_POST['state'];
   $country = $_POST['country'];
   $pin_code = $_POST['pin_code'];

   $cart_query = mysqli_query($con, "SELECT * FROM `cart`");
   $price_total = 0;
   if(mysqli_num_rows($cart_query) > 0){
      while($product_item = mysqli_fetch_assoc($cart_query)){
         $product_name[] = $product_item['name'] .' ('. $product_item['quantity'] .') ';
         $product_price = number_format($product_item['price'] * $product_item['quantity']);
         $price_total += $product_price;
      };
   };

   $total_product = implode(', ',$product_name);
   $detail_query = mysqli_query($con, "INSERT INTO `order`(name, number, email, method, flat, street, city, state, country, pin_code, total_products, total_price) VALUES('$name','$number','$email','$method','$flat','$street','$city','$state','$country','$pin_code','$total_product','$price_total')") or die('query failed');

   if($cart_query && $detail_query){
      echo "
      <div class='order-message-container'>
      <div class='message-container'>
         <h3>thank you for shopping!</h3>
         <div class='order-detail'>
            <span>".$total_product."</span>
            <span class='total'> total : $".$price_total."/-  </span>
         </div>
         <div class='customer-details'>
            <p> your name : <span>".$name."</span> </p>
            <p> your number : <span>".$number."</span> </p>
            <p> your email : <span>".$email."</span> </p>
            <p> your address : <span>".$flat.", ".$street.", ".$city.", ".$state.", ".$country." - ".$pin_code."</span> </p>
            <p> your payment mode : <span>".$method."</span> </p>
            <p>(*pay when product arrives*)</p>
         </div>
            <a href='category.php' class='btn'>continue shopping</a>
         </div>
      </div>
      ";
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style_cart.css">

   <Style>
*{
  margin-left:20px; 
  margin-right:20px;

  /* padding:0; */
}
    </style>


</head>
<body>

<?php include 'header.php'; ?>

<div class="container">

<section class="checkout-form">

   <h1 class="heading">complete your order</h1>

   <form action="" method="post" style="   padding:2rem; border-radius: .5rem; background-color: var(--bg-color);">

   <div class="display-order">
      <?php
         $select_cart = $connect->query("SELECT * FROM `cart`");
         $total = 0;
         $grand_total = 0;
         if ($select_cart->rowCount() > 0) {
            while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
               $total_price = $fetch_cart['price'] * $fetch_cart['quantity'];
               $grand_total += $total_price;
      ?>
      <span><?= $fetch_cart['name']; ?>(<?= $fetch_cart['quantity']; ?>)</span>
      <?php
            }
         } else {
            echo "<div class='display-order'><span>your cart is empty!</span></div>";
         }
      ?>
   </div>

   </form>

</section>
</div>
      <span class="grand-total"> grand total : $<?= $grand_total; ?>/- </span>
    </div>

      <div class="flex" style="display: flex; flex-wrap: wrap; gap:1.5rem;">
         <div class="inputBox" style="flex:1 1 40rem;">
            <span style="font-size: 2rem; color:var(--black);">your name</span>
            <input type="text" placeholder="enter your name" name="name" required style="width: 100%; background-color: var(--white); font-size: 1.7rem; color:var(--black); border-radius: .5rem; margin:1rem 0; padding:1.2rem 1.4rem; text-transform: none; border:var(--border);">
         </div>
         <div class="inputBox" style="flex:1 1 40rem;">
            <span style="font-size: 2rem; color:var(--black);">your number</span>
            <input type="number" placeholder="enter your number" name="number" required style="width: 100%; background-color: var(--white); font-size: 1.7rem; color:var(--black); border-radius: .5rem; margin:1rem 0; padding:1.2rem 1.4rem; text-transform: none; border:var(--border);">
         </div>
         <div class="inputBox" style="flex:1 1 40rem;">
            <span style="font-size: 2rem; color:var(--black);">your email</span>
            <input type="email" placeholder="enter your email" name="email" required style="width: 100%; background-color: var(--white); font-size: 1.7rem; color:var(--black); border-radius: .5rem; margin:1rem 0; padding:1.2rem 1.4rem; text-transform: none; border:var(--border);">
         </div>
         <div class="inputBox" style="flex:1 1 40rem;">
            <span style="font-size: 2rem; color:var(--black);">payment method</span>
            <select name="method" style="width: 100%; background-color: var(--white); font-size: 1.7rem; color:var(--black); border-radius: .5rem; margin:1rem 0; padding:1.2rem 1.4rem; text-transform: none; border:var(--border);">
               <option value="cash on delivery" selected>cash on devlivery</option>
               <option value="credit cart">credit cart</option>
               <option value="paypal">paypal</option>
            </select>
         </div>
         <div class="inputBox" style="flex:1 1 40rem;">
            <span style="font-size: 2rem; color:var(--black);">address line 1</span>
            <input type="text" placeholder="e.g. flat no." name="flat" required style="width: 100%; background-color: var(--white); font-size: 1.7rem; color:var(--black); border-radius: .5rem; margin:1rem 0; padding:1.2rem 1.4rem; text-transform: none; border:var(--border);">
         </div>
         <div class="inputBox" style="flex:1 1 40rem;">
            <span style="font-size: 2rem; color:var(--black);">address line 2</span>
            <input type="text" placeholder="e.g. street name" name="street" required style="width: 100%; background-color: var(--white); font-size: 1.7rem; color:var(--black); border-radius: .5rem; margin:1rem 0; padding:1.2rem 1.4rem; text-transform: none; border:var(--border);">
         </div>
         <div class="inputBox" style="flex:1 1 40rem;">
            <span>city</span>
            <input type="text" placeholder="e.g. mumbai" name="city" required style="width: 100%; background-color: var(--white); font-size: 1.7rem; color:var(--black); border-radius: .5rem; margin:1rem 0; padding:1.2rem 1.4rem; text-transform: none; border:var(--border);">
         </div>
         <div class="inputBox" style="flex:1 1 40rem;">
            <span style="font-size: 2rem; color:var(--black);">state</span>
            <input type="text" placeholder="e.g. maharashtra" name="state" required style="width: 100%; background-color: var(--white); font-size: 1.7rem; color:var(--black); border-radius: .5rem; margin:1rem 0; padding:1.2rem 1.4rem; text-transform: none; border:var(--border);">
         </div>
         <div class="inputBox" style="flex:1 1 40rem;">
            <span style="font-size: 2rem; color:var(--black);">country</span>
            <input type="text" placeholder="e.g. india" name="country" required style="width: 100%; background-color: var(--white); font-size: 1.7rem; color:var(--black); border-radius: .5rem; margin:1rem 0; padding:1.2rem 1.4rem; text-transform: none; border:var(--border);">
         </div>
         <div class="inputBox" style="flex:1 1 40rem;">
            <span style="font-size: 2rem; color:var(--black);">pin code</span>
            <input type="text" placeholder="e.g. 123456" name="pin_code" required style="width: 100%; background-color: var(--white); font-size: 1.7rem; color:var(--black); border-radius: .5rem; margin:1rem 0; padding:1.2rem 1.4rem; text-transform: none; border:var(--border);">
         </div>
      </div>
      <input type="submit" value="order now" name="order_btn" class="btn">
   </form>

</section>

</div>

<!-- custom js file link  -->
<script >
    let menu = document.querySelector('#menu-btn');
let navbar = document.querySelector('.header .navbar');

menu.onclick = () =>{
   menu.classList.toggle('fa-times');
   navbar.classList.toggle('active');
};

window.onscroll = () =>{
   menu.classList.remove('fa-times');
   navbar.classList.remove('active');
};


document.querySelector('#close-edit').onclick = () =>{
   document.querySelector('.edit-form-container').style.display = 'none';
   window.location.href = 'admin.php';
};
</script>
   
</body>
</html>