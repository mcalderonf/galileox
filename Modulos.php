<?php
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
function notas(){
$id = $_REQUEST['id'];

	$conexion = conectarBD();
    $query = "SELECT  nota1, nota2,  nota3, cuestionario1, cuestionario2 from NOTAS
    			where id_alumno = $id";
	$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
	
	// Imprimir los resultados De BD
	echo "<table>\n";	
	$line = mysql_fetch_array($result, MYSQL_ASSOC);
	//print_r($line);
	echo "\t<tr>\n";
   			$nota1= $line['nota1'];
   			$nota2= $line['nota2'];
   			$nota3= $line['nota3'];
   			$cuestionario1= $line['cuestionario1'];
   			$cuestionario2= $line['cuestionario2']; 
   			
   			//porcentaje  : nota * 100/7
   			$multiplicador=100; 
   			$divisor=7;
   			
   			$porcentaje_nota1 = $nota1 *  $multiplicador /$divisor;
   			$porcentaje_nota2 = $nota2 *  $multiplicador /$divisor;
   			$porcentaje_nota3 = $nota3 *  $multiplicador /$divisor;
   			$porcentaje_cuestionario1 = $cuestionario1 *  $multiplicador /$divisor;
   			$porcentaje_cuestionario2 = $cuestionario2 *  $multiplicador /$divisor;
   			
   			//dedondeamos los totales 
   			$porcentaje_nota1 = round($porcentaje_nota1,2);
   			$porcentaje_nota2 = round($porcentaje_nota2,2);
   			$porcentaje_nota3 = round($porcentaje_nota3,2);
   			$porcentaje_cuestionario1 = round($porcentaje_cuestionario1,2);
   			$porcentaje_cuestionario2 = round($porcentaje_cuestionario2,2);
    		//id =  id del alumno
    	echo "\t\t<td>NOTA1: $nota1  Porcentaje:$porcentaje_nota1%  </td>\n";
    echo "\t</tr>\n";
    echo "\t<tr>\n";
  	  echo "\t\t<td>NOTA2: $nota2 Porcentaje:$porcentaje_nota2%</td><br/>\n";
 	echo "\t</tr>\n";
 	echo "\t<tr>\n";
  	  echo "\t\t<td>NOTA2: $nota3 Porcentaje:$porcentaje_nota3%</td><br/>\n";
 	echo "\t</tr>\n";
 	echo "\t<tr>\n";
  	  echo "\t\t<td>CUESTIONARIO1: $cuestionario1 Porcentaje:$porcentaje_cuestionario1%</td><br/>\n";
 	echo "\t</tr>\n";
 	echo "\t<tr>\n";
  	  echo "\t\t<td>CUESTIONARIO2: $cuestionario2 Porcentaje:$porcentaje_cuestionario2%</td><br/>\n";
 	echo "\t</tr>\n";
	echo "</table>\n";
	//para el grafico  porcentaje; SUMA de las notas *100 / suma del total de notas
	$divisor_grafico = 35;
	$porcentaje_grafico = ($nota1 + $nota2 + $nota3 +$cuestionario1 + $cuestionario2)*$multiplicador/$divisor_grafico;
	
	$porcentaje_grafico = round($porcentaje_grafico,2);
	
	
	//imprime el html con el grafico
	print"<html>
  <head>
    <!--Load the AJAX API-->
    <script type=\"text/javascript\" src=\"https://www.google.com/jsapi\"></script>
    <script type=\"text/javascript\">

      // llama a piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // llama a  Google Visualization API.
      google.setOnLoadCallback(drawChart);

      function drawChart() {

        // Crea la tabla de los porcentajes.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          ['NOTAS1', $porcentaje_nota1],
          ['NOTAS2', $porcentaje_nota2],
          ['NOTAS3', $porcentaje_nota3],
          ['CUESTIONARIO1', $porcentaje_cuestionario1],
          ['CUESTIONARIO2', $porcentaje_cuestionario2]
       
        ]);

        // ttitulo , tamaÒo del grafico.
        var options = {'title':'NOTAS',
                       'width':600,
                       'height':500};

        // tres el grafico
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>

  <body>
    <!--muestra el grafico-->
    <div id=\"chart_div\"></div>
  </body>
</html>";
	
	echo "<input type=\"button\" value=\"Volver\" onclick=\"history.back(-1)\" />";
//Por implementar que cuando se haga click se valla hacia atras. 	
	if(isset($_POST['b_volver_x'])) 
    { 
		$desde = $_SERVER['HTTP_REFERER'];
    	 header ("Location: ".$desde);
    }
	 

  	
	// Liberar resultados
desconectarBD($conexion);
}
notas();
?>