<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];

    
    $sql = "SELECT * FROM usuarios WHERE nombres = ? AND apellidos = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nombres, $apellidos,);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['id'] = $id;
        $_SESSION['nombres'] = $nombres;
        $_SESSION['apellidos'] = $apellidos;
        $_SESSION['imagen'] = $imagen;
        $_SESSION['saldo'] = $saldo;
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Nombre o apellido incorrectos.";
    }
}
?>
