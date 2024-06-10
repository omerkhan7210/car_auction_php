<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php.php');
}

if(isset($_POST['update'])){

   $pid = $_POST['pid'];
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);

   $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, details = ? WHERE id = ?");
   $update_product->execute([$name, $price, $details, $pid]);

   $message[] = 'product updated successfully!';

   $old_image = $_POST['old_image'];
   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['image']['size'];
   $image_tmp_name_01 = $_FILES['image']['tmp_name'];
   $image_folder_01 = './uploads/'.$image;

   if(!empty($image)){
      if($image_size_01 > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
         $update_image->execute([$image, $pid]);
         move_uploaded_file($image_tmp_name_01, $image_folder_01);
         unlink('./uploads/'.$old_image);
         $message[] = 'image 01 updated successfully!';
      }
   }



}

?>

<!DOCTYPE html>
<html lang="en">

<?php include './admin_head.php'; ?>

<style>
      .card {
      --bg-card: #e4e4e4;
      --primary: #6d28d9;
      --primary-800: #4c1d95;
      --primary-shadow: #2e1065;
      --light: #d9d9d9;
      --zinc-800: #18181b;
      --bg-linear: linear-gradient(0deg, var(--primary) 50%, var(--light) 125%);

      position: relative;

      display: flex;
      flex-direction: column;
      gap: 0.75rem;

      padding: 1rem;
      background-color: var(--bg-card);

      border-radius: 1rem;
    }

    .image_container {
      cursor: pointer;
      position: relative;
      z-index: 5;
height: 25rem;
    }

    .image_container img {
      object-fit: cover;
    
      width: 100%;
      height: 25rem;
    }

    .title {
      overflow: clip;
      width: 100%;
      font-size: 3rem;
      font-weight: 600;
      color:black;
      text-transform: capitalize;
      text-wrap: nowrap;
      text-overflow: ellipsis;
    }

    .size {
      font-size: 1.75rem;
      color: black;
    }

    .list-size {
      display: flex;
      align-items: center;
      gap: 0.25rem;
      margin-top: 0.25rem;
    }

    .list-size .item-list {
      list-style: none;
    }

    .list-size .item-list-button {
      cursor: pointer;

      padding: 0.5rem;
      background-color: var(--zinc-800);

      font-size: 1.75rem;
      color: var(--light);

      border: 2px solid var(--zinc-800);
      border-radius: 0.25rem;

      transition: all 0.3s ease-in-out;
    }

    .item-list-button:hover {
      border: 2px solid var(--light);
    }
    .item-list-button:focus {
      background-color: var(--primary);

      border: 2px solid var(--primary-shadow);

      box-shadow: inset 0px 1px 4px var(--primary-shadow);
    }

    .action {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .price {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--light);
    }

    .cart-button {
      cursor: pointer;

      display: flex;
      justify-content: center;
      align-items: center;
      gap: 0.25rem;

      padding: 1rem 1.5rem;
      width: 100%;
      background-image: var(--bg-linear);

      font-size: 1.75rem;
      font-weight: 500;
      color: var(--light);
      text-wrap: nowrap;

      border: 2px solid hsla(262, 83%, 58%, 0.5);
      border-radius: 0.5rem;
      box-shadow: inset 0 0 0.25rem 1px var(--light);
    }

    .cart-button .cart-icon {
      width: 2rem;
    }

    </style>
<body>


<div id="container-main" class="grid grid-cols-12">
<?php include './admin_header.php'; ?>

<section class="update-product col-span-10 w-full">

   <h1 class="heading">update product</h1>

   <?php
      $update_id = $_GET['update'];
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $select_products->execute([$update_id]);
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>

   
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">
      <div class="image-container">
         <div class="main-image">
            <img src="./uploads/<?= $fetch_products['image']; ?>" alt="">
         </div>
       
      </div>
      <span>update name</span>
      <input type="text" name="name" required class="box" maxlength="100" placeholder="enter product name" value="<?= $fetch_products['name']; ?>">
      <span>update price</span>
      <input type="number" name="price" required class="box" min="0" max="9999999999" placeholder="enter product price" onkeypress="if(this.value.length == 10) return false;" value="<?= $fetch_products['price']; ?>">
      <span>update details</span>
      <textarea name="details" class="box" required cols="30" rows="10"><?= $fetch_products['details']; ?></textarea>
      <span>update image 01</span>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
      <div class="flex-btn">
         <input type="submit" name="update" class="btn" value="update">
         <a href="products.php" class="option-btn">go back</a>
      </div>
   </form>
   
   <?php
         }
      }else{
         echo '<p class="empty">no product found!</p>';
      }
   ?>

</section>

</div>











<script src="../js/admin_script.js"></script>
   
</body>
</html>