<?php
session_start();
if (!isset($_SESSION['nombres']) || !isset($_SESSION['apellidos'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['action'])) {
    $id = $_POST['id'];
    $action = $_POST['action'];

    // Fetch current balance
    $sql = "SELECT saldo FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();

    if ($usuario) {
        $saldo_actual = $usuario['saldo'];
        if ($action == 'add') {
            $nuevo_saldo = $saldo_actual + 10; // Adjust the increment value as needed
        } elseif ($action == 'subtract') {
            $nuevo_saldo = $saldo_actual - 10; // Adjust the decrement value as needed
        }

        // Update balance in the database
        $sql = "UPDATE usuarios SET saldo = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $nuevo_saldo, $id);
        $stmt->execute();
    }
}

header("Location: authenticate.php");
exit();
?>
