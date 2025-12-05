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
                        <h1 class="mt-4">Bimbingan</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
<?php
include("includes/config.php");

/**Mengambil NPM Mahasiswa dan Tanggal Bimbingan */
$NPM = $_GET["ubahbimbingan"];
$TGL = $_GET["tanggal"]; 

$edit = mysqli_query($conn, "SELECT * FROM bimbingan WHERE mhs_NPM = '$NPM' AND bimbingan_TGL = '$TGL'");
$row_edit = mysqli_fetch_array($edit);

$editmhs = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE mhs_NPM = '$NPM'");
$row_edit2 = mysqli_fetch_array($editmhs);

$editpeserta = mysqli_query($conn, "SELECT * FROM pesertaskripsi WHERE mhs_NPM = '$NPM'");
$row_edit3 = mysqli_fetch_array($editpeserta);

$editdosen = mysqli_query($conn, "SELECT * FROM dosen WHERE dosen_NIDN = '".$row_edit['dosen_NIDN']."'");
$row_edit4 = mysqli_fetch_array($editdosen);

if(isset($_POST['Ubah'])) 
{
    $mhs_NPM = $_POST['npmMHS'];
    $dosen_NIDN = $_POST['nidnDOSEN'];
    $bimbingan_TGL = $_POST['bimbinganTGL'];
    $bimbingan_ISI = mysqli_real_escape_string($conn, $_POST['bimbinganISI']);
    
    if($_FILES['bimbinganDOKUMEN']['name'] != "") {
        $bimbingan_DOKUMEN = $_FILES['bimbinganDOKUMEN']['name'];
        $dokumen_tmp = $_FILES['bimbinganDOKUMEN']['tmp_name'];
        
        $typedokumen = pathinfo($bimbingan_DOKUMEN, PATHINFO_EXTENSION);
        $ukurandokumen = $_FILES["bimbinganDOKUMEN"]["size"];
        $path = "documents/" . $bimbingan_DOKUMEN;

        if($ukurandokumen <= 5000000){
            if($typedokumen == "pdf"){
                if(!file_exists($path)){
                    move_uploaded_file($dokumen_tmp, 'documents/'.$bimbingan_DOKUMEN);
                }
            }
        } else {
        $bimbingan_DOKUMEN = "";
      }
        
        mysqli_query($conn, "UPDATE bimbingan SET mhs_NPM = '$mhs_NPM', dosen_NIDN = '$dosen_NIDN', bimbingan_TGL = '$bimbingan_TGL', bimbingan_ISI = '$bimbingan_ISI', bimbingan_DOKUMEN = '$bimbingan_DOKUMEN' WHERE mhs_NPM = '$NPM' AND bimbingan_TGL = '$TGL'");
    } else {
        mysqli_query($conn, "UPDATE bimbingan SET mhs_NPM = '$mhs_NPM', dosen_NIDN = '$dosen_NIDN', bimbingan_TGL = '$bimbingan_TGL', bimbingan_ISI = '$bimbingan_ISI' WHERE mhs_NPM = '$NPM' AND bimbingan_TGL = '$TGL'");
    }
    
    header("location:inputbimbingan.php");
}

/** pencarian data */
if(isset($_POST["kirim"]))
{
    $search = $_POST["search"];
    $query = mysqli_query($conn, "SELECT * FROM bimbingan,dosen,mahasiswa,pesertaskripsi WHERE mahasiswa.mhs_NPM = bimbingan.mhs_NPM AND bimbingan.dosen_NIDN = dosen.dosen_NIDN AND pesertaskripsi.mhs_NPM = bimbingan.mhs_NPM AND bimbingan.mhs_NPM LIKE '%".$search."%'");
}
else
{
    $query = mysqli_query($conn, "SELECT * FROM bimbingan,dosen,mahasiswa,pesertaskripsi WHERE mahasiswa.mhs_NPM = bimbingan.mhs_NPM AND bimbingan.dosen_NIDN = dosen.dosen_NIDN AND pesertaskripsi.mhs_NPM = bimbingan.mhs_NPM");
}
/** end pencarian data */

