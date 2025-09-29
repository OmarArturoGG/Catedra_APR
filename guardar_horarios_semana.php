<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] != 'profesor') {
    header('Location: index.php');
    exit;
}

if ($_POST) {
    $profesor_id = $_SESSION['usuario']['id'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];
    $materia_id = $_POST['materia_id'];
    
    include_once 'models/TutoriaModel.php';
    $model = new TutoriaModel();
    
    include_once 'db/conexion.php';
    $conexion = new Conexion();
    $db = $conexion->conectar();
    
    

    
    if (isset($_POST['dias_semana'])) {
        $dias_agregados = 0;
        foreach ($_POST['dias_semana'] as $dia_semana) {
            $sql = "INSERT INTO horarios_profesores (profesor_id, materia_id, dia_semana, hora_inicio, hora_fin) 
                    VALUES ($profesor_id, $materia_id, '$dia_semana', '$hora_inicio', '$hora_fin')";
            if ($db->exec($sql)) {
                $dias_agregados++;
            }
        }
        
        if ($dias_agregados > 0) {
            header('Location: profesor.php?pagina=horarios&mensaje=Horarios agregados correctamente');
        } else {
            header('Location: profesor.php?pagina=horarios&error=Error al agregar horarios');
        }
    } else {
        header('Location: profesor.php?pagina=horarios&error=Selecciona al menos un día');
    }
} else {
    header('Location: profesor.php?pagina=horarios');
}
?>