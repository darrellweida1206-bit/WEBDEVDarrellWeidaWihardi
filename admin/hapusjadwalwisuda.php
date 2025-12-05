<?php
    include "includes/config.php";
    if(isset($_GET['hapusjadwal']))
    {
        $jadwal = $_GET["hapusjadwal"];
        mysqli_query($conn, "DELETE FROM jadwalwisuda
        WHERE jadwal_ID = '$jadwal' ");
        echo "<script>alert('DATA BERHASIL DIHAPUS');
        document.location='inputjadwalwisuda.php'</script>";
    }
?>