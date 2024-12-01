<?php
$serverName = "mssql-188180-0.cloudclusters.net,19659"; 
$connectionOptions = [
    "Database" => "sibeta",
    "Uid" => "sibeta", 
    "PWD" => "Sibeta123"
];

// Membuat koneksi
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>
