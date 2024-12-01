<?php 
require_once 'connection.php';


$sql_prodi = "SELECT * FROM Prodi";
$result_prodi = sqlsrv_query($conn, $sql_prodi);

if ($result_prodi === false) {
    die(print_r(sqlsrv_errors(), true));
}

while($row = sqlsrv_fetch_array($result_prodi, SQLSRV_FETCH_ASSOC)) {
    echo "<option value='{$row['id']}'>{$row['name']}</option>";
}

sqlsrv_close($conn);
?>