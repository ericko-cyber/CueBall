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
}

if (isset($_GET['delete_all'])) {
   mysqli_query($conn, "DELETE FROM `keranjang`");
   header('location:cart.php');
}

$select_cart = mysqli_query($conn, "SELECT * FROM `keranjang`");
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
                  <td><a href="products.php" class="option-btn" style="margin-top: 0;">Lanjutkan Belanja</a></td>
                  <td colspan="3">Total Keseluruhan</td>
                  <td><span id="grandtotal">Rp 0.00/-</span></td>
                  <td><a href="cart.php" onclick="return confirm('Apakah Anda yakin ingin menghapus semua?');" class="delete-btn"> <i class="fas fa-trash"></i> Hapus Semua </a></td>
               </tr>

            </tbody>
         </table>
         <div class="checkout-btn">
            <a href="checkout.php" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>">Procced to Checkout</a>
         </div>
      </section>
   </div>

   <script>
      function updateDatabase(itemId, newQuantity) {
         const formData = new FormData();
         formData.append('update_quantity_btn', '1');
         formData.append('update_quantity_id', itemId);
         formData.append('update_quantity', newQuantity);

         // Tambahan variabel untuk grand total
         formData.append('order_total', getGrandTotal());

         $.ajax({
            type: 'POST',
            url: 'keranjang.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
               console.log(data);
               updateTotals();
            },
            error: function(error) {
               console.error('Error during ajax request:', error);
            }
         });
      }

      // Fungsi untuk mendapatkan grand total dari elemen HTML
      function getGrandTotal() {
         return parseFloat($('#grandtotal').text().replace('Rp', '').replace('/-', '').replace(',', ''));
      }


      function handleCounterPlus(itemId) {
         const counter = $(`#counter_${itemId}`);
         counter.val(Math.max(parseInt(counter.val()) + 1, 1));

         updateDatabase(itemId, counter.val());
      }

      function handleCounterMin(itemId) {
         const counter = $(`#counter_${itemId}`);
         counter.val(Math.max(parseInt(counter.val()) - 1, 1));

         updateDatabase(itemId, counter.val());
      }

      function updateTotals() {
         let newGrandTotal = 0;

         // Iterasi setiap baris item di tabel
         $('tbody tr').each(function(index, row) {
            const priceText = $(row).find('td:nth-child(3)').text().trim().replace('Rp', '').replace('/-', '');
            const price = parseFloat(priceText) || 0; // Pastikan bahwa price adalah angka, jika tidak, gunakan 0
            const quantity = parseInt($(row).find('.counter').val()) || 0; // Pastikan bahwa quantity adalah angka, jika tidak, gunakan 0
            const subTotal = price * quantity;

            // Tampilkan subtotal di kolom ke-5 tanpa format desimal
            $(row).find('td:nth-child(5)').text(`Rp ${subTotal.toFixed(2).replace('.', ',')}/-`);

            newGrandTotal += subTotal;
         });

         // Tampilkan grand total di elemen dengan id 'grandtotal'
         const grandtotalElement = $('#grandtotal');
         if (!isNaN(newGrandTotal) && grandtotalElement.length > 0) {
            grandtotalElement.text(`Rp ${newGrandTotal.toFixed(2).replace('.', ',')}/-`);
         }
      }

      // Panggil fungsi ini ketika halaman dimuat
      $(document).ready(function() {
         updateTotals();
      });


      window.onload = updateTotals;

      function refreshPage() {
         location.reload(true);
      }
   </script>
</body>

</html>