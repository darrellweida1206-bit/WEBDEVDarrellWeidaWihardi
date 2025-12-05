<?php
    include "includes/config.php";
    if(isset($_GET['hapusujian']))
    {
        $NPM = $_GET["hapusujian"];
        mysqli_query($conn, "DELETE FROM ujianskripsi
        WHERE mhs_NPM = '$NPM' ");
        echo "<script>alert('DATA BERHASIL DIHAPUS');
        document.location='inputujian.php'</script>";
    }
?>