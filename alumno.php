<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] != 'alumno') {
    header('Location: index.php');
    exit;
}

$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 'inicio';




include_once 'models/TutoriaModel.php';
$tutoriaModel = new TutoriaModel();

switch ($pagina) {
    case 'inicio':
        include 'views/alumnos/inicio.php';
        break;
        
    case 'reservar':



    // Obtener materias con profesores
    $materias = $tutoriaModel->obtenerMateriasConProfesores();
    




    // Si se seleccionó una materia, agarrar o obtnerr sus horarios
    $materia_seleccionada = null;
    $horarios = array();
    
    if (isset($_GET['materia_id'])) {
        $materia_id = $_GET['materia_id'];
        $horarios = $tutoriaModel->obtenerHorariosPorMateria($materia_id);
        
        // Buscar la materia seleccionada
        foreach ($materias as $materia) {
            if ($materia['id'] == $materia_id) {
                $materia_seleccionada = $materia;
                break;
            }
        }
    }
    
    

    if ($_POST && isset($_POST['horario_id'])) {
        $horario_id = $_POST['horario_id'];
        


        // Aquí necesitamos obtener los datos del horario primero
        $resultado = $tutoriaModel->reservarPorHorario(
            $_SESSION['usuario']['id'],
            $horario_id
        );
        
        if ($resultado) {
            $mensaje = "Tutoría reservada correctamente";
        } else {
            $error = "Error al reservar la tutoría";
        }
    }
    
    include 'views/alumnos/reservar.php';
    break;
        
    case 'historial':



        // obtener tutorías del alumno jiji
        $tutorias = $tutoriaModel->obtenerTutoriasAlumno($_SESSION['usuario']['id']);
        include 'views/alumnos/historial.php';
        break;
        
    default:
        include 'views/alumnos/inicio.php';
        break;
}
?>