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
                        <h1 class="mt-4">Lulusan</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
<?php
include("includes/config.php");

$NPM = $_GET["ubahlulusan"];

// Ambil data lulusan yang akan diedit
$edit = mysqli_query($conn, "SELECT * FROM lulusan WHERE mhs_NPM = '$NPM'");
$row_edit = mysqli_fetch_array($edit);

// Ambil data mahasiswa
$editmhs = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE mhs_NPM = '$NPM'");
$row_edit2 = mysqli_fetch_array($editmhs);

// Ambil data judul skripsi
$editpeserta = mysqli_query($conn, "SELECT * FROM pesertaskripsi WHERE mhs_NPM = '$NPM'");
$row_edit3 = mysqli_fetch_array($editpeserta);

if(isset($_POST['Ubah'])) 
{
    $mhs_NPM = $_POST['npmMHS'];
    $lulusan_IPK = $_POST['lulusanIPK'];
    $lulusan_Predikat = $_POST['lulusanPREDIKAT'];
    
    if($_FILES['lulusanFOTO']['name'] != "") {
        $lulusan_FOTO = $_FILES['lulusanFOTO']['name'];
        $foto_tmp = $_FILES['lulusanFOTO']['tmp_name'];
        
        $typefoto = pathinfo($lulusan_FOTO, PATHINFO_EXTENSION);
        $ukuranfoto = $_FILES["lulusanFOTO"]["size"];
        $path = "images/" . $lulusan_FOTO;

        if($ukuranfoto <= 5000000){
            if(($typefoto == "jpg") or ($typefoto == 'png')){
                if(!file_exists($path)){
                    move_uploaded_file($foto_tmp, 'images/'.$lulusan_FOTO);
                }
            }
        } else {
          $lulusan_FOTO = "";
        }
        
        mysqli_query($conn, "UPDATE lulusan SET mhs_NPM = '$mhs_NPM', lulusan_IPK = '$lulusan_IPK', lulusan_PREDIKAT = '$lulusan_Predikat', lulusan_FOTO = '$lulusan_FOTO' WHERE mhs_NPM = '$NPM'");
    } else {
        mysqli_query($conn, "UPDATE lulusan SET mhs_NPM = '$mhs_NPM', lulusan_IPK = '$lulusan_IPK', lulusan_PREDIKAT = '$lulusan_Predikat' WHERE mhs_NPM = '$NPM'");
    }
    
    header("location:inputlulusan.php");
}

/** pencarian data */
if(isset($_POST["kirim"]))
{
    $search = $_POST["search"];
    $query = mysqli_query($conn, "SELECT * FROM lulusan, mahasiswa, pesertaskripsi 
        WHERE mahasiswa.mhs_NPM = lulusan.mhs_NPM 
        AND pesertaskripsi.mhs_NPM = lulusan.mhs_NPM
        AND lulusan.mhs_NPM LIKE '%".$search."%'");
}
else
{
    $query = mysqli_query($conn, "SELECT * FROM lulusan, mahasiswa, pesertaskripsi 
        WHERE mahasiswa.mhs_NPM = lulusan.mhs_NPM 
        AND pesertaskripsi.mhs_NPM = lulusan.mhs_NPM");
}
/** end pencarian data */

// Ambil data mahasiswa yang sudah ujian
$dataujian = mysqli_query($conn, "SELECT ujianskripsi.mhs_NPM, mahasiswa.mhs_Nama FROM ujianskripsi, mahasiswa WHERE ujianskripsi.mhs_NPM = mahasiswa.mhs_NPM");
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
      <?php echo $row_edit['mhs_NPM']?> - <?php echo $row_edit2['mhs_Nama']?>
    </option>
    <?php while($row = mysqli_fetch_array($dataujian))
    { ?>
    <option value="<?php echo $row["mhs_NPM"]?>">
      <?php echo $row["mhs_NPM"]?> - <?php echo $row["mhs_Nama"]?>
    </option>
    <?php } ?>
  </select>
</div>
</div>

<div class="row mb-3">
    <label for="lulusanIPK" class="col-sm-2 col-form-label">IPK</label>
    <div class="col-sm-10">
      <input type="decimal" class="form-control" id="lulusanIPK" name="lulusanIPK" value="<?php echo $row_edit['lulusan_IPK']?>" placeholder="Contoh: 4.00">
    </div>
</div>

<div class="row mb-3">
    <label for="lulusanPREDIKAT" class="col-sm-2 col-form-label">Predikat</label>
    <div class="col-sm-10">
      <select class="form-control" id="lulusanPREDIKAT" name="lulusanPREDIKAT">
        <option value="<?php echo $row_edit['lulusan_PREDIKAT']?>"><?php echo $row_edit['lulusan_PREDIKAT']?></option>
        <option value="Cum Laude">Cum Laude (3.51-4.00)</option>
        <option value="Sangat Memuaskan">Sangat Memuaskan (3.01-3.50)</option>
        <option value="Memuaskan">Memuaskan (2.76-3.00)</option>
      </select>
    </div>
</div>

<div class="row mb-3">
    <label for="lulusanFOTO" class="col-sm-2 col-form-label">Unggah Foto Lulusan</label>
    <div class="col-sm-10">
      <input type="file" class="form-control" id="lulusanFOTO" name="lulusanFOTO">
      <p class="help-block">File saat ini: <?php echo $row_edit['lulusan_FOTO']?></p>
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
                    <h1 class="display-5">Daftar Lulusan</h1>
                </div>

                <!--form pencarian data-->
                <form method="POST">
                <div class="form-group row mt-5 mb-3">
                <label for="search" class="col-sm-2">Cari NPM</label>
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
                        <th>IPK</th>
                        <th>Predikat</th>
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
                            <td><?php echo $row['lulusan_IPK']; ?> </td>
                            <td><?php echo $row['lulusan_PREDIKAT']; ?> </td>
                            <td>
                              <?php if($row['lulusan_FOTO'] == "") { ?>
                                <img src='images/No_Image_Available.jpg' width='88'/>
                              <?php } else { ?>
                                <img src="images/<?php echo $row['lulusan_FOTO'] ?>" width="88" class="img-responsive">
                              <?php }?>
                            </td>
                            <td>
                              <a href="editlulusan.php?ubahlulusan=<?php echo $row["mhs_NPM"]?>" class="btn btn-success" title="EDIT">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                              <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                              <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                              </svg>
                              </a>
                            </td>
                            <td>
                              <a href="hapuslulusan.php?hapuslulusan=<?php echo $row["mhs_NPM"]?>" class="btn btn-danger" title="HAPUS" onclick="return confirm('Apakah Anda yakin ingin menghapus data lulusan ini?')">
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