<?php
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] != 'profesor') {
    header('Location: ../index.php');
    exit;
}
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
        
        <h2>Mis Horarios de Tutoría</h2>
        
        <?php if (isset($_GET['mensaje'])): ?>
            <div class="mensaje-exito">✅ <?php echo $_GET['mensaje']; ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="error">error<?php echo $_GET['error']; ?></div>
        <?php endif; ?>

        <form method="POST" action="guardar_horarios_semana.php">
            <h3>Selecciona los días de la semana:</h3>
            
            <div style="margin: 15px 0;">
                <label><input type="checkbox" name="dias_semana[]" value="Lunes"> Lunes</label><br>
                <label><input type="checkbox" name="dias_semana[]" value="Martes"> Martes</label><br>
                <label><input type="checkbox" name="dias_semana[]" value="Miércoles"> Miércoles</label><br>
                <label><input type="checkbox" name="dias_semana[]" value="Jueves"> Jueves</label><br>
                <label><input type="checkbox" name="dias_semana[]" value="Viernes"> Viernes</label><br>
                <label><input type="checkbox" name="dias_semana[]" value="Sábado"> Sábado</label>
            </div>
            






            <label>Hora inicio:</label>
            <select name="hora_inicio" required>
                <option value="07:00:00">7:00 AM</option>
                <option value="08:00:00">8:00 AM</option>
                <option value="09:00:00">9:00 AM</option>
                <option value="10:00:00">10:00 AM</option>
                <option value="11:00:00">11:00 AM</option>
                <option value="12:00:00">12:00 PM</option>
                <option value="13:00:00">1:00 PM</option>
                <option value="14:00:00">2:00 PM</option>
                <option value="15:00:00">3:00 PM</option>
                <option value="16:00:00">4:00 PM</option>
                <option value="17:00:00">5:00 PM</option>
            </select>






            
            <label>Hora fin:</label>
            <select name="hora_fin" required>
                <option value="08:00:00">8:00 AM</option>
                <option value="09:00:00">9:00 AM</option>
                <option value="10:00:00">10:00 AM</option>
                <option value="11:00:00">11:00 AM</option>
                <option value="12:00:00">12:00 PM</option>
                <option value="13:00:00">1:00 PM</option>
                <option value="14:00:00">2:00 PM</option>
                <option value="15:00:00">3:00 PM</option>
                <option value="16:00:00">4:00 PM</option>
                <option value="17:00:00">5:00 PM</option>
                <option value="18:00:00">6:00 PM</option>
            </select>
            


            <label>Materia:</label>




            <select name="materia_id" required>
                <option value="">Selecciona una materia</option>


                
                <?php
                include_once 'models/TutoriaModel.php';
                $model = new TutoriaModel();
                $materias = $model->obtenerMaterias();
                foreach ($materias as $materia) {
                    echo "<option value='{$materia['id']}'>{$materia['nombre']}</option>";
                }
                ?>
            </select>
            
            <button type="submit">Agregar Horarios</button>
        </form>

       
    </div>
</body>
</html>