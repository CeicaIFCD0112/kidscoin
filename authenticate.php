<?php
session_start();
if (!isset($_SESSION['nombres']) || !isset($_SESSION['apellidos'])) {
    header("Location: login.php");
    exit();
};

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    
    $sql = "SELECT * FROM kidzpeople WHERE nombres = ? apellidos = ? saldo = ? AND qrcode = ?" ;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombres, $apellidos, $saldo, $qrcode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['id'] = $id;
        $_SESSION['nombres'] = $nombres;
        $_SESSION['apellidos'] = $apellidos;
        $_SESSION['saldo'] = $saldo;
        $_SESSION['qrcode'] = $qrcode;
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Nombre o apellido incorrectos.";
    }
}
?>
