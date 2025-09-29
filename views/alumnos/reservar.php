<?php
// Ver que el usuario este logueado
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] != 'alumno') {
    header('Location: ../index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Tutoría</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="materias-container">
        <?php if (!isset($_GET['materia_id'])): ?>
      



            <a href="alumno.php" class="btn-volver">← Volver al Inicio</a>
        <?php endif; ?>
        
        <h2>Reservar Tutoría</h2>
        
        <?php if (isset($mensaje)): ?>
            <div class="mensaje-exito">
                ✅ <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="error">❌ <?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (!isset($_GET['materia_id'])): ?>
            <h3>Selecciona una materia:</h3>
            <div class="materias-grid">
                <?php foreach ($materias as $materia): ?>
                    <div class="materia-card" onclick="window.location='alumno.php?pagina=reservar&materia_id=<?php echo $materia['id']; ?>'">
                        <h3><?php echo $materia['nombre']; ?></h3>
                        <p><strong>Código:</strong> <?php echo $materia['codigo']; ?></p>
                        <div class="profesores">
                            <?php echo $materia['total_profesores'] > 0 ? $materia['total_profesores'] . ' profesor(es)' : 'Sin profesores'; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
        <?php else: ?>
            <!-- Vista de horarios - SOLO tiene "Volver a materias" -->
            <div style="margin-bottom: 20px;">
                <a href="alumno.php?pagina=reservar" class="btn-volver">← Volver a materias</a>
            </div>
            
            <h3>Horarios disponibles para: <?php echo $materia_seleccionada['nombre']; ?></h3>
            
            <?php if (empty($horarios)): ?>
                <p>No hay horarios disponibles para esta materia.</p>
            <?php else: ?>
                <div class="horarios-list">
                    <?php foreach ($horarios as $horario): ?>
                        <div class="horario-item">
                            <form method="POST" action="alumno.php?pagina=reservar&materia_id=<?php echo $materia_seleccionada['id']; ?>">
                                <input type="hidden" name="horario_id" value="<?php echo $horario['id']; ?>">
                                <h4>Profesor: <?php echo $horario['profesor_nombre']; ?></h4>
                                <p><strong>Día:</strong> <?php echo $horario['dia_semana']; ?></p>
                                <p><strong>Hora:</strong> <?php echo date('h:i A', strtotime($horario['hora_inicio'])); ?> - <?php echo date('h:i A', strtotime($horario['hora_fin'])); ?></p>
                                <button type="submit" class="btn-reservar">Reservar este horario</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
        <?php endif; ?>
    </div>
</body>
</html>