<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Historial de Tutorías</title>
    <link rel="stylesheet" href="css/styles.css">
</head>





<body>
    <header>
        <h1>📋 Mi Historial de Tutorías</h1>
        <nav>
            <a href="inicio.php">Inicio</a> |
            <a href="reservar.php">Reservar</a> |
            <a href="../logout.php">Cerrar Sesión</a>
        </nav>
    </header>

    <main>
        <?php if (empty($tutorias)): ?>
            <p>No tienes tutorías reservadas aún.</p>
        <?php else: ?>
            <table border="1" cellpadding="10">
                <thead>
                    <tr>
                        <th>Profesor</th>
                        <th>Materia</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                    </tr>
                </thead>


                
                <tbody>
                    <?php foreach ($tutorias as $t): ?>
                        <tr>
                            <td><?= htmlspecialchars($t['profesor_nombre']) ?></td>
                            <td><?= htmlspecialchars($t['materia_nombre']) ?></td>
                            <td><?= htmlspecialchars($t['fecha']) ?></td>
                            <td><?= htmlspecialchars($t['estado']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>

    <footer>
        © 2025 Sistema de Tutorías
    </footer>
</body>
</html>