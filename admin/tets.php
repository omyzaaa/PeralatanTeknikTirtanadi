<?php
include("../lib/connect.php");

function kategori()
{
  global $connection;
  $get = "SELECT * FROM categori";
  $hasil = mysqli_query($connection, $get);

  echo '<select name="kategori" class="form-control">';
  while ($row = mysqli_fetch_array($hasil)) {
    $kategori = $row['nama'];
    echo '<option value="' . $kategori . '">' . $kategori . '</option>';
  }
  echo '</select>';
}

function insert_brand($brand)
{
  global $connection;
  $sql = $connection->query("SELECT * FROM brand WHERE nama = '$brand'");
  $row = $sql->fetch_assoc();
  if ($sql->num_rows > 0) {
    header('location:produk.php');
  } else {
    $sql = "INSERT into brand values ('','$brand')";
    $q1 = mysqli_query($connection, $sql);
  }
}

function insert_product($id, $nama, $brand, $kategori, $ket, $stock, $price, $image, $deskripsi)
{
  global $connection;
  $sql = "INSERT INTO produk VALUES ('$id','$nama', '$brand',  '$kategori', '$ket', '$image', '$price', '$stock', '$deskripsi')";
  $q1 = mysqli_query($connection, $sql);
  if ($q1) {
    echo "<script>alert('Data berhasil ditambahkan!');document.location.href='../admin/produk.php';</script>";
  }
}


function card($a)
{
  global $connection;
  $hasil = mysqli_query($connection, $a);
  while ($row = mysqli_fetch_array($hasil)) {
    $id = $row['p_id'];
    $nama = $row['nama'];
    $brand = $row['brand'];
    $harga = $row['harga'];
    $gambar = $row['gambar'];
    $kategori = $row['kategori'];
    $stok = $row['stok'];
    $deskripsi = $row['deskripsi'];

  ?>
    <div class="el-wrapper">
      <div class="box-up">
        <img class="img" src="../image/FotoProduk/<?= $gambar ?>" alt="">
        <div class="img-info">
          <div class="info-inner">
            <span class="p-name"><?= $nama ?></span>
            <span class="p-company"><?= $brand ?></span>
            <span class="p-category"><?= $kategori ?></span>
          </div>
          <?php
          if ($stok != 0) {
          ?>
            <div class="a-size">Stok : <?= $stok ?></div><br>
        </div>
      </div>
      <div class="box-down">
        <div class="h-bg">
          <div class="h-bg-inner"></div>
        </div>
        <a class="cart" href="../page/product_detail.php?p_id=<?= $id ?>">
          <span class="price">RP.<?= $harga ?></span>
          <span class="add-to-cart">
            <span class="txt">Detail</span>
          </span>
        </a>
      </div>
    <?php
          } else {
    ?>
      <div class="a-size">Stok : Habis</div><br>
    </div>
    </div>
    <div class="box-down">
      <div class="h-bg">
        <div class="h-bg-inner"></div>
      </div>
      <a class="cart" href="#">
        <span class="price">RP.<?= $harga ?></span>
        <span class="add-to-cart">
          <span class="txt" style="color: red;">SOLD OUT</span>
        </span>
      </a>
    </div>
  <?php
          }
  ?>
  </div>
<?php
  }
}