$datapeserta = mysqli_query($conn, "SELECT pesertaskripsi.mhs_NPM, mahasiswa.mhs_Nama, pesertaskripsi.peserta_JUDUL FROM pesertaskripsi, mahasiswa WHERE pesertaskripsi.mhs_NPM = mahasiswa.mhs_NPM");
$datadosen = mysqli_query($conn, "select * from dosen");
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
      <?php echo $row_edit3['peserta_JUDUL']?>
    </option>
    <?php while($row = mysqli_fetch_array($datapeserta))
    { ?>
    <option value="<?php echo $row["mhs_NPM"]?>">
      <?php echo $row["mhs_NPM"]?> - 
      <?php echo $row["mhs_Nama"]?> - 
      <?php echo $row['peserta_JUDUL']?>
    </option>
    <?php } ?>
  </select>
</div>
</div>

<div class="row mb-3">
  <label for="nidnDOSEN" class="col-sm-2 col-form-label">NIDN Dosen</label>
  <div class="col-sm-10">
    <select class="form-control" id="nidnDOSEN" name="nidnDOSEN">
      <option value="<?php echo $row_edit['dosen_NIDN']?>">
        <?php echo $row_edit['dosen_NIDN']?> - 
        <?php echo $row_edit4['dosen_Nama']?>
      </option>
      <?php while($row_dosen = mysqli_fetch_array($datadosen))
      { ?>
      <option value="<?php echo $row_dosen["dosen_NIDN"]?>">
        <?php echo $row_dosen["dosen_NIDN"]?> - 
        <?php echo $row_dosen["dosen_Nama"]?>
      </option>
      <?php } ?>
    </select>
  </div>
</div>

<div class="row mb-3">
    <label for="bimbinganTGL" class="col-sm-2 col-form-label">Tanggal Bimbingan</label>
    <div class="col-sm-10">
      <input type="date" class="form-control" id="bimbinganTGL" name="bimbinganTGL" value="<?php echo $row_edit['bimbingan_TGL']?>">
    </div>
</div>

<div class="row mb-3">
    <label for="bimbinganISI" class="col-sm-2 col-form-label">Isi Bimbingan</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="bimbinganISI" name="bimbinganISI" value="<?php echo $row_edit['bimbingan_ISI']?>">
    </div>
</div>

<div class="row mb-3">
    <label for="bimbinganDOKUMEN" class="col-sm-2 col-form-label">Unggah PDF</label>
    <div class="col-sm-10">
      <input type="file" class="form-control" id="bimbinganDOKUMEN" name="bimbinganDOKUMEN" accept=".pdf">
      <p class="help-block">File saat ini: <?php echo $row_edit['bimbingan_DOKUMEN']?></p>
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
                    <h1 class="display-5">Daftar Bimbingan Skripsi</h1>
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
                        <th>Tanggal</th>
                        <th>Isi Bimbingan</th>
                        <th>Dokumen</th>
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
                            <td><?php echo $row['bimbingan_TGL'] ?> </td>
                            <td><?php echo $row['bimbingan_ISI'] ?> </td>
                            <td>
                              <?php if($row['bimbingan_DOKUMEN'] == "") { ?>
                              <img src='images/No_Image_Available.jpg' width='88'/>
                              <?php } else { ?>
                              <a href="documents/<?php echo $row['bimbingan_DOKUMEN'] ?>" target="_blank">
                              <img src="images/pdf-icon.webp" width="88" class="img-responsive">
                              </a>
                              <?php }?>
                            </td>
                              <td>
                                <a href="editbimbingan.php?ubahbimbingan=<?php echo $row["mhs_NPM"]?>&tanggal=<?php echo $row["bimbingan_TGL"]?>" class="btn btn-success" title="EDIT">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                                </a>
                                </td>
                              <td>
                              <a href="hapusbimbingan.php?hapusbimbingan=<?php echo $row["mhs_NPM"]?>&tanggal=<?php echo $row["bimbingan_TGL"]?>" class="btn btn-danger" title="HAPUS" onclick="return confirm('Apakah Anda yakin ingin menghapus data bimbingan ini?')">
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