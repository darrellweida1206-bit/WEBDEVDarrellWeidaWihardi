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
                        <h1 class="mt-4">Jadwal Wisuda</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
<?php
include("includes/config.php");

$jadwal_ID = $_GET["ubahjadwal"];

// Ambil data jadwal yang akan diedit
$edit = mysqli_query($conn, "SELECT * FROM jadwalwisuda WHERE jadwal_ID = '$jadwal_ID'");
$row_edit = mysqli_fetch_array($edit);

if(isset($_POST['Ubah'])) 
{
    $jadwal_ID_new = $_POST['idJadwal'];
    $jadwal_Periode = $_POST['periodeJadwal'];
    $jadwal_Tanggal = $_POST['tanggalWisuda'];
    $jadwal_Tempat = $_POST['tempatWisuda'];
    
    if($_FILES['wisudaFOTO']['name'] != "") {
        $wisuda_FOTO = $_FILES['wisudaFOTO']['name'];
        $foto_tmp = $_FILES['wisudaFOTO']['tmp_name'];
        
        $typefoto = pathinfo($wisuda_FOTO, PATHINFO_EXTENSION);
        $ukuranfoto = $_FILES["wisudaFOTO"]["size"];
        $path = "images/" . $wisuda_FOTO;

        if($ukuranfoto <= 5000000){
            if(($typefoto == "jpg") or ($typefoto == 'png') or ($typefoto == 'jpeg')){
                if(!file_exists($path)){
                    move_uploaded_file($foto_tmp, 'images/'.$wisuda_FOTO);
                }
            }
        } else {
          $wisuda_FOTO = "";
        }
        
        mysqli_query($conn, "UPDATE jadwalwisuda SET jadwal_ID = '$jadwal_ID_new', Periode = '$jadwal_Periode', Tanggal_Wisuda = '$jadwal_Tanggal', Tempat = '$jadwal_Tempat', Wisuda_FOTO = '$wisuda_FOTO' WHERE jadwal_ID = '$jadwal_ID'");
    } else {
        mysqli_query($conn, "UPDATE jadwalwisuda SET jadwal_ID = '$jadwal_ID_new', Periode = '$jadwal_Periode', Tanggal_Wisuda = '$jadwal_Tanggal', Tempat = '$jadwal_Tempat' WHERE jadwal_ID = '$jadwal_ID'");
    }
    
    header("location:inputjadwalwisuda.php");
}

/** pencarian data */
if(isset($_POST["kirim"]))
{
    $search = $_POST["search"];
    $query = mysqli_query($conn, "SELECT * FROM jadwalwisuda WHERE jadwal_ID LIKE '%".$search."%' OR Periode LIKE '%".$search."%'");
}
else
{
    $query = mysqli_query($conn, "SELECT * FROM jadwalwisuda");
}
/** end pencarian data */
?>

  <div class="row">
  <div class="col-1"></div>
  <div class="col-10">
    <form method="POST" enctype="multipart/form-data">
  <div class="row mb-3 mt-5">
    <label for="idJadwal" class="col-sm-2 col-form-label">ID Jadwal</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="idJadwal" name="idJadwal" placeholder="ID Jadwal Wisuda" maxlength="11" value="<?php echo $row_edit['jadwal_ID']?>" required="">
    </div>
  </div>
  <div class="row mb-3">
    <label for="periodeJadwal" class="col-sm-2 col-form-label">Periode</label>
    <div class="col-sm-10">
      <select type="form-select" class="form-control" id="periodeJadwal" name="periodeJadwal">
        <option value="<?php echo $row_edit['Periode']?>" selected><?php echo $row_edit['Periode']?></option>
        <option value="GANJIL 2024/2025">GANJIL 2024/2025</option>
        <option value="GENAP 2025/2026">GENAP 2025/2026</option>
    </select>
    </div>
  </div>
  <div class="row mb-3">
    <label for="tanggalWisuda" class="col-sm-2 col-form-label">Tanggal Wisuda</label>
    <div class="col-sm-10">
      <input type="date" class="form-control" id="tanggalWisuda" name="tanggalWisuda" value="<?php echo $row_edit['Tanggal_Wisuda']?>">
    </div>
  </div>
  <div class="row mb-3">
    <label for="tempatWisuda" class="col-sm-2 col-form-label">Tempat</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="tempatWisuda" name="tempatWisuda" placeholder="Tempat Pelaksanaan Wisuda" maxlength="100" value="<?php echo $row_edit['Tempat']?>">
    </div>
  </div>
  <div class="row mb-3">
    <label for="wisudaFOTO" class="col-sm-2 col-form-label">Unggah Foto Wisuda</label>
    <div class="col-sm-10">
      <input type="file" class="form-control" id="wisudaFOTO" name="wisudaFOTO">
      <p class="help-block">File saat ini: <?php echo $row_edit['Wisuda_FOTO']?></p>
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
                    <h1 class="display-5">Daftar Jadwal Wisuda</h1>
                </div>

                <!--form pencarian data-->
                <form method="POST">
                <div class="form-group row mt-5 mb-3">
                <label for="search" class="col-sm-2">Cari ID/Periode</label>
                <div class="col-sm-6">
                <input type="text" name="search" class="form-control" id="search"
                value="<?php if(isset($_POST["search"]))
                {echo $_POST["search"];}?>" placeholder="Cari ID atau Periode Jadwal">
                </div>
                <input type="submit" name="kirim" value="Cari" class="col-sm-1 btn btn-primary">
                </div>
                </form>
                <!--end pencarian data-->

    <table class="table table-striped table-success table-hover">
    <tr class="info"> 
        <th>ID Jadwal</th>
        <th>Periode</th>
        <th>Tanggal Wisuda</th>
        <th>Tempat</th>
        <th>Foto</th>
        <th colspan="2" style="text-align: center;">Aksi</th>
    </tr>

    <?php { ?>
    <?php while ($row = mysqli_fetch_array($query))
    { ?>
        <tr class="danger"> 
            <td><?php echo $row['jadwal_ID']; ?></td>
            <td><?php echo $row['Periode']; ?></td>
            <td><?php echo $row['Tanggal_Wisuda']; ?></td>
            <td><?php echo $row['Tempat']; ?></td>
            <td>
              <?php if($row['Wisuda_FOTO'] == "") { ?>
                <img src='images/No_Image_Available.jpg' width='88'/>
              <?php } else { ?>
                <img src="images/<?php echo $row['Wisuda_FOTO'] ?>" width="88" class="img-responsive">
              <?php }?>
            </td>
            <td>
                <a href="editjadwalwisuda.php?ubahjadwal=<?php echo $row["jadwal_ID"]?>" class="btn btn-success" title="EDIT">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                </svg>
                </a>
            </td>
            <td>
                <a href="hapusjadwalwisuda.php?hapusjadwal=<?php echo $row["jadwal_ID"]?>" class="btn btn-danger" title="HAPUS" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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