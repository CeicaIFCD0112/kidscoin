<?php
session_start();
if (!isset($_SESSION['nombres']) || !isset($_SESSION['apellidos'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

$nombre = $_SESSION['nombres'];
$apellido = $_SESSION['apellidos'];
$saldo = $_SESSION['saldo'];

$sql = "SELECT * FROM kidzpeople WHERE nombres = ? AND apellidos = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $nombres, $apellidos,);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Dashboard</title>
    <style>
        .whatsapp-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            background-color: #25D366;
            color: white;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .whatsapp-button:hover {
            background-color: #1EBEA5;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">K I D S C O I N Z</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="login.php">LOGIN</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">REGISTER</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="staff.php">Staff</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="kiosko.php">Kiosko KIDZ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ofertas.php">Ofertas</a>
                </li>
            </ul>
        </div>
    </nav>
    <hr>
    <!-- Contenido de la página -->
    <div class="container mt-5">
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombres'] . ' ' . $_SESSION['apellidos']); ?></h1>
        <h2>Listado de Participantes</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Saldo</th>
                    <th>QR</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nombres']); ?></td>
                    <td><?php echo htmlspecialchars($row['apellidos']); ?></td>
                    <td><?php echo htmlspecialchars($row['saldo']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($row['qr']); ?>" alt="QR Code" width="50"></td>
                    <td>
                        <form action="update_balance.php" method="post" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="action" value="add" class="btn btn-success">+</button>
                        </form>
                        <form action="update_balance.php" method="post" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="action" value="subtract" class="btn btn-danger">-</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <!-- Enlace a Bootstrap JS y jQuery (necesario para el funcionamiento de los componentes de Bootstrap) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <!-- Botón Flotante de WhatsApp -->
    <a href="https://wa.me/34660811747" class="whatsapp-button" target="_blank">
        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/WhatsApp_icon.png" alt="WhatsApp" width="30">
    </a>

</body>

</html>