<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] != 'profesor') {
    header('Location: index.php');
    exit;
}

if ($_POST) {
    $profesor_id = $_SESSION['usuario']['id'];
    $dia_semana = $_POST['dia_semana'];
    $hora_inicio = $_POST['hora_inicio'];
    $materia_id = $_POST['materia_id'];
    






    
    $hora_fin = date('H:i:s', strtotime($hora_inicio) + 3600);
    
    include_once 'models/TutoriaModel.php';
    $model = new TutoriaModel();
    



 
    include_once 'db/conexion.php';
    $conexion = new Conexion();
    $db = $conexion->conectar();
    



    // Insertar el horario
    $sql = "INSERT INTO horarios_profesores (profesor_id, materia_id, dia_semana, hora_inicio, hora_fin) 
            VALUES ($profesor_id, $materia_id, '$dia_semana', '$hora_inicio', '$hora_fin')";
    
    if ($db->exec($sql)) {
        header('Location: profesor.php?pagina=horarios&mensaje=Horario agregado correctamente');
    } else {
        header('Location: profesor.php?pagina=horarios&error=Error al agregar horario');
    }
} else {
    header('Location: profesor.php?pagina=horarios');
}
?>