function product_detail($id, $b)
{
  global $connection;
  $id = $_GET['p_id'];
  $get = "SELECT * FROM produk WHERE p_id = '$id'";
  $hasil = mysqli_query($connection, $get);
  while ($row = mysqli_fetch_array($hasil)) {
?>
  <!--GALLERY-->
  <div class="pics">
    <span class="main-img"><img src="../image/FotoProduk/<?= $row['gambar'] ?>"></span>
  </div>
  <!-- PRODUCT INFORMATION -->
  <div class="product">
    <!--category-breadcrumb-->
    <span class="category"><?= $row['kategori'] ?></span>
    <!--stock-label-->
    <span class="stock">Stock : <?= $row['stok'] ?></span>
    <h1><?= $row['nama'] ?></h1>
    <!--PRICE-RATING-REVIEW-->
    <div class="block-price-rating clearfix">
      <!--price-->
      <div class="block-price clearfix">
        <div class="price-new clearfix">
          <span class="price-new-dollar">Rp.<?= $row['harga'] ?></span>
        </div>
      </div>
    </div>
    <!--PRODUCT DESCRIPTION-->
    <div class="descr">
      <p><?= $row['deskripsi'] ?></p>
    </div>
    <br>
    <!--SELECT BLOCK-->
    <div class="block-select clearfix">
      <form method="POST">
        <div class="select-color">
          <?php
          // Pisahkan nilai kolom nama_buah berdasarkan separator koma (,)
          $ket = explode(',', $row['ket']);
          ?>
          <span>Pilihan :</span>
          <?php
          // Lakukan pengulangan untuk setiap nilai yang telah dipisahkan
          foreach ($ket as $k) {
            // Lakukan operasi sesuai dengan kebutuhan Anda, misalnya menampilkan nilai atau menyimpannya dalam array atau variabel
            echo '<input class="color "type="radio" name="pilihan" value="' . $k . '">' . $k . '<br>';
          }
          ?>
        </div>
        <div class="select-size">
          <span>Jumlah:</span>
          <input class="size" type="number" name="quantity" id="quantity" min="1" value="1" max="<?= $row['stok'] ?>">
        </div>
        <!--BUTTON-->
        <?php
        if ($b != null) {
        ?>
          <button type="submit" class="btn" name="add_to_bag"><i class="bi bi-cart"></i> Cart</button>
        <?php
        } else {
        ?>
          <button class="btn" name="back"><i class="bi bi-house"></i>cart</button>
        <?php
        }
        ?>
      </form>
      <a href="product.php"><button class="btn" name="back"><i class="bi bi-house"></i> Home</button></a>
    </div>
  </div>
<?php
    if (isset($_POST['add_to_bag'])) {
      $p_id = $_GET['p_id'];
      $gambar = $row['gambar'];
      $nama = $row['nama'];
      $pilihan = $_POST['pilihan'];
      $quantity = $_POST['quantity'];
      $hargasatuan = $row['harga'];
      $hargatotal = $quantity * $hargasatuan;

      $sql = $connection->query("SELECT * FROM keranjang WHERE p_nama = '$nama' AND pemesan = '$b'");
      $keranjang = $sql->fetch_assoc();
      if ($sql->num_rows > 0) {
        $hasil = $quantity;
        $hargabaru = $hasil * $hargasatuan;
        $sql = $connection->query("UPDATE keranjang SET p_quantity = '$hasil' WHERE p_nama = '$nama'");
        $sql = $connection->query("UPDATE keranjang SET harga_total = '$hargabaru' WHERE p_nama = '$nama'");
        $sql = $connection->query("UPDATE keranjang SET p_pilihan = '$pilihan' WHERE p_nama = '$nama'");
        echo "<script>alert('Berhasil dimasukkan kedalam keranjang');document.location.href='../page/product.php';</script>";
      } else {
        $sql = "INSERT into keranjang values ('','$b','$p_id','$gambar','$nama','$pilihan','$quantity','$hargasatuan','$hargatotal')";
        $q1 = mysqli_query($connection, $sql);
        echo "<script>alert('Berhasil dimasukkan kedalam keranjang');document.location.href='../page/product.php';</script>";
      }
    }
    if (isset($_POST['back'])) {
      header('location:../login.php');
    }
  }
}

