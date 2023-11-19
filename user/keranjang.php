<?php

require "../functions.php";

if (isset($_POST['update_quantity_btn'])) {
   $update_id = $_POST['update_quantity_id'];
   $update_value = $_POST['update_quantity'];

   $update_quantity_query = mysqli_query($conn, "UPDATE `keranjang` SET jumlah = '$update_value' WHERE idkeranjang = '$update_id'");

   if ($update_quantity_query) {
      echo "Update successful";
   } else {
      echo "Update failed: " . mysqli_error($conn);
   }
}


if (isset($_GET['remove'])) {
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM `keranjang` WHERE idkeranjang = '$remove_id'");
   header('location:keranjang.php');
};

if (isset($_GET['delete_all'])) {
   mysqli_query($conn, "DELETE FROM `cart`");
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
   <link rel="stylesheet" href="css/style.css">

</head>

<body>


   <div class="container">

      <section class="shopping-cart">

         <h1 class="heading">shopping cart</h1>

         <table>

            <thead>
               <th>image</th>
               <th>name</th>
               <th>price</th>
               <th>quantity</th>
               <th>total price</th>
               <th>action</th>
            </thead>

            <tbody>
               <?php
               $select_cart = mysqli_query($conn, "SELECT * FROM `keranjang`");
               $grand_total = 0;

               if (mysqli_num_rows($select_cart) > 0) {
                  while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                     $sub_total = $fetch_cart['harga'] * $fetch_cart['jumlah'];
                     $grand_total += $sub_total;
               ?>
                     <tr>
                        <td><img src="../img/<?php echo $fetch_cart['gambar']; ?>" height="100" alt=""></td>
                        <td><?php echo $fetch_cart['nama']; ?></td>
                        <td>Rp <?php echo number_format($fetch_cart['harga']); ?>/-</td>
                        <td>
                           <div class="card-action">
                              <button class="btn" onclick="handleCounterMin(<?php echo $fetch_cart['idkeranjang']; ?>)">-</button>
                              <input type="text" id="counter_<?php echo $fetch_cart['idkeranjang']; ?>" class="counter" value="<?php echo $fetch_cart['jumlah']; ?>">
                              <button class="btn" onclick="handleCounterPlus(<?php echo $fetch_cart['idkeranjang']; ?>)">+</button>
                           </div>
                        </td>
                        <td>Rp <?php echo $sub_total; ?>/-</td>
                        <td><a href="keranjang.php?remove=<?php echo $fetch_cart['idkeranjang']; ?>" onclick="return confirm('remove item from cart?')" class="delete-btn"> <i class="fas fa-trash"></i> remove</a></td>
                     </tr>
               <?php
                  }
               }

               // Display the grand total after the loop
               ?>
               <tr class="table-bottom">
                  <td><a href="products.php" class="option-btn" style="margin-top: 0;">lanjutkan belanja</a></td>
                  <td colspan="3">total keseluruhan</td>
                  <td><i class="fa-solid fa-rotate-right" style="cursor: pointer;" onclick="refreshPage()"></i>
                     &nbsp;&nbsp;Rp <?php echo $grand_total; ?>/-</td>
                  <td><a href="cart.php?delete_all" onclick="return confirm('apakah Anda yakin ingin menghapus semua?');" class="delete-btn"> <i class="fas fa-trash"></i> hapus semua </a></td>
               </tr>
            </tbody>


         </table>

         <div class="checkout-btn">
            <a href="checkout.php" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>">procced to checkout</a>
         </div>

      </section>

   </div>

   <!-- custom js file link  -->
   <!-- <script src="js/script.js"></script> -->
   <script>
      function refreshPage() {
         location.reload(true); // Gunakan 'true' untuk mereload halaman dari server
      }
      function handleCounterPlus(itemId) {
         const counter = document.getElementById(`counter_${itemId}`);
         let counterValue = parseInt(counter.value);
         counter.value = ++counterValue;

         updateDatabase(itemId, counterValue);
      }

      function handleCounterMin(itemId) {
         const counter = document.getElementById(`counter_${itemId}`);
         let counterValue = parseInt(counter.value);
         counter.value = counterValue > 1 ? --counterValue : 1;

         updateDatabase(itemId, counterValue);
      }

      function updateDatabase(itemId, newQuantity) {
         // Coba jalankan fungsi Ajax langsung di sini jika Anda memutuskan untuk tetap menggunakan file terpisah
         const xhr = new XMLHttpRequest();
         xhr.open("POST", "keranjang.php", true);
         xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

         xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
               console.log(xhr.responseText);
            }
         }

         xhr.send(`update_quantity_btn=1&update_quantity_id=${itemId}&update_quantity=${newQuantity}`);
      }
   </script>

</body>

</html>