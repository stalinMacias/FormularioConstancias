<!DOCTYPE html>

<html>
<head>
  <meta name="author" content="PracticantesServicioSocial">
  <meta charset="utf-8">

  <link rel="stylesheet" href="styles/common_styles.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css?family=Staatliches" rel="stylesheet">

  <title>Iniciar sesión</title>

</head>

<body>
  <div class="m-center">
    <div class="logo-container w-100">
      <img src="img/logo.jpg" alt="CUSur">
    </div>
    <div class="colorFondo">
      <!-- form Login -->
      <form id ="loginForm" method="POST" action="">
        <!-- Usuario -->
        <label class="labelBlock" for="usuario">Usuario</label>
        <input class="inputBlockDesign" id="usuario" type="text" placeholder="Ingresa tu código de usuario" name="usser" style="margin-bottom: 30px;">
        <!-- Contraseña -->
        <label class="labelBlock" for="contraseña">Contraseña</label>
        <input class="inputBlockDesign" id="contraseña" type="password" placeholder="Ingresa tu contraseña" name="password">
        <!-- Submit Button -->
        <div style="display:block;"></div>
        <button class ="botonesFormulario" type="submit">Entrar</button>
        <button class="botonesFormulario" onclick="location.href='index.php';" type="button">Volver</button>
      </form>
      <span id = "msg"> Por favor introduzca los datos solicitados </span>
      <!--    Este script modifica el texto del span con id = "msg".
      Por lo tanto debe de ir despues de que el span haya sido declarado y antes de la condición donde será invocado! -->
      <script type = "text/javascript">
      function mensajesLogueo(opcion){
        if(opcion == 1){
          document.getElementById("msg").innerHTML = "La contraseña introducida es incorrecta <br>";
        }else if(opcion == 2){
          document.getElementById("msg").innerHTML = "El usuario introducido no se encontró en la base de datos <br>";
        }
      }
      </script>
      <!-- Codigo php para validar el login al sistema -->
      <?php
      //Código para realizar las consultas a la BD
      require("php/conexion.php");
      $obj = new conectar();
      $conn = $obj -> conexion();

      if ($_POST) {
        //Recibir las variables enviadas por el metodo POST
        $usser = validate_input($_POST["usser"]);
        $password = validate_input($_POST["password"]);


        //Validar que los datos proporcionados coincidan con un registro en la base de datos
        $result = $conn->query("SELECT username, password FROM usuario WHERE username = '".$usser."'");

        $resultadoConsultaUsuario = "";
        $resultadoConsultaPassword = "";

        //Guardar en la variable $row el resultado de la consulta sql ---> Se almacena como tipo array, cada columna obtenida es una posicion del array!
        $row=mysqli_fetch_array($result);
        $resultadoConsultaUsuario = $row[0];
        $resultadoConsultaPassword = $row[1];

        if($resultadoConsultaUsuario == $usser && $resultadoConsultaPassword == $password){
          //Realizar la consulta para obtener el tipo de usuario del usuario introducido
          $result = $conn->query("SELECT tipo_usuario FROM usuario where username = '".$usser."'");
          $tipoUsuario = "";

          while($row=mysqli_fetch_array($result)) {
            //Asignar el tipo de usuario a la variable correspondiente para realizar el direccionamiento
            $tipoUsuario = $row[0];
          }

          mysqli_free_result($result);

          //En este punto, ya se valido que las credenciales de acceso proporcionadas existen en la base de datos, es aquí donde se debe de iniciar la variable de sesion!
          //Metodo para iniciar la sesión
          session_start();
          //Iniciar la variable de sesion con el usuario que se proporciono
          $_SESSION['usuario'] = $usser;
          $_SESSION['tipoUsuario'] = $tipoUsuario;

          /*
              *** Tipos de usuario ***
              0 -> Admin
              1 -> Usuario Normal
              2 -> Super Admin ---> Será el que tenga acceso a la sección de respaldo y restauración
          */


          //Realizar el direccionamiento al panel del admin [Dependiendo el tipo de usuario serán las secciones que se le mostraran]

          header("Location: adminIndex.php");

        }else if($resultadoConsultaUsuario == $usser && $resultadoConsultaPassword != $password){
          echo '<script> mensajesLogueo(1) </script>';
        }else{
          echo '<script> mensajesLogueo(2) </script>';
        }
      }

      function validate_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

      ?>
    </div>
  </div>
</body>
</html>