function keranjang($a, $b)
{
  global $connection;
?>

<div class="row">
  <div class="col-lg-7">
    <h5 class="mb-3"><a href="../page/profile.php" class="text-body"><i class="fas fa-long-arrow-alt-left me-2"></i>Kembali</a></h5>
    <hr>
    <div class="d-flex justify-content-between align-items-center mb-4">
      <?php
      $sql = "SELECT pemesan, COUNT(*) AS jumlah_barang FROM keranjang WHERE pemesan = '$a'";
      $result = $connection->query($sql);

      if ($result->num_rows > 0) {
        // Tampilkan hasil
        while ($get = $result->fetch_assoc()) {
          $jumlah_barang = $get["jumlah_barang"];
      ?>
          <div>
            <p class="mb-1">Shopping cart</p>
            <p class="mb-0">You have <?= $jumlah_barang ?> items in your cart</p>
          </div>
      <?php
        }
      }
      ?>
    </div>
    <?php
    $sql = "SELECT * FROM keranjang where pemesan = '$a'";
    $q = mysqli_query($connection, $sql);
    $total = 0;
    $items = array(); // Array untuk menyimpan nilai item


    while ($row = mysqli_fetch_array($q)) {
      $id_cart = $row['id_keranjang'];
      $id = $row['p_id'];
      // Menampilkan data dalam tabel
    ?>
      <div class="card mb-3">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div class="d-flex flex-row align-items-center">
              <div>
                <img src="../image/FotoProduk/<?= $row['p_gambar'] ?>" class="img-fluid rounded-3" alt="Shopping item" style="width: 65px;">
              </div>
              <div class="ms-3">
                <h5><?= $row['p_nama'] ?></h5>
                <p class="small mb-0"><?= $row['p_pilihan'] ?></p>
              </div>
            </div>
            <div class="d-flex flex-row align-items-center">
              <div style="width: 150px;">
                <h5 class="fw-normal mb-0"><?= $row['p_quantity'] ?> x Rp.<?= $row['harga_satuan'] ?></h5>
              </div>
              <div style="width: 120px;">
                <h5 class="mb-0">Rp.<?= $row['harga_total'] ?></h5>
              </div>
              <div style="width: 50px;">
                <a href="../page/product_detail.php?p_id=<?= $id ?>" style="color: #cecece;"><i class="fas fa-pen-alt"></i></a>
                <a href="../page/cart.php?p_id=<?= $id_cart ?>&op=hapus&pemesan=<?= $a ?>" style="color: #cecece;"><i class="fas fa-trash-alt"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php
      // Menjumlahkan nilai total
      $total += $row['harga_total'];

      // Menyimpan nilai item
      $items[] = $row['p_nama'] . ' - ' . $row['p_pilihan'] . ' - ' . $row['p_quantity'];
    }

    // Menggabungkan nilai item menjadi satu string
    $itemsString = implode(', ', $items);
    ?>
  </div>
  <div class="col-lg-5">

    <div class="card bg-primary text-white rounded-3">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h5 class="mb-0">Detail Penerima</h5>
          <img src="https://cdn-icons-png.flaticon.com/512/2815/2815428.png" class="img-fluid rounded-3" style="width: 45px;" alt="Avatar">
        </div>

        <form class="mt-4" method="post">
          <div class="form-outline form-white mb-4">
            <input type="text" id="typeName" name="nama" value="" class="form-control form-control-lg" siez="17" placeholder="Full name" required />
            <label class="form-label" for="typeText">Nama Penerima</label>
          </div>

          <div class="form-outline form-white mb-4">
            <input type="text" id="typeText" name="nomor" value="" class="form-control form-control-lg" siez="17" placeholder="08" minlength="11" maxlength="13" required />
            <label class="form-label" for="typeText">Nomor Hp (aktif)</label>
          </div>

          <div class="row mb-4">
            <div class="col-md-6">
              <div class="form-outline form-white">
                <input type="text" id="typeText" name="alamat" value="" class="form-control form-control-lg" placeholder="" size="7" required />
                <label class="form-label" for="typeExp">Alamat</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-outline form-white">
                <input type="text" id="typeText" name="kota" value="" class="form-control form-control-lg" placeholder="" size="1" required />
                <label class="form-label" for="typeText">Kota/Kabupaten</label>
              </div>
            </div>
          </div>
          <hr class="my-4">

          <div class="d-flex justify-content-between">
            <p class="mb-2">Subtotal</p>
            <p class="mb-2">Rp.<?= $total ?></p>
          </div>

          <div class="d-flex justify-content-between mb-4">
            <p class="mb-2">Total(Incl. taxes)</p>
            <p class="mb-2">Rp.<?= $total ?></p>
          </div>
          <button type="submit" name="checkout" class="btn btn-info btn-block btn-lg">
            <div class="d-flex justify-content-between">
              <span>Rp.<?= $total ?></span>
              <span>Checkout <i class="fas fa-long-arrow-alt-right ms-2"></i></span>
            </div>
          </button>
        </form>
      </div>
    </div>

  </div>
  <?php
  if (isset($_POST['checkout'])) {
    $sql = "SELECT * FROM keranjang where pemesan = '$a'";
    $result = $connection->query($sql);

    $about = mysqli_query($connection, "SELECT * FROM company");
    while ($row = mysqli_fetch_array($about)) {
      $company_no = $row['nomor_telp'];
    }

    if ($result->num_rows > 0) {
      // Menampilkan daftar barang dan mengurangi stoknya
      while ($row = $result->fetch_assoc()) {
        $idBarang = $row["p_id"];
        $jumlahPesan = $row["p_quantity"];

        // Mendapatkan stok barang dari database
        $sqlStok = "SELECT stok FROM produk WHERE p_id = '$idBarang' FOR UPDATE";
        $resultStok = $connection->query($sqlStok);

        if ($resultStok->num_rows > 0) {
          $rowStok = $resultStok->fetch_assoc();
          $stokBarang = $rowStok["stok"];

          // Validasi jumlah pesanan dengan stok yang tersedia
          if ($jumlahPesan <= $stokBarang) {
            // Mengurangi stok barang
            $stokBarang -= $jumlahPesan;

            $nama = $_POST['nama'];
            $nomor = $_POST['nomor'];
            $alamat = $_POST['alamat'];
            $kota = $_POST['kota'];
            $penerima = $nama . ',' . $nomor;
            $address = $alamat . ',' . $kota;
            $get = "SELECT * FROM histori where id_pemesan = '$a' ORDER BY id_invoice DESC LIMIT 1 ";
            $result = mysqli_query($connection, $get);
            if (mysqli_num_rows($result)) {
              if ($row = mysqli_fetch_assoc($result)) {
                $id_pesanan = $row['id_invoice'];
                $get_number = str_replace("ORD" . $b, "", $id_pesanan);
                $id_increase = $get_number + 1;
                $get_string = str_pad($id_increase, 5, 0, STR_PAD_LEFT);
                $id_baru = "ORD" . $b . $get_string;
                $query = "INSERT INTO histori (id_invoice,id,id_pemesan,nama_penerima,alamat_penerima,barang_pesanan,total_harga,acc) VALUES ('$id_baru','','$a','$penerima','$address','$itemsString', '$total','Menunggu')";
                $result = mysqli_query($connection, $query);
                // Update stok barang di database
                $sqlUpdateStok = "UPDATE produk SET stok = $stokBarang WHERE p_id = '$idBarang'";
                $connection->query($sqlUpdateStok);
                $sql = "DELETE FROM keranjang where pemesan = '$a'";
                $result = mysqli_query($connection, $sql);
                echo "<script>alert('Berhasil Checkout');window.open('https://api.whatsapp.com/send/?phone=62$company_no&text=Nomor%20Orderan%20:%20$id_baru%0ANama%20Penerima%20:%20$penerima%0AAlamat%20:%20$address%0AOrder%20:%20$itemsString%0AHarga%20:%20Rp%20$total%20', '_blank');window.location.href = '../page/product.php';</script>";
              }
            } else {
              $id_baru = "ORD" . $b . "00001";
              $query = "INSERT INTO histori (id_invoice,id,id_pemesan,nama_penerima,alamat_penerima,barang_pesanan,total_harga,acc) VALUES ('$id_baru','','$a','$penerima','$address','$itemsString', '$total','Menunggu')";
              $result = mysqli_query($connection, $query);
              // Update stok barang di database
              $sqlUpdateStok = "UPDATE produk SET stok = $stokBarang WHERE p_id = '$idBarang'";
              $connection->query($sqlUpdateStok);
              $sql = "DELETE FROM keranjang where pemesan = '$a'";
              $result = mysqli_query($connection, $sql);
              echo "<script>alert('Berhasil Checkout');window.open('https://api.whatsapp.com/send/?phone=62$company_no&text=Nomor%20Orderan%20:%20$id_baru%0ANama%20Penerima%20:%20$penerima%0AAlamat%20:%20$address%0AOrder%20:%20$itemsString%0AHarga%20:%20Rp%20$total%20', '_blank');window.location.href = '../page/product.php';</script>";
            }
          }
        }
      }
    }
  }
  ?>
</div>
<?php
}

