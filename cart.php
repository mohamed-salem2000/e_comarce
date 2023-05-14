<?php
session_start();
 $iduser=$_SESSION['iduser'];

echo $iduser;
include "database_connection.php";
if (isset($_POST['update_update_btn'])) {
  $update_value = $_POST['update_quantity'];
  $update_id = $_POST['update_quantity_id'];
  $query = "UPDATE `cart` SET quantity = :update_value WHERE id = :update_id";
  $statement = $connect->prepare($query);
  $statement->bindParam(':update_value', $update_value);
  $statement->bindParam(':update_id', $update_id);
  $statement->execute();
 
}

if (isset($_GET['remove'])) {
  $remove_id = $_GET['remove'];
  $query = "DELETE FROM cart WHERE id = :remove_id";
  $statement = $connect->prepare($query);
  $statement->bindParam(':remove_id', $remove_id);
  $statement->execute();

}

if(isset($_GET['delete_all'])){
  $query = "DELETE FROM `cart`";
  $statement = $connect->prepare($query);
   header('location:cart.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style_cart.css">

</head>
<body>

<?php include "header.php"; ?>

<div class="container">

<section class="shopping-cart">

   <h1 class="heading">shopping cart</h1>

   <table>
    <thead>
        <tr>
            <th>image</th>
            <th>name</th>
            <th>price</th>
            <th>quantity</th>
            <th>total price</th>
            <th>action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $query = "SELECT * FROM cart WHERE user_id='$iduser'";
        $statement = $connect->prepare($query);
        $statement->execute();
        $grand_total = 0;
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
        ?>
        <tr>
            <td>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['image']); ?>" height="100" alt="User Image">
            </td>
            <td><?php echo $row['name']; ?></td>
            <td>$<?php echo number_format($row['price']); ?>/-</td>
            <td>
                <form action="" method="post">
                    <input type="hidden" name="update_quantity_id" value="<?php echo $row['id']; ?>">
                    <input type="number" name="update_quantity" min="1" value="<?php echo $row['quantity']; ?>">
                    <input type="submit" value="update" name="update_update_btn">
                </form>
            </td>
            <td>$<?php echo number_format($sub_total = $row['price'] * $row['quantity']); ?>/-</td>
            <td>
                <a href="cart.php?remove=<?php echo $row['id']; ?>" onclick="return confirm('Remove item from cart?')" class="delete-btn">
                    <i class="fas fa-trash"></i> remove
                </a>
            </td>
        </tr>
        <?php
            $grand_total += $sub_total;  
        }
        ?>
        <tr class="table-bottom">
            <td>
                <a href="category.php" class="option-btn" style="margin-top: 0;">continue shopping</a>
            </td>
            <td colspan="3">grand total</td>
            <td>$<?php echo number_format($grand_total); ?>/-</td>
            <td>
                <a href="cart.php?delete_all" onclick="return confirm('Are you sure you want to delete all?');" class="delete-btn">
                    <i class="fas fa-trash"></i> delete all
                </a>
            </td>
        </tr>
    </tbody>
</table>


   <div class="checkout-btn">
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">procced to checkout</a>
   </div>

</section>

</div>
   
<!-- custom js file link  -->
<script>
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