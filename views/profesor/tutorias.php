<?php
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] != 'profesor') {
    header('Location: ../index.php');
    exit;
}

$profesor_id = $_SESSION['usuario']['id'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Horarios</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="menu-alumno">
        <a href="profesor.php" class="btn-volver">← Volver</a>
        
        <h2>Mis Horarios Disponibles</h2>
        
        <?php
        include_once 'models/TutoriaModel.php';
        $model = new TutoriaModel();
        
        




        //enseñar los horarios del profesor pues al profe jjii
        $conexion = new Conexion();
        $db = $conexion->conectar();
        
        $sql = "SELECT hp.*, m.nombre as materia_nombre 
                FROM horarios_profesores hp 
                JOIN materias m ON hp.materia_id = m.id 
                WHERE hp.profesor_id = $profesor_id 
                ORDER BY hp.dia_semana, hp.hora_inicio";
        
        $resultado = $db->query($sql);
        $horarios = $resultado->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($horarios)) {
            echo "<p>No tienes horarios disponibles.</p>";
        } else {
            echo "<div class='horarios-list'>";
            foreach ($horarios as $horario) {
                echo "<div class='horario-item'>";
                echo "<h4>" . $horario['materia_nombre'] . "</h4>";
                echo "<p><strong>Día:</strong> " . $horario['dia_semana'] . "</p>";
                echo "<p><strong>Hora:</strong> " . date('h:i A', strtotime($horario['hora_inicio'])) . " - " . date('h:i A', strtotime($horario['hora_fin'])) . "</p>";
                
            




                echo "<div style='margin-top: 10px;'>";
                echo "<button style='padding: 5px 10px; margin-right: 5px;'>Modificar</button>";
                echo "<button style='padding: 5px 10px; background: #dc3545; color: white; border: none; border-radius: 3px; cursor: pointer;' onclick='eliminarHorario(" . $horario['id'] . ")'>Eliminar</button>";
                echo "</div>";
                
                echo "</div>";
            }
            echo "</div>";
        }
        ?>
    </div>

    <script>
        function eliminarHorario(horario_id) {
            if (confirm('¿Estás seguro de eliminar este horario?')) {
                window.location = 'eliminar_horario.php?id=' + horario_id;
            }
        }
    </script>
</body>
</html>