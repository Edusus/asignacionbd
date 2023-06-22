<?php
//Datos de conexión a la base de datos
$host = "localhost";
$port = "5432";
$dbname = "estudiantesbd";
$user = "postgres";
$password = "capibara";

//Establecer conexión a la base de datos
try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //Recibir los datos del formulario enviado por POST
    $cedula = $_POST['cedula'];
    $nombreest = $_POST['nombreest'];
    $codescuela = $_POST['codescuela'];
    $direccionest = $_POST['direccionest'];
    $telefonoest = $_POST['telefonoest'];
    $fechanac = $_POST['fechanac'];
    $statusest = $_POST['statusest'];

    //Insertar los datos en la tabla de estudiantes
    $stmt = $pdo->prepare("INSERT INTO estudiantes (cedula, nombreest, codescuela, direccionest, telefonoest, fechanac, statusest) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$cedula, $nombreest, $codescuela, $direccionest, $telefonoest, $fechanac, $statusest]);
    
    //Enviar una respuesta en formato JSON
    $response = array('success' => true);
    echo json_encode($response);

} catch (PDOException $e) {
    //Enviar una respuesta en formato JSON en caso de error
    $response = array('success' => false, 'message' => $e->getMessage());
    echo json_encode($response);
}
?>