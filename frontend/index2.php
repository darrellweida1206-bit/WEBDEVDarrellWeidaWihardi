<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-new.css">

</head>
<body>

    <!--membuat tampilan menu-->
    <?php include("includes/frontmenu.php"); ?>
    <!--akhir membuat tampilan menu-->

    <!--membuat tampilan slider-->
<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/upacara.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Universitas Tarumanagara</h5>
        <p>"Universitas Tarumanagara adalah pusat pendidikan unggul yang membentuk generasi berintegritas dan profesional di masa depan."</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images/gedung.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Universitas Tarumanagara</h5>
        <p>Jalan Letjen S. Parman No. 1, Grogol Petamburan, Jakarta Barat, 11440.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images/wisuda1.jpeg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>85th Graduation Ceremony Universitas Tarumanagara</h5>
        <p>Selamat atas suksesnya Wisuda ke-85 yang menjadi penanda dimulainya babak baru penuh harapan bagi para lulusan.</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
    <!--akhir membuat tampilan slider-->

    <!--membuat halaman web lengkap-->
<div class="container">
  <div class="row atas mt-5">
    <div class="col-sm-8">

      <?php
      $q = mysqli_query($conn, "SELECT * FROM pesertaskripsi, mahasiswa WHERE pesertaskripsi.mhs_NPM = mahasiswa.mhs_NPM LIMIT 2  ");

      while($row = mysqli_fetch_assoc($q)) {
      ?>
        <div class="d-flex mb-4">
          <div class="flex-shrink-0">
            <img src="images/<?php echo $row['peserta_DOKUMEN']; ?>" width="150px" height="170px" alt="..." style="object-fit:cover; object-position:top">
          </div>
          <div class="flex-grow-1 ms-3" style="margin-left: 10px; text-align: justify;">
            <h2><?php echo $row['mhs_Nama'];?></h2>
            <p>
              Terdaftar pada semester <?php echo $row['peserta_SEMT']; ?><br>
              Tahun akademik <?php echo $row['peserta_THAKD']; ?><br>
              Tanggal daftar <?php echo $row['peserta_TGLDAFTAR']; ?><br>
              Penjelasan: <?php echo $row['peserta_PENJELASAN'];?>
            </p>
          </div>
        </div>
      <?php
      }
      ?>
    </div>

    <div class="col-sm-4">
  <div class="list-group">
    <?php 
    $u = mysqli_query($conn, "SELECT * FROM ujianskripsi, dosen, mahasiswa, pesertaskripsi, bimbingan WHERE mahasiswa.mhs_NPM = ujianskripsi.mhs_NPM AND pesertaskripsi.mhs_NPM = ujianskripsi.mhs_NPM AND bimbingan.mhs_NPM = ujianskripsi.mhs_NPM 
        AND dosen.dosen_NIDN = bimbingan.dosen_NIDN");

    // Data pertama (active/maroon)
    $row1 = mysqli_fetch_assoc($u);
    if($row1) {
    ?>
    <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
        <div class="d-flex w-100 justify-content-between">
          <h5 class="mb-1">NPM: <?php echo $row1['mhs_NPM']; ?></h5>
          <small><?php echo $row1['ujian_TGL']; ?> | <?php echo $row1['ujian_WAKTU']; ?></small>
        </div>
      <p class="mb-1">Nama: <?php echo $row1['mhs_Nama']; ?></p>
      <small>Pembimbing: <?php echo $row1['dosen_Nama']; ?></small>
    </a>
    <?php 
  } 
  ?>
    
    <?php 
    // Data kedua (putih)
    $row2 = mysqli_fetch_assoc($u);
    if($row2) {
    ?>
    <a href="#" class="list-group-item list-group-item-action">
        <div class="d-flex w-100 justify-content-between">
          <h5 class="mb-1">NPM: <?php echo $row2['mhs_NPM']; ?></h5>
          <small class="text-muted"><?php echo $row2['ujian_TGL']; ?> | <?php echo $row2['ujian_WAKTU']; ?></small>
        </div>
      <p class="mb-1">Nama: <?php echo $row2['mhs_Nama']; ?></p>
      <small class="text-muted">Pembimbing: <?php echo $row2['dosen_Nama']; ?></small>
    </a>
    <?php 
  } 
  ?>
    
    <?php 
    // Data ketiga (putih)
    $row3 = mysqli_fetch_assoc($u);
    if($row3) {
    ?>
    <a href="#" class="list-group-item list-group-item-action">
        <div class="d-flex w-100 justify-content-between">
          <h5 class="mb-1">NPM: <?php echo $row3['mhs_NPM']; ?></h5>
          <small class="text-muted"><?php echo $row3['ujian_TGL']; ?> | <?php echo $row3['ujian_WAKTU']; ?></small>
        </div>
      <p class="mb-1">Nama: <?php echo $row3['mhs_Nama']; ?></p>
      <small class="text-muted">Pembimbing: <?php echo $row3['dosen_Nama']; ?></small>
    </a>
    <?php 
  } 
  ?>
  </div>
</div>
</div> <!-- penutup class row atas -->
<br>

  <!--membuat galeri foto-->
<div class="row g-4">
  <!-- Kolom Kiri: Galeri Foto (4 gambar) -->
  <div class="col-lg-8">
    <h1 class="mt-15, mb-15" style="text-align: left">Ujian Skripsi</h1>
    <div class="galerifoto row g-4">
      <?php
          $g = mysqli_query($conn, "SELECT * FROM ujianskripsi, mahasiswa, pesertaskripsi
            WHERE mahasiswa.mhs_NPM = ujianskripsi.mhs_NPM 
            AND pesertaskripsi.mhs_NPM = ujianskripsi.mhs_NPM LIMIT 4");

          while($row = mysqli_fetch_assoc($g)) {
          ?>
            <figure class="col-lg-6 col-sm-6 col-xs-12">
              <img style="width: 100%; height: 230px;" src="images/<?php echo $row['ujian_FOTO'];?>" class="figure-img img-fluid rounded" alt="..." style="object-fit:cover">
              <figcaption class="figure-caption text-end">Judul Skripsi: <?php echo $row['peserta_JUDUL'];?></figcaption>
            </figure>
          <?php
          }
          ?>
    </div>
  </div>
  
  <!-- Kolom Kanan: Scroll -->
<div class="col-lg-4">
    <h1 class="mt-15, mb-15">Pendaftaran Wisuda</h1>
  <div data-bs-spy="scroll" data-bs-target="#list-example" data-bs-smooth-scroll="true" class="scrollspy-example" tabindex="0">

    <?php
    $pw = mysqli_query($conn, "SELECT * FROM pendaftaranwisuda, mahasiswa, jadwalwisuda
        WHERE mahasiswa.mhs_NPM = pendaftaranwisuda.mhs_NPM AND jadwalwisuda.jadwal_ID = pendaftaranwisuda.jadwal_ID");
    while($row = mysqli_fetch_assoc($pw)) {
    ?>
      <div class="mb-4 p-3">
        <h5>ID: <?php echo $row['pendaftaran_ID']; ?></h5>
        <p>
          <strong>Nama Mahasiswa:</strong> <?php echo $row['mhs_Nama']; ?><br>
          <strong>Tanggal Daftar:</strong> <?php echo $row['tanggal_daftar']; ?><br>
          <strong>Periode Wisuda:</strong> <?php echo $row['Periode'];?>
        </P>
      </div>
    <?php
    }
    ?>
    
  </div>
</div>
</div><!--akhir membuat galeri foto-->
<br>

<h1 class="mt-15, mb-15" style="text-align: center">Lulusan Terbaik</h1>

<!--tengah sampai bawah kiri-->
  <div class="row tengah mt-5">
<?php 
// Query untuk mengambil data lulusan (4 data)
$lulusan = mysqli_query($conn, "SELECT * FROM lulusan, mahasiswa, pesertaskripsi 
    WHERE mahasiswa.mhs_NPM = lulusan.mhs_NPM 
    AND pesertaskripsi.mhs_NPM = lulusan.mhs_NPM
    LIMIT 4");

// Card pertama
$row1 = mysqli_fetch_array($lulusan);
if($row1) {
?>
    <div class="col-lg-4">
<div class="card">
    <img src="images/<?php echo $row1['lulusan_FOTO']; ?>" class="card-img-top" alt="Foto Lulusan">
      <div class="card-body">
        <h5 class="card-title"><?php echo $row1['mhs_Nama']; ?> - <?php echo $row1['mhs_NPM'];?></h5>
        <p class="card-text">IPK: <?php echo $row1['lulusan_IPK']; ?> - <?php echo $row1['lulusan_PREDIKAT']; ?></p>
        <p class="card-text">Judul Skripsi: <?php echo $row1['peserta_JUDUL']; ?></p>
        <a href="#" class="btn btn-primary">Telusuri Lebih Lengkap</a>
      </div>
</div>
    </div>
<?php } ?>

<?php
// Card kedua
$row2 = mysqli_fetch_array($lulusan);
if($row2) {
?>
    <div class="col-lg-4">
<div class="card">
    <img src="images/<?php echo $row2['lulusan_FOTO']; ?>" class="card-img-top" alt="Foto Lulusan">
      <div class="card-body">
        <h5 class="card-title"><?php echo $row2['mhs_Nama']; ?> - <?php echo $row2['mhs_NPM'];?></h5>
        <p class="card-text">IPK: <?php echo $row2['lulusan_IPK']; ?> - <?php echo $row2['lulusan_PREDIKAT']; ?></p>
        <p class="card-text">Judul Skripsi: <?php echo $row2['peserta_JUDUL']; ?></p>
        <a href="#" class="btn btn-primary">Telusuri Lebih Lengkap</a>
      </div>
</div>
    </div>
<?php } ?>

<?php
// Card ketiga
$row3 = mysqli_fetch_array($lulusan);
if($row3) {
?>
    <div class="col-lg-4">
<div class="card">
    <img src="images/<?php echo $row3['lulusan_FOTO']; ?>" class="card-img-top" alt="Foto Lulusan">
      <div class="card-body">
        <h5 class="card-title"><?php echo $row3['mhs_Nama']; ?> - <?php echo $row3['mhs_NPM'];?></h5>
        <p class="card-text">IPK: <?php echo $row3['lulusan_IPK']; ?> - <?php echo $row3['lulusan_PREDIKAT']; ?></p>
        <p class="card-text">Judul Skripsi: <?php echo $row3['peserta_JUDUL']; ?></p>
        <a href="#" class="btn btn-primary">Telusuri Lebih Lengkap</a>
      </div>
</div>
    </div>
<?php } ?>
</div> <!-- penutup class row tengah -->

<!-- Bagian atas untuk row ke-4 -->
<div class="row atas mt-5">
  <div class="col-lg-4">
<?php 

$row4 = mysqli_fetch_array($lulusan);
if($row4) {
?>        
<div class="card" style="height: ">
    <img src="images/<?php echo $row4['lulusan_FOTO']; ?>" class="card-img-top" alt="Foto Lulusan" style="height: 447px; object-fit: cover; object-position: top">
      <div class="card-body">
        <h5 class="card-title"><?php echo $row4['mhs_Nama']; ?> - <?php echo $row4['mhs_NPM'];?></h5>
        <p class="card-text">IPK: <?php echo $row4['lulusan_IPK']; ?> - <?php echo $row4['lulusan_PREDIKAT']; ?></p>
        <p class="card-text">Judul Skripsi: <?php echo $row4['peserta_JUDUL']; ?></p>
        <a href="#" class="btn btn-primary">Telusuri Lebih Lengkap</a>
      </div>
</div>
<?php } ?>
  </div>

  <!--horizontal-->
<div class="col-lg-8">
<?php 
// Query untuk mengambil data jadwal wisuda
$wisuda = mysqli_query($conn, "SELECT * FROM jadwalwisuda LIMIT 1");

// Card Horizontal besar
$rowWisuda1 = mysqli_fetch_array($wisuda);
if($rowWisuda1) {
?>
<div class="card mb-3">
    <img src="images/<?php echo $rowWisuda1['Wisuda_FOTO']; ?>" class="card-img-top" alt="Foto Wisuda">
      <div class="card-body">
        <h5 class="card-title"><?php echo $rowWisuda1['Tempat']; ?></h5>
        <p class="card-text">Periode: <?php echo $rowWisuda1['Periode']; ?> - <?php echo $rowWisuda1['Tanggal_Wisuda']; ?></p>
        <a href="#" class="btn btn-primary">Lihat Detail</a>
      </div>
</div>
<?php } ?>

<div class="row">
  <div class="col-md-7">
<?php
$q = mysqli_query($conn, "SELECT * FROM penasihat, mahasiswa, dosen 
    WHERE penasihat.mhs_NPM = mahasiswa.mhs_NPM 
    AND penasihat.dosen_NIDN = dosen.dosen_NIDN 
    LIMIT 1");

$row = mysqli_fetch_assoc($q);
if($row) {
?>
    <div class="card mb-3">
      <div class="row g-0">
        <div class="col-md-6">
          <img src="images/<?php echo $row['penasihat_FILE']; ?>" 
               class="img-fluid rounded-start" alt="Dokumen Penasihat">
        </div>
        <div class="col-md-6">
          <div class="card-body">
            <h6 class="card-title-penasihat">PENASIHAT AKADEMIK</h6>
            <p class="card-text"><strong> Dosen:</strong> <?php echo $row['dosen_Nama']; ?></p>
            <p class="card-text"><strong> Mahasiswa:</strong> <?php echo $row['mhs_Nama']; ?></p>
            <p class="card-text"><strong>Keterangan:</strong> <?php echo $row['penasihat_KET']; ?></p>
          </div>
        </div>
      </div>
    </div>
<?php
}
?>
  </div>

  <div class="col-md-5">
    <div class="card text-white bg-maroon mb-3">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="images/foto_profil.jpg" class="img-fluid rounded-start" alt="Peringatan">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title">825240080</h5>
            <p class="card-text">Darrell Weida Wihardi- SI-C</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
      </div> <!-- penutup col-lg-8 -->
    </div> <!-- penutup class row bawah -->
  </div> <!-- penutup class container -->
<!-- akhir membuat halaman web lengkap -->

</body>
<br>
<footer>
    <p>© 2025 Copyright: Darrell Weida Wihardi</p>
</footer>

<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
</html>