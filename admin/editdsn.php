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
                        <h1 class="mt-4">Dosen</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
<?php
include("includes/config.php"); 

/** menerima data yang akan diubah */
$NIDN = $_GET["ubahdsn"];
$edit = mysqli_query($conn, "SELECT * FROM dosen WHERE dosen_NIDN = '$NIDN'");
$row_edit = mysqli_fetch_array($edit);

if(isset($_POST['Ubah'])) 
{
    $dosen_NIDN = $_POST['dosen_NIDN'];
    $dosen_NIK = $_POST['dosen_NIK'];
    $dosen_Nama = $_POST['dosen_Nama'];
    $dosen_Ket = $_POST['dosen_Ket'];
    
    mysqli_query($conn, "UPDATE dosen SET dosen_NIK = '$dosen_NIK', dosen_Nama = '$dosen_Nama', dosen_Ket = '$dosen_Ket' WHERE dosen_NIDN = '$NIDN'");
    
    header("location:inputdsn.php");
}

/** pencarian data */
if(isset($_POST["kirim"]))
{
    $search = $_POST["search"];
    $query = mysqli_query($conn, "SELECT * FROM dosen WHERE dosen_NIDN LIKE '%".$search."%' OR dosen_Nama LIKE '%".$search."%'");
}
else
{
    $query = mysqli_query($conn, "SELECT * FROM dosen");
}
/** end pencarian data */
?>

  <div class="row">
  <div class="col-1"></div>
  <div class="col-10">
    <form method="POST">
  <div class="row mb-3 mt-5">
    <label for="dosen_NIDN" class="col-sm-2 col-form-label">NIDN Dosen</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="dosen_NIDN" name="dosen_NIDN" value="<?php echo $row_edit['dosen_NIDN']?>" readonly>
    </div>
  </div>
  <div class="row mb-3">
    <label for="dosen_NIK" class="col-sm-2 col-form-label">NIK Dosen</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="dosen_NIK" name="dosen_NIK" value="<?php echo $row_edit['dosen_NIK']?>" placeholder="Isikan NIK Dosen">
    </div>
  </div>
  <div class="row mb-3">
    <label for="dosen_Nama" class="col-sm-2 col-form-label">Nama Dosen</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="dosen_Nama" name="dosen_Nama" value="<?php echo $row_edit['dosen_Nama']?>" placeholder="Isikan Nama Dosen">
    </div>
  </div>
  <div class="row mb-3">
    <label for="dosen_Ket" class="col-sm-2 col-form-label">Keterangan Dosen</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="dosen_Ket" name="dosen_Ket" value="<?php echo $row_edit['dosen_Ket']?>" placeholder="Keterangan Dosen">
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
                    <h1 class="display-5">Daftar Dosen</h1>
                </div>

                <!--form pencarian data-->
                <form method="POST">
                <div class="form-group row mt-5 mb-3">
                <label for="search" class="col-sm-2">Cari NIDN/Nama</label>
                <div class="col-sm-6">
                <input type="text" name="search" class="form-control" id="search"
                value="<?php if(isset($_POST["search"]))
                {echo $_POST["search"];}?>" placeholder="Cari NIDN atau Nama Dosen">
                </div>
                <input type="submit" name="kirim" value="Cari" class="col-sm-1 btn
                btn-primary">
                </div>
                </form>
                <!--end pencarian data-->

                <table class="table table-striped table-success table-hover">
                    <tr class="info"> 
                        <th>NIDN Dosen</th>
                        <th>NIK Dosen</th>
                        <th>Nama Dosen</th>
                        <th>Keterangan</th>
                        <th colspan="2" style="text-align: center;">Aksi</th>
                    </tr>

                    <?php { ?>
                    <?php while ($row = mysqli_fetch_array($query))
                    { ?>
                        <tr class="danger">
                            <td><?php echo $row['dosen_NIDN']; ?> </td>
                            <td><?php echo $row['dosen_NIK']; ?> </td>
                            <td><?php echo $row['dosen_Nama']; ?> </td>
                            <td><?php echo $row['dosen_Ket']; ?> </td>
                            <td>
                                <a href="editdsn.php?ubahdsn=<?php echo $row["dosen_NIDN"]?>" class="btn btn-success" title="EDIT">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                                </a>
                            </td>
                            <td>
                                <a href="hapusdsn.php?hapusdsn=<?php echo $row["dosen_NIDN"]?>" class="btn btn-danger" title="HAPUS">
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