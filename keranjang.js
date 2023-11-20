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