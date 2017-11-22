<?php

//conexiones, conexiones everywhere
ini_set('display_errors', 1);
error_reporting(E_ALL);
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$database = 'usuario_datos_personales';
$table = 'usuario_datos_personales';

$mysqli = new mysqli($db_host,$db_user,$db_pass,$database);
	 //servidor, usuario de base de datos, contraseña del usuario, nombre de base de datos

	if(mysqli_connect_errno()){
		echo 'Conexion Fallida : ', mysqli_connect_error();
		echo "conexion fallo";
		exit();
	}

		if (!$mysqli->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $mysqli->error);
    exit();
    }
    if(isset($_POST['submit']))
    {
        //Aquí es donde seleccionamos nuestro csv
         $fname = $_FILES['sel_file']['name'];
         echo 'Cargando nombre del archivo: '.$fname.' <br>';
         $chk_ext = explode(".",$fname);

         if(strtolower(end($chk_ext)) == "csv")
         {
             //si es correcto, entonces damos permisos de lectura para subir
             $filename = $_FILES['sel_file']['tmp_name'];
             $handle = fopen($filename, "r");

             while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
             {
               //Insertamos los datos con los valores...
               $sql = "INSERT into usuario_datos_personales(id, primer_apellido, segundo_apellido, nombre, trabajador, nif) values('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]')";

               if ($mysqli->query($sql) === TRUE) {
               		    echo "Se realizó con éxito";
               		} else {
               		    echo "Error updating record: " . $mysqli->error;
               		}



             }
             $mysqli->close();
             //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
             fclose($handle);
             echo "Importación exitosa!";
         }
         else
         {
            //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para
//ver si esta separado por " , "
             echo "Archivo invalido!";
         }
    }

?>
