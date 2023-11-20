<?php
session_start();
require "../functions.php";
require "../session.php";
if ($role !== 'User') {
   header("location:../login.php");
}
$id_user = $_SESSION["id_user"];

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
}

if (isset($_GET['delete_all'])) {
   mysqli_query($conn, "DELETE FROM `keranjang` WHERE iduser = '$id_user'");
   header('location:keranjang.php');
}

$select_cart = mysqli_query($conn, "SELECT * FROM `keranjang` where iduser = '$id_user'");
$grand_total = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shopping Cart</title>
   <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
   <link rel="stylesheet" href="css/style.css">
</head>

<body>
   <div class="container">
      <section class="shopping-cart">
         <h1 class="heading">Shopping Cart</h1>
         <table>
            <thead>
               <th>Image</th>
               <th>Name</th>
               <th>Price</th>
               <th>Quantity</th>
               <th>Total Price</th>
               <th>Action</th>
            </thead>
            <tbody>
               <?php
               if (mysqli_num_rows($select_cart) > 0) {
                  while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
               ?>
                     <tr>
                        <td><img src="../img/<?php echo $fetch_cart['gambar']; ?>" height="100" alt=""></td>
                        <td><?php echo $fetch_cart['nama']; ?></td>
                        <td>Rp <?php echo ($fetch_cart['harga']); ?>/-</td>
                        <td>
                           <div class="card-action">
                              <button class="btn" onclick="handleCounterMin(<?php echo $fetch_cart['idkeranjang']; ?>)">-</button>
                              <input type="text" id="counter_<?php echo $fetch_cart['idkeranjang']; ?>" class="counter" value="<?php echo $fetch_cart['jumlah']; ?>">
                              <button class="btn" onclick="handleCounterPlus(<?php echo $fetch_cart['idkeranjang']; ?>)">+</button>
                           </div>
                        </td>
                        <td>Rp <?php echo $fetch_cart['harga'] * $fetch_cart['jumlah']; ?>/-</td>
                        <td><a href="keranjang.php?remove=<?php echo $fetch_cart['idkeranjang']; ?>" onclick="return confirm('Remove item from cart?')" class="delete-btn"> <i class="fas fa-trash"></i> Remove</a></td>
                     </tr>
               <?php
                  }
               }
               ?>
               <tr class="table-bottom">
                  <td><a href="../indexuser.php" class="option-btn" style="margin-top: 0;">Lanjutkan Belanja</a></td>
                  <td colspan="3">Total Keseluruhan</td>
                  <td><span id="grandtotal">Rp 0.00/-</span></td>
                  <td><a href="keranjang.php?delete_all=1" onclick="return confirm('Apakah Anda yakin ingin menghapus semua?');" class="delete-btn"> <i class="fas fa-trash"></i> Hapus Semua </a></td>
               </tr>

            </tbody>
         </table>
         <!-- Your Checkout Button -->
         <div class="checkout-btn">
            <a href="#" data-bs-toggle="modal" data-bs-target="#editProfilModal" class="btn btn-inti">Proceed to Checkout</a>
         </div>

      </section>
   </div>
   <!-- Checkout -->
   <!-- Modal Structure -->
   <div class="modal fade" id="editProfilModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Checkout Modal</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <!-- Your checkout form or content goes here -->
               <p>Place your checkout form or content here...</p>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
               <!-- Add any other buttons you need in the footer -->
            </div>
         </div>
      </div>
   </div>

   <script src="../keranjang.js"></script>
   <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>