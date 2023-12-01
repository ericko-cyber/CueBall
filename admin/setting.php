<?php

if (isset($_POST["edit"])) {
    if (editAdmin($_POST) > 0) {
        // Update session setelah pembaruan berhasil
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['nama'] = $_POST['nama'];
        $_SESSION['phone'] = $_POST['hp'];
        $_SESSION['email'] = $_POST['email'];

        echo "<script>
            alert('Berhasil DiTambahkan');
            window.location.href = 'admin.php?page=setting'; // Merefresh halaman ke admin.php
        </script>";
    } else {
        echo "<script>
            alert('Gagal DiTambahkan');
        </script>";
    }
}


?>

<link rel="stylesheet" href="../css/setting.css">
<link rel="stylesheet" href="../css/form.css">

<main class="" style="margin-top: 0%; width:auto; height:auto; ">
    <div class="card overflow-hidden" style="background:#424242;">
        <div class="row no-gutters row-bordered row-border-light">
            <div class="col-md-9">
                <form action="" method="post">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="account-general">
                            <div class="card-body media align-items-center" style="display: flex; align-items: center;">
                                <img src="../logo.png" style="width: 10%;">
                                <span style="margin-left: 20px; font-size: 30px; font-weight: 600; color: #fff;">BASECAMP BILLIARD</span>
                            </div>
                            <hr class="border-light m-0" style="width: 140%;">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label text-white">Username</label>
                                    <input type="text" name="username" class="form-control mb-1" value="<?= isset($_POST['username']) ? $_POST['username'] : $_SESSION["username"]; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label text-white">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control" value="<?= isset($_POST['nama']) ? $_POST['nama'] : $_SESSION["nama"]; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label text-white">No Hp</label>
                                    <input type="text" name="hp" class="form-control" value="<?= isset($_POST['hp']) ? $_POST['hp'] : $_SESSION["phone"]; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label text-white">Email</label>
                                    <input type="email" name="email" class="form-control" value="<?= isset($_POST['email']) ? $_POST['email'] : $_SESSION["email"]; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label text-white">New password / Old password</label>
                                    <input type="password" name="password" class="form-control" placeholder="***********">
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <div class="text-right mt-3 p-2">
            <button type="submit" name="edit" id="edit" class="btn btn-primary">Update akun</button>&nbsp;&nbsp;
            <a href="admin/kontrol/hapusAdmin.php?id=<?= $_SESSION["id_user"]; ?>" class="btn btn-danger">Hapus akun</a>
        </div>
        </form>
    </div>
</main>