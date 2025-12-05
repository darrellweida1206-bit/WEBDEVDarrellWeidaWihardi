<?php
    include "includes/config.php";
    if(isset($_GET['hapuslulusan']))
    {
        $NPM = $_GET["hapuslulusan"];
        mysqli_query($conn, "DELETE FROM lulusan
        WHERE mhs_NPM = '$NPM' ");
        echo "<script>alert('DATA BERHASIL DIHAPUS');
        document.location='inputlulusan.php'</script>";
    }
?>