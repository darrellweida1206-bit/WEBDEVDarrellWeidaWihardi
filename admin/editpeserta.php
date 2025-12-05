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
                        <h1 class="mt-4">Peserta Skripsi</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
<?php
include("includes/config.php"); 

/** menerima data yang akan diubah */
$NPM = $_GET["ubahpeserta"];
$edit = mysqli_query($conn, "SELECT * FROM pesertaskripsi WHERE mhs_NPM = '$NPM'");
$row_edit = mysqli_fetch_array($edit);

$editmhs = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE mhs_NPM = '$NPM'");
$row_edit2 = mysqli_fetch_array($editmhs);

if(isset($_POST['Ubah'])) /*mengambil nilai baru dari formulir*/
{
    $mhs_NPM = $_POST['npmMHS'];
    $peserta_SEMT = $_POST['pesertaSEMT'];
    $peserta_THAKD = $_POST['pesertaTHAKD'];
    $peserta_TGLDAFTAR = $_POST['pesertaTGLDAFTAR'];
    $peserta_JUDUL = mysqli_real_escape_string($conn, $_POST['pesertaJUDUL']);
    $peserta_PENJELASAN = mysqli_real_escape_string($conn, $_POST['pesertaPENJELASAN']);
    
    if($_FILES['pesertaDOKUMEN']['name'] != "") {
        $peserta_DOKUMEN = $_FILES['pesertaDOKUMEN']['name'];
        $dokumen_tmp = $_FILES['pesertaDOKUMEN']['tmp_name'];
        move_uploaded_file($dokumen_tmp, 'images/'.$peserta_DOKUMEN);
        
        mysqli_query($conn, "UPDATE pesertaskripsi SET mhs_NPM = '$mhs_NPM', peserta_SEMT = '$peserta_SEMT', peserta_THAKD = '$peserta_THAKD', peserta_TGLDAFTAR = '$peserta_TGLDAFTAR', peserta_JUDUL = '$peserta_JUDUL', peserta_PENJELASAN = '$peserta_PENJELASAN', peserta_DOKUMEN = '$peserta_DOKUMEN' WHERE mhs_NPM = '$NPM'");
    } else {
        mysqli_query($conn, "UPDATE pesertaskripsi SET mhs_NPM = '$mhs_NPM', peserta_SEMT = '$peserta_SEMT', peserta_THAKD = '$peserta_THAKD', peserta_TGLDAFTAR = '$peserta_TGLDAFTAR', peserta_JUDUL = '$peserta_JUDUL', peserta_PENJELASAN = '$peserta_PENJELASAN' WHERE mhs_NPM = '$NPM'");
    }
    
    header("location:inputpeserta.php");
}

/** pencarian data */
if(isset($_POST["kirim"]))
{
    $search = $_POST["search"];
    $query = mysqli_query($conn, "SELECT * FROM pesertaskripsi,mahasiswa WHERE mahasiswa.mhs_NPM = pesertaskripsi.mhs_NPM AND pesertaskripsi.mhs_NPM LIKE '%".$search."%'");
}
else
{
    $query = mysqli_query($conn, "SELECT * FROM pesertaskripsi,mahasiswa WHERE mahasiswa.mhs_NPM = pesertaskripsi.mhs_NPM");
}
/** end pencarian data */

$datamhs = mysqli_query($conn, "select * from mahasiswa"); /* mengambil data dari tabel mahasiswa */
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
      <?php echo $row_edit2['mhs_Nama']?>
    </option>
    <?php while($row = mysqli_fetch_array($datamhs))
    { ?>
    <option value="<?php echo $row["mhs_NPM"]?>">
      <?php echo $row["mhs_NPM"]?> - 
      <?php echo $row["mhs_Nama"]?>
    </option>
    <?php } ?>
  </select>
</div>
</div>

