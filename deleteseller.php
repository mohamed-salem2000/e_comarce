<?php
include "config.php";
if (isset($_GET['value'])) {
    $value=$_GET['value'];
    $stm=$con->prepare("DELETE from product WHERE id='$value'");
    $stm->execute();
    $user=$stm->fetchAll(PDO::FETCH_ASSOC);
    header("Location: http://localhost:3000/aranoz-master/seller.php"); 
}

?>