<?php

$conexion = new PDO('mysql:host=sql5c75f.carrierzone.com;dbname=wp_sodenncom1611105','sodenncom1611105','QSU5EIjcE5');

if($conexion)
{
	if (isset($_GET['id'])) 
	{
		//obtengo los datos del medico de la bd con el id
		$id = $_GET['id'];
		$statement = $conexion->prepare('SELECT * FROM usuarios WHERE id LIKE :id');
		$statement->execute(array(':id' => $id));
		$fila = $statement->fetchAll();
		

		//obtengo el nombre de la especialidad

		$id_esp = $fila[0]['id_especialidad'];
		$statement2 = $conexion->prepare('SELECT especialidad_nombre FROM especialidades WHERE id_especialidad LIKE :id_esp');
		$statement2->execute(array(':id_esp' => $id_esp));
		$datos_esp = $statement2->fetchAll();

		//obtengo los datos de las clinicas
		
		$statement3 = $conexion->prepare('SELECT * from clinicas WHERE id_doctor LIKE :id');
		$statement3->execute(array(':id' => $id));
		$clinicas = $statement3->fetchAll();
	}
}
else
{
	echo "Error : No se conecto a la base de datos";
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Perfíl Médico</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <link rel="stylesheet" href="styles.css">


        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    </head>
    
    <body>
     <div class="nav-bar">
         <a href="http://sodenn.com/">Inicio</a>
         <a href="http://sodenn.com/new/index.php">Directorio</a>
         <a href="#">Perfíl</a>
         
     </div> 
     
     <div class="container">
     <?php if(isset($fila)) :?>
		<?php foreach($fila as $dato):?>

         <div class="img"><img src="<?=$dato['img']?>" alt="img-doctor"></div>
         <div class="name"><p><?php echo $dato['name'] ?></p></div>

         <div class="p-data">
            <div><i class="fas fa-book"></i><p class="esp"><?php echo $datos_esp[0]['especialidad_nombre'] ?></p></div>
            <div class="hover"><i class="fas fa-phone-square-alt"></i><a href="tel:<?php echo $dato['Telefono_1'] ?>"><?php echo $dato['Telefono_1'] ?></a><a href="tel:<?php echo $dato['Telefono_2'] ?>"><?php echo $dato['Telefono_2'] ?></a></div>
            <div class="correo"><i class="fas fa-envelope"></i><p><?php echo $dato['email'] ?></p></div>
            <div><i class="fas fa-map-marker-alt"></i></i><p class="esp"><?php echo $dato['region'] ?></p></div>
        </div>
        <?php endforeach;?>
	<?php endif; ?>

         <div class="data-work">
            <?php foreach ($clinicas as $clinica):?>                
                <div class="clinica"><span class="title"><?php echo $clinica['nombre_clinica'] ?></span><span class="address"><?php echo $clinica['direccion_clinica'] ?></span><div class="telfs" id="test"><?php echo $clinica['telefono_clinica'] ?></div></div>
                <?php//ch19?>
            <?php endforeach;?>  
         </div>         
     </div> 
    </body>
   
</html>