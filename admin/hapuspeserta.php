<?php
    include "includes/config.php";
    if(isset($_GET['hapuspeserta']))
    {
        $NPM = $_GET["hapuspeserta"];
        mysqli_query($conn, "DELETE FROM pesertaskripsi
        WHERE mhs_NPM = '$NPM' ");
        echo "<script>alert('DATA BERHASIL DIHAPUS');
        document.location='inputpeserta.php'</script>";
    }
?>