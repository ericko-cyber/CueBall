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
   <link rel="stylesheet" href="../css/keranjang.css">
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
                        <td><a href="keranjang.php?remove=<?php echo $fetch_cart['idkeranjang']; ?>" onclick="return confirm('Remove item from cart?')" class="delete-btn btn btn-danger"> <i class="fas fa-trash"></i> Remove</a></td>

                     </tr>
               <?php
                  }
               }
               ?>
               <tr class="table-bottom">
                  <td><a href="../indexuser.php" class="option-btn btn btn-warning" style="margin-top: 0;">Lanjutkan Belanja</a></td>
                  <td colspan="3">Total Keseluruhan</td>
                  <td><span id="grandtotal">Rp 0.00/-</span></td>
                  <td><a href="keranjang.php?delete_all=1" onclick="return confirm('Apakah Anda yakin ingin menghapus semua?');" class="delete-btn btn btn-danger"> <i class="fas fa-trash"></i> Hapus Semua </a></td>
               </tr>

            </tbody>
         </table>
         <!-- Your Checkout Button -->
         <div class="checkout-btn">
            <a href="#" data-bs-toggle="modal" data-bs-target="#checkout" class="btn btn-inti btn btn-success">Proceed to Checkout</a>
         </div>
      </section>


      <div class="modal fade" id="checkout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Checkout</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <form id="checkoutForm" action="update.php" method="post" enctype="multipart/form-data">
                  <div class="modal-body">
                     <div class="display-order" id="orderDetails">
                        <?php
                        $id_user = $_SESSION["id_user"];
                        $select_cart = mysqli_query($conn, "SELECT * FROM `keranjang` WHERE iduser = '$id_user'");
                        $total = 0;

                        if (mysqli_num_rows($select_cart) > 0) {
                           while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                              // Calculate the total price for each item
                              $total_price = $fetch_cart['harga'] * $fetch_cart['jumlah'];

                              // Add the total price to the overall total
                              $total += $total_price;

                              // Display item details
                        ?>
                              <span style="font-size: 15px;"><?= $fetch_cart['nama']; ?>(<?= $fetch_cart['jumlah']; ?>)</span>
                        <?php
                           }
                        } else {
                           echo "<div class='display-order'><span>Your cart is empty!</span></div>";
                        }
                        // Apply number_format to the grand total after the loop
                        $grand_total = $total;
                        ?>
                        <span class="grand-total" style="font-size: 15px;"> Grand Total: Rp<?= number_format($grand_total, 2); ?>/- </span>
                     </div>
                  </div>
                  <div class="flex" style="font-size: 15px;">
                     <div class="mb-1">
                        <label for="exampleInputPassword1" class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" id="exampleInputPassword1">
                     </div>
                     <div class="mb-1">
                        <label for="exampleInputPassword1" class="form-label">No HP</label>
                        <input type="text" name="hp" class="form-control" id="exampleInputPassword1">
                     </div>
                     <div class="mb-1">
                        <label for="exampleInputPassword1" class="form-label">Ket Meja</label>
                        <input type="text" name="meja" class="form-control" id="exampleInputPassword1">
                     </div>
                     <label for="">BRI:</label><br>
                     <label for="">GOPAY:</label><br>
                     <label for="">DANA:</label>
                     <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Foto : </label>
                        <input type="file" name="foto" class="form-control" id="exampleInputPassword1">
                     </div>
                  </div>
               </form>
               <div class="modal-footer">
                  <button type="button" name="save" class="btn btn-success">Simpan</button>
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                  <!-- Add any other buttons you need in the footer -->
               </div>
            </div>
         </div>
      </div>


   </div>
 

   <script>
      $(document).ready(function() {
         $('#checkout').on('show.bs.modal', function() {
            // Ambil dan perbarui konten dari div "display-order" di sini
            updateOrderDetails();
         });

         function updateOrderDetails() {
            // Gunakan AJAX untuk mengambil data terbaru dari server
            $.ajax({
               url: 'update.php', // Gantilah dengan path aktual ke skrip sisi server Anda
               method: 'POST',
               data: {
                  action: 'get_order_details'
               }, // Anda dapat menyertakan data tambahan yang diperlukan
               success: function(response) {
                  // Perbarui konten dari div "display-order" dengan respons dari server
                  $('#orderDetails').html(response);
               },
               error: function(xhr, status, error) {
                  // Tangani kesalahan jika ada
                  console.error(error);
               }
            });
         }
      });
   </script>



   <script src="../keranjang.js"></script>
   <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>





</html>