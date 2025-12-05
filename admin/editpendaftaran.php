<!DOCTYPE html>
<html>

  <?php
  ob_start();
  session_start();
  if(!isset($_SESSION['useremail'])) 
      header("Location: login.php");
  ?>

<?php
    include "bagiankode/head.php";
    ?>
    <body class="sb-nav-fixed">
        <?php
        include "bagiankode/menunav.php";
        ?>
        <div id="layoutSidenav">  
            <?php
            include "bagiankode/menu.php";
            ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Pendaftaran</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
<?php
include("includes/config.php");

$pendaftaran_ID = $_GET["ubahpendaftaran"];

// Ambil data pendaftaran yang akan diedit
$edit = mysqli_query($conn, "SELECT * FROM pendaftaranwisuda WHERE pendaftaran_ID = '$pendaftaran_ID'");
$row_edit = mysqli_fetch_array($edit);

// Ambil data mahasiswa
$editmhs = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE mhs_NPM = '".$row_edit['mhs_NPM']."'");
$row_edit2 = mysqli_fetch_array($editmhs);

// Ambil data jadwal
$editjadwal = mysqli_query($conn, "SELECT * FROM jadwalwisuda WHERE jadwal_ID = '".$row_edit['jadwal_ID']."'");
$row_edit3 = mysqli_fetch_array($editjadwal);

if(isset($_POST['Ubah'])) 
{
    $pendaftaran_ID_new = $_POST['idPendaftaran'];
    $mhs_NPM = $_POST['npmMHS'];
    $jadwal_ID = $_POST['idJadwal'];
    $tanggal_daftar = $_POST['tanggalDaftar'];
    $status_bayar = $_POST['statusBayar'];
    
    mysqli_query($conn, "UPDATE pendaftaranwisuda SET pendaftaran_ID = '$pendaftaran_ID_new', mhs_NPM = '$mhs_NPM', jadwal_ID = '$jadwal_ID', tanggal_daftar = '$tanggal_daftar', statusbayar = '$status_bayar' WHERE pendaftaran_ID = '$pendaftaran_ID'");
    
    header("location:inputpendaftaran.php");
}

