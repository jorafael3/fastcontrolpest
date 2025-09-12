<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Servicios</title>
</head>
<body>
    <h1>Test de Enlaces de Servicios</h1>
    
    <?php
    $servicios = include 'config/servicios.php';
    
    echo "<h2>Servicios disponibles:</h2>";
    echo "<ul>";
    foreach($servicios as $key => $servicio) {
        echo "<li>";
        echo "<a href='servicio-detalle.php?servicio=$key'>";
        echo $servicio['nombre'];
        echo "</a>";
        echo " (ID: $key)";
        echo "</li>";
    }
    echo "</ul>";
    
    echo "<h2>Parámetro recibido:</h2>";
    $servicio_param = $_GET['servicio'] ?? 'No especificado';
    echo "Servicio: " . $servicio_param;
    
    if (isset($_GET['servicio'])) {
        $servicio_data = $servicios[$_GET['servicio']] ?? null;
        if ($servicio_data) {
            echo "<h2>Datos del servicio:</h2>";
            echo "<pre>";
            print_r($servicio_data);
            echo "</pre>";
        } else {
            echo "<p style='color:red;'>Servicio no encontrado</p>";
        }
    }
    ?>
</body>
</html>
