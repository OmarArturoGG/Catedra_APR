<?php
include_once 'db/conexion.php';

class TutoriaModel {
    
    public function obtenerProfesores() {
        $conexion = new Conexion();
        $db = $conexion->conectar();
        
        $sql = "SELECT * FROM usuarios WHERE tipo = 'profesor' AND activo = 1";
        $resultado = $db->query($sql);
        
        $profesores = array();
        while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $profesores[] = $fila;
        }
        
        return $profesores;
    }
    
    public function obtenerMaterias() {
        $conexion = new Conexion();
        $db = $conexion->conectar();
        
        $sql = "SELECT * FROM materias";
        $resultado = $db->query($sql);
        
        $materias = array();
        while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $materias[] = $fila;
        }
        
        return $materias;
    }
    
    public function obtenerMateriasConProfesores() {
        $conexion = new Conexion();
        $db = $conexion->conectar();
        
        $sql = "SELECT m.*, 
                       GROUP_CONCAT(DISTINCT u.nombre) as profesores,
                       COUNT(DISTINCT u.id) as total_profesores
                FROM materias m
                LEFT JOIN horarios_profesores hp ON m.id = hp.materia_id
                LEFT JOIN usuarios u ON hp.profesor_id = u.id AND u.activo = 1
                GROUP BY m.id
                ORDER BY m.nombre";
        
        $resultado = $db->query($sql);
        
        $materias = array();
        while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $materias[] = $fila;
        }
        
        return $materias;
    }
    
    public function obtenerHorariosPorMateria($materia_id) {
        $conexion = new Conexion();
        $db = $conexion->conectar();
        
        $sql = "SELECT hp.*, u.nombre as profesor_nombre
                FROM horarios_profesores hp
                JOIN usuarios u ON hp.profesor_id = u.id
                WHERE hp.materia_id = $materia_id
                ORDER BY hp.dia_semana, hp.hora_inicio";
        
        $resultado = $db->query($sql);
        
        $horarios = array();
        while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $horarios[] = $fila;
        }
        
        return $horarios;
    }
    
    public function reservarPorHorario($alumno_id, $horario_id) {
        $conexion = new Conexion();
        $db = $conexion->conectar();
        
        $sql_horario = "SELECT * FROM horarios_profesores WHERE id = $horario_id";
        $horario = $db->query($sql_horario)->fetch();
        
        if (!$horario) {
            return false;
        }
        
        $dia_ingles = array(
            'Lunes' => 'monday',
            'Martes' => 'tuesday', 
            'Miércoles' => 'wednesday',
            'Jueves' => 'thursday',
            'Viernes' => 'friday',
            'Sábado' => 'saturday'
        );
        
        $dia_semana = $dia_ingles[$horario['dia_semana']];
        $fecha_tutoria = date('Y-m-d', strtotime("next $dia_semana")) . ' ' . $horario['hora_inicio'];
        
        $sql = "INSERT INTO tutorias (alumno_id, profesor_id, materia_id, fecha, estado) 
                VALUES ($alumno_id, {$horario['profesor_id']}, {$horario['materia_id']}, '$fecha_tutoria', 'pendiente')";
        
        return $db->exec($sql);
    }
    
    public function reservarTutoria($alumno_id, $profesor_id, $materia_id, $fecha) {
        $conexion = new Conexion();
        $db = $conexion->conectar();
        
        $sql = "INSERT INTO tutorias (alumno_id, profesor_id, materia_id, fecha, estado) 
                VALUES ($alumno_id, $profesor_id, $materia_id, '$fecha', 'pendiente')";
        
        return $db->exec($sql);
    }
    
    public function obtenerTutoriasAlumno($alumno_id) {
        $conexion = new Conexion();
        $db = $conexion->conectar();
        
        $sql = "SELECT t.*, u.nombre as profesor_nombre, m.nombre as materia_nombre 
                FROM tutorias t 
                JOIN usuarios u ON t.profesor_id = u.id 
                JOIN materias m ON t.materia_id = m.id 
                WHERE t.alumno_id = $alumno_id 
                ORDER BY t.fecha DESC";
        
        $resultado = $db->query($sql);
        
        $tutorias = array();
        while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $tutorias[] = $fila;
        }
        
        return $tutorias;
    }
}
?>