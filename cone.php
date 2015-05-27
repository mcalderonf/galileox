<?php
// conexion BD
function conectarBD(){ 
	$server = "localhost";
    $usuario = "root";
    $pass = "";
    $BD = "moodle";
     //variable que guarda la conexiÛn de la base de datos
     $conexion = mysql_connect($server, $usuario, $pass); 
     $conexion .= mysql_select_db($BD);
     //Comprobamos si la conexiÛn ha tenido exito
     if(!$conexion){ 
       echo 'Ha sucedido un error inexperado en la conexion de la base de datos<br>'; 
    } 
     //devolvemos el objeto de conexiÛn para usarlo en las consultas  
    return $conexion; 
}  
function desconectarBD($conexion){
   //Cierra la conexiÛn y guarda el estado de la operaciÛn en una variable
   $close = mysql_connect($conexion); 
   //Comprobamos si se ha cerrado la conexiÛn correctamente
   if(!$close){  
     echo 'Ha sucedido un error inexperado en la desconexion de la base de datos<br>'; 
   }    
   //devuelve el estado del cierre de conexiÛn
  return $close;         
}
function Alumnos(){
	$conexion = conectarBD();
    $query = 'SELECT * FROM ALUMNO';
	$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());

// Imprimir los resultados De BD
	echo "<table>\n";	
	while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
	//print_r($line);
	echo "\t<tr>\n";
    foreach ($line as $col_value) {
    									//id =  id del alumno
    		$id_alumno= $line['id'];
		 use Modulos.php;
        echo "\t\t<td><a href=\"modulos.php?id=$id_alumno\">$col_value</a></td>\n";
    }
    echo "\t</tr>\n";
	}
	echo "</table>\n";
	
	echo "<input type=\"button\" value=\"Volver\" onclick=\"history.back(-1)\" />";
  
  	
	// Liberar resultados
desconectarBD($conexion);
// Cerrar la conexiÛn
//mysql_close($link);
}
//llama a la funcion alumnos
Alumnos();  
?>