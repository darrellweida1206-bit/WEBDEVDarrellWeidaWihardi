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
                        <h1 class="mt-4">Ujian</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
<?php
include("includes/config.php");

$NPM = $_GET["ubahujian"];

// Ambil data ujian yang akan diedit
$edit = mysqli_query($conn, "SELECT * FROM ujianskripsi WHERE mhs_NPM = '$NPM'");
$row_edit = mysqli_fetch_array($edit);

// Ambil data mahasiswa
$editmhs = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE mhs_NPM = '$NPM'");
$row_edit2 = mysqli_fetch_array($editmhs);

// Ambil data judul skripsi
$editpeserta = mysqli_query($conn, "SELECT * FROM pesertaskripsi WHERE mhs_NPM = '$NPM'");
$row_edit3 = mysqli_fetch_array($editpeserta);

// Ambil data dosen dari bimbingan
$editbimbingan = mysqli_query($conn, "SELECT DISTINCT dosen_NIDN FROM bimbingan WHERE mhs_NPM = '$NPM'");
$row_edit4 = mysqli_fetch_array($editbimbingan);

$editdosen = mysqli_query($conn, "SELECT * FROM dosen WHERE dosen_NIDN = '".$row_edit4['dosen_NIDN']."'");
$row_edit5 = mysqli_fetch_array($editdosen);

if(isset($_POST['Ubah'])) 
{
    $mhs_NPM = $_POST['npmMHS'];
    $ujian_TGL = $_POST['ujianTGL'];
    $ujian_WAKTU = $_POST['ujianWAKTU'];
    
    if($_FILES['ujianFOTO']['name'] != "") {
        $ujian_FOTO = $_FILES['ujianFOTO']['name'];
        $foto_tmp = $_FILES['ujianFOTO']['tmp_name'];
        
        $typefoto = pathinfo($ujian_FOTO, PATHINFO_EXTENSION);
        $ukuranfoto = $_FILES["ujianFOTO"]["size"];
        $path = "images/" . $ujian_FOTO;

        if($ukuranfoto <= 5000000){
            if(($typefoto == "jpg") or ($typefoto == 'png')){
                if(!file_exists($path)){
                    move_uploaded_file($foto_tmp, 'images/'.$ujian_FOTO);
                }
            }
        } else {
          $ujian_FOTO = "";
        }
        
        mysqli_query($conn, "UPDATE ujianskripsi SET mhs_NPM = '$mhs_NPM', ujian_TGL = '$ujian_TGL', ujian_WAKTU = '$ujian_WAKTU', ujian_FOTO = '$ujian_FOTO' WHERE mhs_NPM = '$NPM'");
    } else {
        mysqli_query($conn, "UPDATE ujianskripsi SET mhs_NPM = '$mhs_NPM', ujian_TGL = '$ujian_TGL', ujian_WAKTU = '$ujian_WAKTU' WHERE mhs_NPM = '$NPM'");
    }
    
    header("location:inputujian.php");
}

