<?php
ini_set('display_errors', 1);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir archivos a BBDD y consultarlos o permitir descarga</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h1>Subir archivos por formulario, consultarlos y descargarlos</h1>

        <form action="./app.php" method="post" enctype="multipart/form-data"> <!-- enía datos de forma codificada, necesario para enviar archivos por el form, sólo si es post -->
            <input type="text" name="titulo" placeholder="Título de la imagen">
            <input type="text" name="alt" placeholder="Texto alternativo">
            <input type="file" name="archivo" placeholder="Selecciona la imagen">
            <input type="submit" class="boton">
        </form>

        <div class="matrix">
            <?php
            //Borramos archivos temporales
            $archivosTemporales = glob('./temp/*'); //obtenemos todos los nombres de los ficheros
            foreach($archivosTemporales as $item){
                if(is_file($item))
                unlink($item); //Eliminamos el archivo
            }


            //Nos conectamos y hacemos la consulta a tabla imágenes
            $con=mysqli_connect("localhost","igor_dbo","Areafor@01","igor_db");
            $sql="SELECT * FROM imagenes";
            $resultado=mysqli_query($con,$sql);
            if(mysqli_num_rows($resultado)>0){
                //recorro todas los registros de la tabla consultada
                while($fila=mysqli_fetch_array($resultado)){      
                    file_put_contents('./temp/'.$fila['id_imagen'].'.jpg', $fila['archivo']); //guardamos          
            ?>
            <div>                
                <img src="./temp/<?=$fila['id_imagen']?>.jpg" alt="">
                <a href="./temp/<?=$fila['id_imagen']?>.jpg" download="<?=$fila['id_imagen']?>.jpg">Descargar</a>
            </div>
            <?php
                }
            }
            ?>
        </div>

    </main>
</body>
</html>