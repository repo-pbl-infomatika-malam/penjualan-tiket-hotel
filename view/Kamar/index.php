<?php
session_start();

$role = !isset($_SESSION['role']);

if ($role || $_SESSION['role'] !== 'seller') {
  header("location:../login");
}


require '../../config.php';
require '../../controller/getData.php';
$dataHotels = getData($conn, "SELECT * FROM kamar");

?>



<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Penjualan tiket hotel</title>
  <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="../../styles/global.css">
</head>

<body>
  <!-- navbar start -->
  <nav class="container-navbar">
    <div class="navbar-content container-lg">
      <a href="../landing-page/">
        <img src="../../assets/logo-pbl.png" class="logo" alt="" />
      </a>

      <div class="d-flex align-items-center gap-2">
        <a href="index.php">
          <button class="text-button-primary">Kamar</button>
        </a>
        <a id="button_transaksi" href="transaksi.php">
          <button class="text-button-primary">Transaksi</button>
        </a>
        <div class="divider"></div>

        <a href="../../controller/logout.php" class="button-primary">keluar</a>
      </div>
    </div>
  </nav>
  <!-- navbar end -->

  <br>
  <br>
  <p class="fs-1 container">Dashboard Admin <bold></bold>
  </p>
  <BR>
  <br>
  <br>
  <div class="container ">

    <br>
    <br>
    <!-- Button trigger modal -->
    <div>
      <button type="button" class="button-secondary mb-3 " data-bs-toggle="modal" data-bs-target="#modaltambah">
        TAMBAH PRODUK
      </button>
    </div>


    <table class="table table-bordered  table-hover container">
      <tr>
        <th>NO</th>
        <th>NAMA KAMAR</th>
        <th>NOMOR KAMAR</th>
        <th>DESKRIPSI</th>
        <th>FOTO</th>
        <th>TIPE KAMAR</th>
        <th>HARGA</th>
        <th>AKSI</th>
      </tr>


      <?php $i = 1; ?>
      <?php foreach ($dataHotels as $dataHotel) : ?>
        <tr>
          <td><?php echo $i; ?></td>
          <td><?php echo $dataHotel['room_name'] ?></td>
          <td><?php echo $dataHotel['room_number'] ?></td>
          <td><?php echo $dataHotel['description'] ?></td>
          <td>
            <img src="../../assets/productImages/<?php echo $dataHotel['image'] ?>" width="240" alt="iamge product">
          </td>

          <td><?php echo $dataHotel['type_room'] ?></td>
          <td><?php echo $dataHotel['price'] ?></td>

          <td class="d-flex gap-1">
            <a href="#" id="edit=<?php echo $i; ?>" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editData<?php echo $dataHotel['id_room']; ?>">Ubah</a>
            <a id="hapus=<?php echo $i; ?>" href="controller/hapuseData.php?idroom=<?php echo $dataHotel['id_room']; ?>" data-toggle="modal" class="btn btn-danger">Hapus</a>

          </td>
        </tr>

        <!-- Edit data -->
        <div class="modal fade modal-lg" id="editData<?php echo $dataHotel['id_room']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title fs-5" id="staticBackdropLabel">FORM DATA PRODUCT </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <form method="POST" action="controller/ubahData.php" enctype="multipart/form-data">
                <div class="modal-body overflow-auto">
                  <input type="hidden" name="id_room" value="<?= $dataHotel['id_room'] ?>">
                  <input type="hidden" name="gambarLama" value="<?= $dataHotel['image'] ?>">

                  <div class="mb-3">
                    <label class="form-label">NOMOR KAMAR</label>
                    <input type=text" class="form-control" name="nomer_kamar" id='ubah_nomer_kamar' placeholder="Masukan Nomor Kamar" value="<?php echo $dataHotel['room_number']; ?>">
                  </div>

                  <div class="mb-3">
                    <label class="form-label">NAMA KAMAR</label>
                    <input type="text" class="form-control" id='ubah_nama_kamar' name="nama_kamar" placeholder="Masukan Nomor Kamar" value="<?php echo $dataHotel['room_name']; ?>">
                  </div>

                  <div class="mb-3">
                    <label class="form-label">DESKRIPSI</label>
                    <input class="form-control" id='ubah_deskripsi_kamar' value="<?php echo $dataHotel['description']; ?>" name="deskripsi_kamar" rows="3"></textarea>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">FOTO</label>
                    <img src="../../assets/productImages/<?php echo $dataHotel['image'] ?>" width="100" alt="iamge product"><br>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">TIPE KAMAR</label>
                    <select class="form-select" name="type_kamar" id='ubah_type_kamar'>
                      <option value="standar">Kamar Standar</option>
                      <option value="deluxe">Kamar Keluarga</option>
                    </select>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="text" id='ubah_harga_kamar' class="form-control" value="<?php echo $dataHotel['price']; ?>" name="harga_kamar" placeholder="Masukan Harga">
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                  <button id="button_ubah" type="submit" class="btn btn-primary" name="submit">Kirim</button>
                </div>
              </form>

            </div>
          </div>
        </div>
        <!-- akhir Modal -->

        <?php $i++; ?>
      <?php endforeach; ?>
    </table>

    <!-- Awal Modal -->
    <div class="modal fade modal-lg" id="modaltambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title fs-5" id="staticBackdropLabel">FORM DATA PRODUCT </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <form method="POST" action="controller/tambahData.php" enctype="multipart/form-data">
            <div class="modal-body overflow-auto">
              <div class="mb-3">
                <label class="form-label">NOMOR KAMAR</label>
                <input type="text" class="form-control" name="nomer_kamar" id="tambah_nomer_kamar" placeholder="Masukan Nomor Kamar">
              </div>

              <div class="mb-3">
                <label class="form-label">NAMA KAMAR</label>
                <input type="text" class="form-control" id="tambah_nama_kamar" name="nama_kamar" placeholder="Masukan Nomor Kamar">
              </div>

              <div class="mb-3">
                <label class="form-label">DESKRIPSI</label>
                <textarea class="form-control" id="tambah_deskripsi_kamar" name="deskripsi_kamar" rows="3"></textarea>
              </div>

              <div class="mb-3">
                <label class="form-label">FOTO</label>
                <input type="file" class="form-control" id="input_gambar" name="image_hotel" placeholder="choose image">
              </div>

              <div class="mb-3">
                <label class="form-label">TIPE KAMAR</label>
                <select class="form-select" id="tambah_type_kamar" name="type_kamar">
                  <option></option>
                  <option value="standar">Kamar Standar</option>
                  <option value="deluxe">Kamar Keluarga</option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="text" class="form-control" id="tambah_harga_kamar" name="harga_kamar" placeholder="Masukan Harga">
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary" name="submit" id="button_tambah">Kirim</button>
            </div>
          </form>

        </div>
      </div>
    </div>
    <!-- akhir Modal -->

  </div>
  </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>