/** pencarian data */
if(isset($_POST["kirim"]))
{
    $search = $_POST["search"];
    $query = mysqli_query($conn, "SELECT * FROM ujianskripsi, dosen, mahasiswa, pesertaskripsi, bimbingan 
        WHERE mahasiswa.mhs_NPM = ujianskripsi.mhs_NPM 
        AND pesertaskripsi.mhs_NPM = ujianskripsi.mhs_NPM 
        AND bimbingan.mhs_NPM = ujianskripsi.mhs_NPM 
        AND dosen.dosen_NIDN = bimbingan.dosen_NIDN
        AND ujianskripsi.mhs_NPM LIKE '%".$search."%'");
}
else
{
    $query = mysqli_query($conn, "SELECT * FROM ujianskripsi, dosen, mahasiswa, pesertaskripsi, bimbingan 
        WHERE mahasiswa.mhs_NPM = ujianskripsi.mhs_NPM 
        AND pesertaskripsi.mhs_NPM = ujianskripsi.mhs_NPM 
        AND bimbingan.mhs_NPM = ujianskripsi.mhs_NPM 
        AND dosen.dosen_NIDN = bimbingan.dosen_NIDN");
}
/** end pencarian data */

$databimbingan = mysqli_query($conn, "SELECT bimbingan.mhs_NPM, mahasiswa.mhs_Nama, bimbingan.dosen_NIDN, dosen.dosen_Nama, pesertaskripsi.peserta_JUDUL FROM bimbingan, mahasiswa, dosen, pesertaskripsi WHERE bimbingan.mhs_NPM = mahasiswa.mhs_NPM AND bimbingan.dosen_NIDN = dosen.dosen_NIDN AND pesertaskripsi.mhs_NPM = bimbingan.mhs_NPM");
?>

  <div class="row">
  <div class="col-1"></div>
  <div class="col-10">
    <form method="POST" enctype="multipart/form-data">
  <div class="row mb-3 mt-5">
    <label for="npmMHS" class="col-sm-2 col-form-label">NPM Mahasiswa</label>
    <div class="col-sm-10">
  <select class="form-control" id="npmMHS" name="npmMHS">
    <option value="<?php echo $row_edit['mhs_NPM']?>">
      <?php echo $row_edit['mhs_NPM']?> - 
      <?php echo $row_edit2['mhs_Nama']?> - 
      NIDN: <?php echo $row_edit4['dosen_NIDN']?>
    </option>
    <?php while($row = mysqli_fetch_array($databimbingan))
    { ?>
    <option value="<?php echo $row["mhs_NPM"]?>">
      <?php echo $row["mhs_NPM"]?> - 
      <?php echo $row["mhs_Nama"]?> - 
      NIDN: <?php echo $row['dosen_NIDN']?>
    </option>
    <?php } ?>
  </select>
</div>
</div>

<div class="row mb-3">
    <label for="ujianTGL" class="col-sm-2 col-form-label">Tanggal Ujian</label>
    <div class="col-sm-10">
      <input type="date" class="form-control" id="ujianTGL" name="ujianTGL" value="<?php echo $row_edit['ujian_TGL']?>">
    </div>
</div>

<div class="row mb-3">
    <label for="ujianWAKTU" class="col-sm-2 col-form-label">Waktu Ujian</label>
    <div class="col-sm-10">
      <input type="time" class="form-control" id="ujianWAKTU" name="ujianWAKTU" value="<?php echo $row_edit['ujian_WAKTU']?>" placeholder="Contoh: 09:00">
    </div>
</div>

<div class="row mb-3">
    <label for="ujianFOTO" class="col-sm-2 col-form-label">Unggah Foto Ujian</label>
    <div class="col-sm-10">
      <input type="file" class="form-control" id="ujianFOTO" name="ujianFOTO" accept=".jpg,.jpeg,.png">
      <p class="help-block">File saat ini: <?php echo $row_edit['ujian_FOTO']?></p>
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
                    <h1 class="display-5">Daftar Ujian Skripsi</h1>
                </div>

                <!--form pencarian data-->
                <form method="POST">
                <div class="form-group row mt-5 mb-3">
                <label for="search" class="col-sm-2">Cari NPM Mahasiswa</label>
                <div class="col-sm-6">
                <input type="text" name="search" class="form-control" id="search"
                value="<?php if(isset($_POST["search"]))
                {echo $_POST["search"];}?>" placeholder="Cari NPM Mahasiswa">
                </div>
                <input type="submit" name="kirim" value="Cari" class="col-sm-1 btn btn-primary">
                </div>
                </form>
                <!--end pencarian data-->

                <table class="table table-striped table-success table-hover">
                    <tr class="info"> 
                        <th>NPM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Judul Skripsi</th>
                        <th>NIDN</th>
                        <th>Nama Dosen</th>
                        <th>Tanggal Ujian</th>
                        <th>Waktu Ujian</th>
                        <th>Foto</th>
                        <th colspan="2" style="text-align: center;">Aksi</th>
                    </tr>

                    <?php { ?>
                    <?php while ($row = mysqli_fetch_array($query))
                    { ?>
                        <tr class="danger">
                            <td><?php echo $row['mhs_NPM']; ?> </td>
                            <td><?php echo $row['mhs_Nama']; ?> </td>
                            <td><?php echo $row['peserta_JUDUL']; ?> </td>
                            <td><?php echo $row['dosen_NIDN']; ?> </td>
                            <td><?php echo $row['dosen_Nama']; ?> </td>
                            <td><?php echo $row['ujian_TGL'] ?> </td>
                            <td><?php echo $row['ujian_WAKTU'] ?> </td>
                            <td>
                              <?php if($row['ujian_FOTO'] == "") { ?>
                                <img src='images/No_Image_Available.jpg' width='88'/>
                              <?php } else { ?>
                                <img src="images/<?php echo $row['ujian_FOTO'] ?>" width="88" class="img-responsive">
                              <?php }?>
                            </td>
                            <td>
                              <a href="editujian.php?ubahujian=<?php echo $row["mhs_NPM"]?>" class="btn btn-success" title="EDIT">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                              <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                              <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                              </svg>
                              </a>
                            </td>
                            <td>
                              <a href="hapusujian.php?hapusujian=<?php echo $row["mhs_NPM"]?>" class="btn btn-danger" title="HAPUS" onclick="return confirm('Apakah Anda yakin ingin menghapus data ujian ini?')">
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