function invoice_list($a)
{
  global $connection;
  $sql = "SELECT * FROM histori WHERE id_pemesan = '$a'";
  $result = $connection->query($sql);

  if ($result->num_rows > 0) {
    // Tampilkan hasil
    while ($row = $result->fetch_assoc()) {

?>
    <div class="card mb-3">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div class="d-flex flex-row align-items-center">
            <div class="ms-3">
              <h5><?= $row['id_invoice'] ?></h5>
            </div>
            <div class="ms-3" style="width: 200px">
              <?php
              if ($row['acc'] == 'Dikonfirmasi') {
              ?>
                <a href="" style="color: white;" class="btn btn-success"><i class="far fa-circle-check"></i> Terkonfirmasi</a>
              <?php
              } else
                        if ($row['acc'] == 'Menunggu') {
              ?>
                <a href="" style="color: white;" class="btn btn-warning"><i class="fas fa-question"></i> Menunggu</a>
              <?php
              } else
                        if ($row['acc'] == 'DiBatalkan') {
              ?>
                <a href="" style="color: white;" class="btn btn-danger"><i class="fas fa-skull-crossbones"></i> Dibatalkan</a>
              <?php
              } else
              if ($row['acc'] == 'Ditolak') {
              ?>
                <a href="" style="color: white;" class="btn btn-danger"><i class="fas fa-skull-crossbones"></i> Ditolak</a>
              <?php
              }
              ?>
            </div>
          </div>
          <div class="d-flex flex-row align-items-center">
            <div style="width: 120px;">
              <h5 class="mb-0">Rp.<?= $row['total_harga'] ?></h5>
            </div>
            <a href="../page/invoice-detail.php?id_invoice=<?= $row['id_invoice'] ?>&id_pemesan=<?= $a ?>" style="color: black;"><i class="fas fa-circle-info"></i> Detail</a>
          </div>
        </div>
      </div>
    </div>
<?php
    }
  }
}

