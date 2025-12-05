<?php
include 'config.php';

$query = mysqli_query($conn, "SELECT dosen_Nama FROM dosen");
$dosen = [];
while ($row = mysqli_fetch_assoc($query)) {
    $dosen[] = $row;
}

$query = mysqli_query($conn, "SELECT mhs_Nama FROM mahasiswa");
$mahasiswa = [];
while ($row = mysqli_fetch_assoc($query)) {
    $mahasiswa[] = $row;
}

$query = mysqli_query($conn, "SELECT peserta_PENJELASAN FROM pesertaskripsi");
$pesertaskripsi = [];
while ($row = mysqli_fetch_assoc($query)) {
    $pesertaskripsi[] = $row;
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="images/logountar.png" alt="Profil" style="width: 100%px; height: 32px;">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="includes/peta.html" target="_blank">Peta</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dosen
          </a>
          <ul class="dropdown-menu">
            <?php foreach($dosen as $d): ?>
              <li><a class="dropdown-item" href="#"><?= $d['dosen_Nama']; ?></a></li>
              <?php endforeach; ?>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Mahasiswa
          </a>
          <ul class="dropdown-menu">
            <?php foreach($mahasiswa as $m): ?>
              <li><a class="dropdown-item" href="#"><?= $m['mhs_Nama']; ?></a></li>
              <?php endforeach; ?>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Bidang
          </a>
          <ul class="dropdown-menu">
            <?php foreach($pesertaskripsi as $ps): ?>
              <li><a class="dropdown-item" href="#"><?= $ps['peserta_PENJELASAN']; ?></a></li>
              <?php endforeach; ?>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>

<script>
document.querySelectorAll('.nav-item.dropdown').forEach(function(item) {
    item.addEventListener('mouseover', function() {
        let menu = this.querySelector('.dropdown-menu');
        menu.classList.add('show');
    });

    item.addEventListener('mouseout', function() {
        let menu = this.querySelector('.dropdown-menu');
        menu.classList.remove('show');
    });
});
</script>