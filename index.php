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
} catch (PDOException $e) {
    echo "Error al conectarse a la base de datos: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #7bc74d;
        }

        .container {
            margin-top: 50px;
            padding: 20px;
            background-color: #fff7d6;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            margin-bottom: 50px;
            font-weight: bold;
            color: #333;
        }

        h2 {
            margin-top: 50px;
            margin-bottom: 30px;
            font-weight: bold;
            color: #333;
        }

        th {
            font-weight: bold;
            background-color: #5cb85c;
            color: white;
        }

        td {
            vertical-align: middle;
        }

        .btn-actualizar {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-actualizar:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-eliminar {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-eliminar:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Tabla de estudiantes y escuelas</h1>
    <h2>Estudiantes</h2>
    <!-- Botón para desplegar el modal -->
<button type="button" class="btn btn-primary m-3" data-toggle="modal" data-target="#modalNuevoEstudiante">
  Agregar nuevo estudiante
</button>

<!-- Modal para agregar nuevo estudiante -->
<div class="modal fade" id="modalNuevoEstudiante" tabindex="-1" role="dialog" aria-labelledby="modalNuevoEstudianteLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalNuevoEstudianteLabel">Agregar nuevo estudiante</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formNuevoEstudiante">
          <div class="form-group">
            <label for="cedula">Cédula</label>
            <input type="text" class="form-control" id="cedula-modal" name="cedula" required>
          </div>
          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre-modal" name="nombre" required>
          </div>
          <div class="form-group">
            <label for="codigo_escuela">Código Escuela</label>
            <input type="text" class="form-control" id="codigo_escuela-modal" name="codigo_escuela" required>
          </div>
          <div class="form-group">
            <label for="direccion">Dirección</label>
            <input type="text" class="form-control" id="direccion-modal" name="direccion" required>
          </div>
          <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" class="form-control" id="telefono-modal" name="telefono" required>
          </div>
          <div class="form-group">
            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
            <input type="date" class="form-control" id="fecha_nacimiento-modal" name="fecha_nacimiento" required>
          </div>
          <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status-modal" name="status" required>
              <option value="A">Activo</option>
              <option value="I">Retirado</option>
              <option value="E">Egresado</option>              
              <option value="N">No inscrito</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnAgregarEstudiante">Agregar</button>
      </div>
    </div>
  </div>
</div>
    <table class="table table-bordered">
        <thead class="thead-light">
        <tr>
            <th>Id Estudiante</th>
            <th>Cédula</th>
            <th>Nombre</th>
            <th>Código Escuela</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Fecha de Nacimiento</th>
            <th>Status</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php 
            try {
                $stmt = $pdo->query("SELECT * FROM estudiantes");

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo '<td>' . $row['idestudiante'] . '</td>';
                    echo '<td>' . $row['cedula'] . '</td>';
                    echo '<td>' . $row['nombreest'] . '</td>';
                    echo '<td>' . $row['codescuela'] . '</td>';
                    echo '<td>' . $row['direccionest'] . '</td>';
                    echo '<td>' . $row['telefonoest'] . '</td>';
                    echo '<td>' . $row['fechanac'] . '</td>';
                    echo '<td>' . $row['statusest'] . '</td>';
                    echo '<td>';
                    echo '<button class="btn btn-actualizar mb-1 text-white">Actualizar</button>';
                    echo '<button class="btn btn-eliminar text-white">Eliminar</button>';
                    echo '</td>';
                    echo '</tr>';
                }
            } catch (PDOException $e) {
                echo "Error al conectarse a la base de datos: " . $e->getMessage();
            }
        ?>
        <!-- Agregar más filas con datos de estudiantes -->
        </tbody>
    </table>

    <h2>Escuelas</h2>
    <!-- Botón para desplegar el modal -->
<button type="button" class="btn btn-primary m-3" data-toggle="modal" data-target="#modalNuevaEscuela">
  Agregar nueva escuela
</button>

<!-- Modal para agregar nueva escuela -->
<div class="modal fade" id="modalNuevaEscuela" tabindex="-1" role="dialog" aria-labelledby="modalNuevaEscuelaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalNuevaEscuelaLabel">Agregar nueva escuela</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formNuevaEscuela">
          <div class="form-group">
            <label for="codigo">Código</label>
            <input type="text" class="form-control" id="codigo" name="codigo" required>
          </div>
          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
          </div>
          <div class="form-group">
            <label for="fecha_creacion">Fecha de creación</label>
            <input type="date" class="form-control" id="fecha_creacion" name="fecha_creacion" required>
          </div>
          <input type="hidden" id="codescuela" name="codescuela" value="<?php echo $codescuela; ?>">
          <input type="hidden" id="nombreesc" name="nombreesc" value="<?php echo $nombreesc; ?>">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnAgregarEscuela">Agregar</button>
      </div>
    </div>
  </div>
</div>

    <table class="table table-bordered">
        <thead class="thead-light">
        <tr>
            <th>Código Escuela</th>
            <th>Nombre</th>
            <th>Fecha de Creación</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php

            //Establecer conexión a la base de datos
            try {
             
                //Select a la tabla escuelas
                $stmt = $pdo->query("SELECT * FROM escuela");

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo '<td>' . $row['codescuela'] . '</td>';
                    echo '<td>' . $row['nombreesc'] . '</td>';
                    echo '<td>' . $row['fechacreacion'] . '</td>';
                    echo '<td>';
                    echo '<button class="btn btn-actualizar text-white mr-1">Actualizar</button>';
                    echo '<button class="btn btn-eliminar text-white">Eliminar</button>';
                    echo '</td>';
                    echo '</tr>';
                }

            } catch (PDOException $e) {
                echo "Error al conectarse a la base de datos: " . $e->getMessage();
            }
        ?>
        <!-- Agregar más filas con datos de escuelas -->
        </tbody>
    </table>