<div class="row mb-3">
  <label for="pesertaSEMT" class="col-sm-2 col-form-label">Semester</label>
  <div class="col-sm-10">
    <select class="form-select" id="pesertaSEMT" name="pesertaSEMT">
      <option value="<?php echo $row_edit['peserta_SEMT']?>" selected><?php echo $row_edit['peserta_SEMT']?></option>
      <option value="Ganjil">Ganjil</option>
      <option value="Genap">Genap</option>
    </select>
  </div>
</div>

<div class="row mb-3">
    <label for="pesertaTHAKD" class="col-sm-2 col-form-label">Tahun Akademik</label>
    <div class="col-sm-10">
      <select type="form-select" class="form-control" id="pesertaTHAKD" name="pesertaTHAKD">
      <option value="<?php echo $row_edit['peserta_THAKD']?>" selected><?php echo $row_edit['peserta_THAKD']?></option>
      <option value="2024-2025">2024-2025</option>
      <option value="2025-2026">2025-2026</option>
    </select>
    </div>
</div>

<div class="row mb-3">
    <label for="pesertaTGLDAFTAR" class="col-sm-2 col-form-label">Tanggal Daftar</label>
    <div class="col-sm-10">
      <input type="date" class="form-control" id="pesertaTGLDAFTAR" name="pesertaTGLDAFTAR" value="<?php echo $row_edit['peserta_TGLDAFTAR']?>">
    </div>
</div>

<div class="row mb-3">
    <label for="pesertaJUDUL" class="col-sm-2 col-form-label">Judul Skripsi</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="pesertaJUDUL" name="pesertaJUDUL" value="<?php echo $row_edit['peserta_JUDUL']?>">
    </div>
</div>

<div class="row mb-3">
    <label for="pesertaPENJELASAN" class="col-sm-2 col-form-label">Penjelasan Singkat</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="pesertaPENJELASAN" name="pesertaPENJELASAN" value="<?php echo $row_edit['peserta_PENJELASAN']?>" placeholder="Masukkan Penjelasan singkat (1-2 paragraf)">
    </div>
</div>

<div class="row mb-3">
    <label for="pesertaDOKUMEN" class="col-sm-2 col-form-label">Unggah Dokumen</label>
    <div class="col-sm-10">
      <input type="file" class="form-control" id="pesertaDOKUMEN" name="pesertaDOKUMEN">
      <p class="help-block">File saat ini: <?php echo $row_edit['peserta_DOKUMEN']?></p>
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
                    <h1 class="display-5">Daftar Peserta Skripsi</h1>
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
                        <th>Semester</th>
                        <th>Tahun Akademik</th>
                        <th>Tanggal</th>
                        <th>Judul Skripsi</th>
                        <th>Penjelasan</th>
                        <th>Dokumen</th>
                        <th colspan="2" style="text-align: center;">Aksi</th>
                    </tr>

                    <?php { ?>
                    <?php while ($row = mysqli_fetch_array($query))
                    { ?>
                        <tr class="danger">
                            <td><?php echo $row['mhs_NPM']; ?> </td>
                            <td><?php echo $row['mhs_Nama']; ?> </td>
                            <td><?php echo $row['peserta_SEMT']; ?> </td>
                            <td><?php echo $row['peserta_THAKD']; ?> </td>
                            <td><?php echo $row['peserta_TGLDAFTAR']; ?> </td>
                            <td><?php echo $row['peserta_JUDUL']; ?> </td>
                            <td><?php echo $row['peserta_PENJELASAN']; ?></td>
                            <td>
                            <?php if($row['peserta_DOKUMEN'] == "") { echo "<img src='images/No_Image_Available.jpg' 
                            width='88'/>";} else { ?>
                            <img src="images/<?php echo $row['peserta_DOKUMEN'] ?>" width="88" class="img-responsive">
                            <?php }?>
                            </td>

                              <td>
                              <a href="editpeserta.php?ubahpeserta=<?php echo $row["mhs_NPM"]?>" class="btn btn-success" title="EDIT">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                                </a>
                                </td>
                              <td>
                              <a href="hapuspeserta.php?hapuspeserta=<?php echo $row["mhs_NPM"]?>" class="btn btn-danger" title="HAPUS">                              
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