function card_profil($a, $b)
{
?>
<div class="card-container">
  <img class="round" src="https://cdn-icons-png.flaticon.com/512/2815/2815428.png" alt="user" />
  <h3><?= $a ?></h3>
  <h6><?= $b ?></h6>
  <p> <a href="../index.php" class="nav-link"><button class="primary ghost">Home</button></a> </p>
  <div class="buttons">
    <?php
    global $connection;
    $sql = "SELECT pemesan, COUNT(*) AS jumlah_barang FROM keranjang WHERE pemesan = '$a'";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
      // Tampilkan hasil
      while ($get = $result->fetch_assoc()) {
        $jumlah_barang = $get["jumlah_barang"];
    ?>
        <a href="../page/cart.php" class="nav-link"><button class="primary">Keranjang <br> [ <?= $jumlah_barang ?> ] Items </button></a>
      <?php
      }
    }
    $sql = "SELECT id_pemesan, COUNT(*) AS jumlah_invoice FROM histori WHERE id_pemesan = '$a'";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
      // Tampilkan hasil
      while ($get = $result->fetch_assoc()) {
        $jumlah_invoice = $get["jumlah_invoice"];
      ?>
        <a href="../page/invoice.php" class="nav-link"><button class="primary">Histori Pesanan <br> [ <?= $jumlah_invoice ?> ] Items </button></a>
    <?php
      }
    }
    ?>
  </div>
  <div class="skills">
  </div>
</div>
<?php
}


function kepala1($nama)
{
?>
  <header>
    <div class="company-logo" style="font-weight: bold;">
      <img src="../image/logo/vapetime.png" style="width: 80px; height: 80px; ;">
    </div>
    <nav class="navbar">
      <ul class="nav-items">
        <form class="d-flex" method="POST">
          <input name="cari" class="form-control me-2" type="text" placeholder="Cari disini...">
          <input type="submit" name="btnCari" class="btn btn-warning" value="Cari">
        </form>
        <li class="nav-item"><a href="../index.php" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="product.php" class="nav-link">Product</a></li>
        <?php
        if ($nama != null) {
        ?>
          <li class="nav-item"><a href="profile.php" class="nav-link"><i class="bi bi-person-fill"></i> <?= $nama ?></a></li>
          <li class="nav-item"><a href="../logout.php" class="nav-link"><i class="bi bi-box-arrow-in-left"></i></i> Keluar</a></li>
        <?php
        } else {
        ?>
          <li class="nav-item"><a href="../login.php" class="nav-link"><i class="bi bi-box-arrow-in-right"></i></i></i> Login</a></li>
        <?php
        }
        ?>

      </ul>
    </nav>
  </header>
  <?php
  if (isset($_POST['btnCari'])) {
    $cari = $_POST['cari'];
    echo '<script>location.replace("../page/product.php?search=' . $cari . '");</script>';
  }
}

function nav()
{
  ?>
  <nav class="navbar">

    <?php
    global $connection;
    $get = "SELECT * FROM categori ORDER BY nama desc";
    $hasil = mysqli_query($connection, $get);
    while ($row = mysqli_fetch_array($hasil)) {
      $kategori = $row['nama'];
    ?>
      <ul class="nav-items">
        <li class="nav-item" style="font-weight: bold;"><a href="../page/product.php?search=<?= $kategori ?>" class="nav-link"><?= $kategori ?></a></li>
      </ul>
    <?php
    }
    ?>

  </nav>
<?php
}

function footer()
{
?>
  <div class="container end-footer">
    <div class="copyright">copyright © 2023 - Present • <b>MANAJEMEN INFORMATIKA</b></div>
    <a class="designer" href="#">Karpat group</a>
  </div>
<?php
}


?>