</div>
<script>
  //Función para enviar los datos del formulario de nuevo estudiante a través de AJAX
  function agregarEstudiante() {
    //Datos del estudiante
    const cedula = document.getElementById("cedula-modal").value;
    const nombre = document.getElementById("nombre-modal").value;
    const codigo_escuela = document.getElementById("codigo_escuela-modal").value;
    const direccion = document.getElementById("direccion-modal").value;
    const telefono = document.getElementById("telefono-modal").value;
    const fecha_nacimiento = document.getElementById("fecha_nacimiento-modal").value;
    const status = document.getElementById("status-modal").value;

    console.log({
        cedula,
        nombre,
        codigo_escuela,
        direccion,
        telefono,
        fecha_nacimiento,
        status
    })

    const bodyTry = JSON.stringify({
        cedula: cedula,
        nombreest: nombre,
        codescuela: codigo_escuela,
        direccionest: direccion,
        telefonoest: telefono,
        fechanac: fecha_nacimiento,
        statusest: status
      })

    //Solicitud fetch para enviar los datos a través de AJAX
    fetch("insertEstudiante.php", {
      method: "POST",
      body: bodyTry,
      headers: {
        "Content-Type": "application/json"
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        //Actualizar la tabla de estudiantes
        //...
        //Cerrar el modal
        $('#modalNuevoEstudiante').modal('hide');
      } else {
        // alert("Error al insertar estudiante: " + data.message);
        console.log("Error al insertar estudiante: " + data.message);
      }
    })
    .catch(error => {
    console.log("Error al insertar estudiante: " + error);

      alert("Error al insertar estudiante: " + error);
    });
  }

  //Asignar la función de enviarel formulario al botón de agregar estudiante
  const btnAgregarEstudiante = document.getElementById("btnAgregarEstudiante");
  btnAgregarEstudiante.addEventListener("click", agregarEstudiante);

    //Función para enviar los datos del formulario de nueva escuela a través de AJAX
    function agregarEscuela() {
    //Datos de la escuela
    const codigo = document.getElementById("codigo").value;
    const nombre = document.getElementById("nombre").value;
    const fecha_creacion = document.getElementById("fecha_creacion").value;
    const codescuela = document.getElementById("codescuela").value;
    const nombreesc = document.getElementById("nombreesc").value;

    //Solicitud fetch para enviar los datos a través de AJAX
    fetch("insertar_escuela.php", {
      method: "POST",
      body: JSON.stringify({
        codigo: codigo,
        nombre: nombre,
        fecha_creacion: fecha_creacion,
        codescuela: codescuela,
        nombreesc: nombreesc
      }),
      headers: {
        "Content-Type": "application/json"
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        //Actualizar la tabla de escuelas
        //...
        //Cerrar el modal
        $('#modalNuevaEscuela').modal('hide');
      } else {
        alert("Error al insertar escuela: " + data.message);
      }
    })
    .catch(error => {
      alert("Error al insertar escuela: " + error);
    });
  }

  //Asignar la función de enviar el formulario al botón de agregar escuela
  const btnAgregarEscuela = document.getElementById("btnAgregarEscuela");
  btnAgregarEscuela.addEventListener("click", agregarEscuela);
</script>
</body>
</html>