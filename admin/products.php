<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php.php');
};

if(isset($_POST['add_product'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);

   
   $bid = $_POST['bid'];
   $bid = filter_var($bid, FILTER_SANITIZE_STRING);


   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = './uploads/'.$image;


   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

   if($select_products->rowCount() > 0){
      $message[] = 'product name already exist!';
   }else{

      $insert_products = $conn->prepare("INSERT INTO `products`(name, details, price,min_bid, image) VALUES(?,?,?,?,?)");
      $insert_products->execute([$name, $details, $price,$bid, $image]);

      if($insert_products){
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'new product added!';
      }

   }  

};


?>

<!DOCTYPE html>
<html lang="en">

<?php include './admin_head.php'; ?>
<body>

<div id="container-main" class="grid grid-cols-12">
      <?php include './admin_header.php'; ?>
      <section class="flex justify-center flex-col gap-10  col-span-10 w-full">

      <h2 class="text-center text-5xl uppercase font-bold leading-9 tracking-tight text-gray-900">Add Products</h2>

         <form class="space-y-6 mx-[400px]" action="#" method="POST"  enctype="multipart/form-data">
            <div>
            <label for="name" class="block text-3xl font-medium leading-6 text-gray-900 capitalize">enter product name</label>
            <div class="mt-2">
               <input id="name" name="name" type="text" autocomplete="email" required class="p-3 block w-full rounded-md border-0 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-3xl sm:leading-6">
            </div>
            </div>

            <div>
               <label for="price" class="block text-3xl font-medium leading-6 text-gray-900 capitalize">enter product price</label>
               
            <div class="mt-2">
            <input type="number" min="0"  required max="9999999999" onkeypress="if(this.value.length == 10) return false;" name="price" class="block p-3 w-full rounded-md border-0  text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-3xl sm:leading-6">
            </div>
            </div>

            <div>

            <div class="my-5">
               <label for="bid" class="block text-3xl font-medium leading-6 text-gray-900 capitalize">enter product minimum bid</label>
               
            <div class="mt-2">
            <input type="number" min="0"  required max="9999999999" onkeypress="if(this.value.length == 10) return false;" name="bid" class="block p-3 w-full rounded-md border-0  text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-3xl sm:leading-6">
            </div>
            </div>

            <div  class="my-5">

            <label for="image" class="block text-3xl font-medium leading-6 text-gray-900 capitalize">select product image</label>
            
            <div class="mt-2">

            <div class="grid w-full items-center gap-1.5">
                  <input id="picture" type="file" name="image" class="flex h-16 w-full rounded-md border border-input bg-white px-3 py-2 text-2xl text-gray-400 file:border-0 file:bg-transparent file:text-gray-600 file:text-2xl file:font-medium">
            </div>

            </div>
            </div>

            <div>
            <label for="details" class="block text-3xl font-medium leading-6 text-gray-900 capitalize">enter product description</label>
               
            <div class="mt-2">
            <textarea name="details" required maxlength="500" cols="30" rows="10" class="block  w-full rounded-md border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-3xl sm:leading-6"></textarea>
            </div>
            </div>

            <div>
            <button name="add_product" type="submit" class="flex w-full justify-center rounded-md uppercase bg-indigo-600 px-3 py-7 text-3xl font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">add product</button>
            </div>
         </form>


      </section>
</div>

<script src="../js/admin_script.js"></script>
   
</body>
</html>