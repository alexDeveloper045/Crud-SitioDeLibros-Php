<?php 
include("../template/cabecera.php");?>

<?php 
//condicion ternaria
$txtID=(isset($_POST["txtID"]))?$_POST["txtID"]:"";
$txtNombre=(isset($_POST["txtNombre"]))?$_POST["txtNombre"]:"";
//la imagenes se recepcionan con el metodo file y comos es un array podemos seleccionar
//lo que queremos que se muestre como en este caso ['name']
$txtImagen=(isset($_FILES["txtImagen"]['name']))?$_FILES["txtImagen"]['name']:"";
$accion=(isset($_POST["accion"]))?$_POST["accion"]:"";

include("../config/db.php");

switch ($accion) {



    //INSERT INTO `libros` (`id`, `nombre`, `imagen`) VALUES (NULL, 'libro para emprendedor', 'imagen.jpg');
    case 'agregar':

        $sentenciaSQL= $conexion->prepare("INSERT INTO `libros` (nombre,imagen) VALUES (:nombre,:imagen);");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);

        $fecha= new DateTime();
        $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
        $tmpImagen=$_FILES['txtImagen']['tmp_name'];

        if($tmpImagen!=""){
            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
        }

        $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
        $sentenciaSQL->execute();
        
        break;

        case 'modificar':
            
            $sentenciaSQL= $conexion->prepare("UPDATE libros SET nombre=:nombre WHERE id=:id");

        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();


        if($txtImagen!=""){
            $fecha= new DateTime();
            $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
             $tmpImagen=$_FILES['txtImagen']['tmp_name'];

             move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

             $sentenciaSQL= $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
             $sentenciaSQL->bindParam(':id',$txtID);
             $sentenciaSQL->execute();
             $libro= $sentenciaSQL->fetch(PDO::FETCH_LAZY);

             if(isset($libro['imagen']) && $libro['libro']!='imagen.jpg'){
                 if(file_exists("../../img/".$libro["imagen"])){

                 //con unlink borramos archivos almacenados en las carpetas    
                     unlink("../../img/".$libro["imagen"]);
                 }
                 
             }

        $sentenciaSQL= $conexion->prepare("UPDATE libros SET imagen=:imagen WHERE id=:id");
        $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();



        }
            break;

            case 'cancelar':
                
                header('location:productos.php');
                break;

                case 'seleccionar':
                    
                    $sentenciaSQL= $conexion->prepare("SELECT * FROM libros WHERE id=:id");
                    $sentenciaSQL->bindParam(':id',$txtID);
                    $sentenciaSQL->execute();
                    $libro= $sentenciaSQL->fetch(PDO::FETCH_LAZY);

                    $txtNombre= $libro['nombre'];
                    $txtImagen= $libro['imagen'];

                    break;

                    case 'borrar':
                        //Borrar imagen 
                        $sentenciaSQL= $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
                        $sentenciaSQL->bindParam(':id',$txtID);
                        $sentenciaSQL->execute();
                        $libro= $sentenciaSQL->fetch(PDO::FETCH_LAZY);

                        if(isset($libro['imagen']) && $libro['libro']!='imagen.jpg'){
                            if(file_exists("../../img/".$libro["imagen"])){

                            //con unlink borramos archivos almacenados en las carpetas    
                                unlink("../../img/".$libro["imagen"]);
                            }
                            
                        }
                        
                        $sentenciaSQL= $conexion->prepare("DELETE FROM libros WHERE id=:id");
                        $sentenciaSQL->bindParam(':id',$txtID);
                        $sentenciaSQL->execute();

                        break;
    
    default:
        # code...
        break;
}
$sentenciaSQL= $conexion->prepare("SELECT * FROM libros");
$sentenciaSQL->execute();
$listaLibros= $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="col-md-5">
    <h2>Formulario de libros</h2>

    <div class="card">
        <div class="card-header">
            Datos de libro
        </div>
        <div class="card-body">
            
    <form method="POST" enctype="multipart/form-data">

    <div class = "form-group">
    <label for="txtID" hidden>ID</label>
    <input type="text" hidden class="form-control" name="txtID" value="<?php echo $txtID?>" id="txtID" placeholder="id">
    </div>

    <div class = "form-group">
    <label for="txtNombre">Nombre del libro</label>
    <input type="text" required class="form-control" name="txtNombre" value="<?php echo $txtNombre?>" id="txtNombre" placeholder="nombre del libro">
    </div>

    <div class = "form-group">
    <label for="txtImagen">Portada</label>
    <input type="file" class="form-control" name="txtImagen" value="<?php echo $txtImagen?>" id="txtImagen">
    </div>

    <div class="form-group" role="group" aria-label="">
        <button type="submit" class="btn btn-success" name="accion"<?php echo ($accion == "seleccionar"?"disabled":"")?> value="agregar">agregar</button>
        <button type="submit" class="btn btn-warning" name="accion"<?php echo ($accion != "seleccionar"?"disabled":"")?> value="modificar">modificar</button>
        <button type="submit" class="btn btn-info" name="accion"<?php echo ($accion != "seleccionar"?"disabled":"")?> value="cancelar">cancelar</button>
        
    </div>

    

    </form>
        </div>
        
    </div>

    
    
</div>

<div class="col-md-7">
   
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>Imagen
                <th>Nombre</th>
                <th>Portada</th>
                <th>acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listaLibros as $libro){ ?>
            <tr>
                <td><?php echo $libro['id'];?></td>
                <td><?php echo $libro['nombre'];?></td>
                <td><img src="../../img/<?php echo $libro['imagen'];?>" width="100px" alt="" srcset=""></td>
                <td>
                Seleccionar | Borrar
                <form method="post">

                <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['id'];?>"/>
                <input type="submit" name="accion" value="seleccionar" class="btn btn-primary"/>
                <input type="submit" name="accion" value="borrar" class="btn btn-danger"/>

                </form>

                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php 
include("../template/pie.php");?>