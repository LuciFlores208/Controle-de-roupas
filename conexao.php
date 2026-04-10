<?php
$conn = new mysqli("localhost", "root", "", "banco_crud");

if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}
?>