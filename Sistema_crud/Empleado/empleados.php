<?php
$txtID = (isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre = (isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtApellidoP = (isset($_POST['txtApellidoP']))?$_POST['txtApellidoP']:"";
$txtApellidoM = (isset($_POST['txtApellidoM']))?$_POST['txtApellidoM']:"";
$txtCorreo = (isset($_POST['txtCorreo']))?$_POST['txtCorreo']:"";
$txtFoto = (isset($_FILES['txtFoto']["name"]))?$_FILES['txtFoto']["name"]:"";

$accion = (isset($_POST['accion']))?$_POST['accion']:"";
//acumula errores
$error=array();

//botones dentro del modal
$accionAgregar="";
$accionModificar=$accionEliminar=$accionCancelar="disabled";
$mostrarModal=false;

//incluir la conexion a la base de datos
include("../conexion/conexion.php");

switch ($accion) {
    case "btnAgregar":
        /*/validacion del furmulario
        if($txtNombre==""){
            $error['vchNombre']="Escribe el nombre";
        }
        if($txtApellidoP==""){
            $error['vchApellidoP']="Escribe el apellido paterno";
        }
        if($txtApellidoM==""){
            $error['vchApellidoM']="Escribe el apellido materno";
        }
        if($txtCorreo==""){
            $error['VchCorreo']="Escribe el correo";
        }
        if(count($error)>0){
            $mostrarModal=true;
            break;
        }*/
        //instruccion sql para insertar
        $sentencia=$pdo->prepare("INSERT INTO tblempleados(vchNombre,vchApellidoP,vchApellidoM,VchCorreo,VchFoto)
        VALUES(:Nombre,:ApellidoP,:ApellidoM,:Correo,:Foto)");
        //representacion
        $sentencia->bindParam(':Nombre',$txtNombre);
        $sentencia->bindParam(':ApellidoP',$txtApellidoP);
        $sentencia->bindParam(':ApellidoM',$txtApellidoM);
        $sentencia->bindParam(':Correo',$txtCorreo);

        //para saber cuando subi la foto el usuario si las imagenes son iguales
        //la imagen.jpg es la imag en por defecto  si no seagrega ninguna foto
        $Fecha = new DateTime();
        $nombreArchivo=($txtFoto!="")?$Fecha->getTimestamp()."_".$_FILES["txtFoto"]["name"]:"imagen.jpg";
        //recolecta la fotografia en elfurmulario
        $tmpFoto = $_FILES["txtFoto"]["tmp_name"];
        //copia la imagen al servidor
        if ($tmpFoto!="") {
            move_uploaded_file($tmpFoto,"../Imagenes/".$nombreArchivo);
        }

        $sentencia->bindParam(':Foto',$nombreArchivo);
        //ejecutar
        $sentencia->execute();
        header('Location: index.php');

    break;

    case "btnModificar":
        //instruccion sql para modificar
        $sentencia=$pdo->prepare("UPDATE tblempleados SET
        vchNombre=:Nombre,
        vchApellidoP=:ApellidoP,
        vchApellidoM=:ApellidoM,
        VchCorreo=:Correo WHERE
        intId=:id");
        
        //representacion
        $sentencia->bindParam(':Nombre',$txtNombre);
        $sentencia->bindParam(':ApellidoP',$txtApellidoP);
        $sentencia->bindParam(':ApellidoM',$txtApellidoM);
        $sentencia->bindParam(':Correo',$txtCorreo);
        $sentencia->bindParam(':id',$txtID);
        //ejecutar
        $sentencia->execute();
        //funcion de lafoto

        //para saber cuando subi la foto el usuario si las imagenes son iguales
        //la imagen.jpg es la imag en por defecto  si no seagrega ninguna foto
        $Fecha = new DateTime();
        $nombreArchivo=($txtFoto!="")?$Fecha->getTimestamp()."_".$_FILES["txtFoto"]["name"]:"imagen.jpg";
        //recolecta la fotografia en elfurmulario
        $tmpFoto = $_FILES["txtFoto"]["tmp_name"];
        //copia la imagen al servidor
        if ($tmpFoto!="") {
            move_uploaded_file($tmpFoto,"../Imagenes/".$nombreArchivo);
            
            //busca la fotografia que se envio
            $sentencia=$pdo->prepare("SELECT VchFoto FROM tblempleados WHERE intId=:id");
            //representacion
            $sentencia->bindParam(':id',$txtID);
            //ejecutar
            $sentencia->execute();
            $empleado=$sentencia->fetch(PDO::FETCH_LAZY);
            print_r($empleado);

            //si existe la fotografia verifica en la carpeta imnagen
            if(isset($empleado["VchFoto"])) {
                if (file_exists("../Imagenes/".$empleado["VchFoto"])) {
                    //realiza elborrado
                    if ($empleado['VchFoto']!="imagen.jpg") {
                        unlink("../Imagenes/".$empleado["VchFoto"]);
                    }
                }
            }

            $sentencia=$pdo->prepare("UPDATE tblempleados SET
            VchFoto=:Foto WHERE intId=:id");
            $sentencia->bindParam(':Foto',$nombreArchivo);
            $sentencia->bindParam(':id',$txtID);
            $sentencia->execute();
        }

        //redirecciona a la pagina
        header('Location: index.php');

    break;

    case "btnEliminar":
        //busca la fotografia que se envio
        $sentencia=$pdo->prepare("SELECT VchFoto FROM tblempleados WHERE intId=:id");
        //representacion
        $sentencia->bindParam(':id',$txtID);
        //ejecutar
        $sentencia->execute();
        $empleado=$sentencia->fetch(PDO::FETCH_LAZY);
        print_r($empleado);

        //si existe la fotografia verifica en la carpeta imnagen
        if(isset($empleado["VchFoto"])&&($item['Foto']!="imagen.jpg")) {
            if (file_exists("../Imagenes/".$empleado["VchFoto"])) {
                //realiza elborrado
                unlink("../Imagenes/".$empleado["VchFoto"]);
            }
        }
        
        //instruccion sql para eliminar
        $sentencia=$pdo->prepare("DELETE FROM tblempleados WHERE intId=:id");
        //representacion
        $sentencia->bindParam(':id',$txtID);
        //ejecutar
        $sentencia->execute();
        //redirecciona a la pagina
        header('Location: index.php');

    break;

    case "btnCancelar":
        header('Location: index.php');
    break;
    case "Seleccionar":
        $accionAgregar="disabled";
        $accionModificar=$accionEliminar=$accionCancelar="";
        $mostrarModal=true;

        //busca la fotografia que se envio
        $sentencia=$pdo->prepare("SELECT VchFoto FROM tblempleados WHERE intId=:id");
        //representacion
        $sentencia->bindParam(':id',$txtID);
        //ejecutar
        $sentencia->execute();
        $empleado=$sentencia->fetch(PDO::FETCH_LAZY);

        /*$txtNombre=$empleado['vchNombre'];
        $txtApellidoP=$empleado['vchApellidoP'];
        $txtApellidoM=$empleado['vchApellidoM'];
        $txtCorreo=$empleado['VchCorreo'];*/
        $txtFoto=$empleado['VchFoto'];
    break;
}
    //seleccion de latabla tblempleadospara mostrar los datos
    $sentencia= $pdo->prepare("SELECT * FROM tblempleados WHERE 1");
    $sentencia->execute();
    $listaEmpleados=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    //comprovar se resiven los datos
    //print_r($listaEmpleados);

?>