/** pencarian data */
if(isset($_POST["kirim"]))
{
    $search = $_POST["search"];
    $query = mysqli_query($conn, "SELECT * FROM pendaftaranwisuda, mahasiswa 
        WHERE mahasiswa.mhs_NPM = pendaftaranwisuda.mhs_NPM
        AND pendaftaranwisuda.pendaftaran_ID LIKE '%".$search."%'");
}
else
{
    $query = mysqli_query($conn, "SELECT * FROM pendaftaranwisuda, mahasiswa 
        WHERE mahasiswa.mhs_NPM = pendaftaranwisuda.mhs_NPM");
}
/** end pencarian data */

// Ambil data mahasiswa yang sudah lulus
$datalulusan = mysqli_query($conn, "SELECT lulusan.mhs_NPM, mahasiswa.mhs_Nama FROM lulusan, mahasiswa WHERE lulusan.mhs_NPM = mahasiswa.mhs_NPM");

// Ambil data jadwal wisuda
$datajadwal = mysqli_query($conn, "SELECT jadwal_ID, Periode, Tanggal_Wisuda FROM jadwalwisuda");
?>

  <div class="row">
  <div class="col-1"></div>
  <div class="col-10">
    <form method="POST">
  <div class="row mb-3 mt-5">
    <label for="idPendaftaran" class="col-sm-2 col-form-label">ID Pendaftaran</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="idPendaftaran" name="idPendaftaran" placeholder="ID Pendaftaran" value="<?php echo $row_edit['pendaftaran_ID']?>">
    </div>
  </div>

  <div class="row mb-3">
    <label for="npmMHS" class="col-sm-2 col-form-label">NPM Mahasiswa</label>
    <div class="col-sm-10">
  <select class="form-control" id="npmMHS" name="npmMHS">
    <option value="<?php echo $row_edit['mhs_NPM']?>">
      <?php echo $row_edit['mhs_NPM']?> - <?php echo $row_edit2['mhs_Nama']?>
    </option>
    <?php while($row = mysqli_fetch_array($datalulusan))
    { ?>
    <option value="<?php echo $row["mhs_NPM"]?>">
      <?php echo $row["mhs_NPM"]?> - <?php echo $row["mhs_Nama"]?>
    </option>
    <?php } ?>
  </select>
</div>
</div>

<div class="row mb-3">
    <label for="idJadwal" class="col-sm-2 col-form-label">Jadwal Wisuda</label>
    <div class="col-sm-10">
      <select class="form-control" id="idJadwal" name="idJadwal">
        <option value="<?php echo $row_edit['jadwal_ID']?>">
          <?php echo $row_edit['jadwal_ID']?> - <?php echo $row_edit3['Periode']?> (<?php echo $row_edit3['Tanggal_Wisuda']?>)
        </option>
        <?php while($row2 = mysqli_fetch_array($datajadwal))
        { ?>
        <option value="<?php echo $row2["jadwal_ID"]?>">
          <?php echo $row2["jadwal_ID"]?> - <?php echo $row2["Periode"]?> (<?php echo $row2["Tanggal_Wisuda"]?>)
        </option>
        <?php } ?>
      </select>
    </div>
</div>

<div class="row mb-3">
    <label for="tanggalDaftar" class="col-sm-2 col-form-label">Tanggal Daftar</label>
    <div class="col-sm-10">
      <input type="date" class="form-control" id="tanggalDaftar" name="tanggalDaftar" value="<?php echo $row_edit['tanggal_daftar']?>">
    </div>
</div>

<div class="row mb-3">
    <label for="statusBayar" class="col-sm-2 col-form-label">Status Bayar</label>
    <div class="col-sm-10">
      <select class="form-control" id="statusBayar" name="statusBayar">
        <option value="<?php echo $row_edit['statusbayar']?>"><?php echo $row_edit['statusbayar']?></option>
        <option value="Lunas">Lunas</option>
        <option value="Belum Lunas">Belum Lunas</option>
      </select>
    </div>
</div>

<div class="form-group row">
  <div class="col-2"></div>
  <div class="col-10">
    <input type="submit" class="btn btn-primary" value="Ubah" name="Ubah">
    <input type="reset" class="btn btn-danger" value="Batal" name="Batal">
  </div>
</div>
</form>

   <div class="col-1"></div>
        </div> </div>
        </div>

        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                <div class="jumbotron mt-5 mb-3">
                    <h1 class="display-5">Daftar Pendaftaran Wisuda</h1>
                </div>

                <!--form pencarian data-->
                <form method="POST">
                <div class="form-group row mt-5 mb-3">
                <label for="search" class="col-sm-2">Cari ID Pendaftaran</label>
                <div class="col-sm-6">
                <input type="text" name="search" class="form-control" id="search"
                value="<?php if(isset($_POST["search"]))
                {echo $_POST["search"];}?>" placeholder="Cari ID Pendaftaran">
                </div>
                <input type="submit" name="kirim" value="Cari" class="col-sm-1 btn btn-primary">
                </div>
                </form>
                <!--end pencarian data-->

                <table class="table table-striped table-success table-hover">
                    <tr class="info"> 
                        <th>ID Pendaftaran</th>
                        <th>NPM</th>
                        <th>Nama Mahasiswa</th>
                        <th>ID Jadwal</th>
                        <th>Tanggal Daftar</th>
                        <th>Status Bayar</th>
                        <th colspan="2" style="text-align: center;">Aksi</th>
                    </tr>

                    <?php { ?>
                    <?php while ($row = mysqli_fetch_array($query))
                    { ?>
                        <tr class="danger">
                            <td><?php echo $row['pendaftaran_ID']; ?> </td>
                            <td><?php echo $row['mhs_NPM']; ?> </td>
                            <td><?php echo $row['mhs_Nama']; ?> </td>
                            <td><?php echo $row['jadwal_ID']; ?> </td>
                            <td><?php echo $row['tanggal_daftar']; ?> </td>
                            <td><?php echo $row['statusbayar']; ?> </td>
                            <td>
                              <a href="editpendaftaran.php?ubahpendaftaran=<?php echo $row["pendaftaran_ID"]?>" class="btn btn-success" title="EDIT">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                              <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                              <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                              </svg>
                              </a>
                            </td>
                            <td>
                              <a href="hapuspendaftaran.php?hapuspendaftaran=<?php echo $row["pendaftaran_ID"]?>" class="btn btn-danger" title="HAPUS" onclick="return confirm('Apakah Anda yakin ingin menghapus data pendaftaran ini?')">
                              <i class="bi bi-trash3"></i>
                              </a>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php } ?>
</table>
  </div><!--penutup class col-10 untuk tabel -->
</div><!--penutup class row untuk tabel -->

                </main>
                <?php
                include "bagiankode/footer.php";
                ?>
            </div>
        </div>
        <?php
        include "bagiankode/jsscript.php";
        ?>
    </body>

</html>