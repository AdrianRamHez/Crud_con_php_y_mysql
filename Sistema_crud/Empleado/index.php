<?php
    require 'empleados.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud con php mysql</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Empleado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-footer">
                        <input type="hidden" required name="txtID" value="<?php echo $txtID; ?>" placeholder="" id="txtID" require="">

                        <div class="form-group col-md-4">
                        <label for="">Nombre(s):</label>
                        <input type="text" class="form-control" required name="txtNombre" value="<?php echo $txtNombre; ?>" placeholder="" id="txtNombre" require="">
                            <!--div class="invalid-feedback">
                            /este apartado va en el input/?php echo (isset($error['vchNombre']))?"is-invalid":""; ?>
                                ?php echo (isset($error['vchNombre']))?$error['vchNombre']:""; ?>
                            </div-->
                        </div>

                        <div class="form-group col-md-4">
                        <label for="">Apellido Paterno:</label>
                        <input type="text" class="form-control" name="txtApellidoP" required value="<?php echo $txtApellidoP; ?>" placeholder="" id="txtApellidoP" require="">
                        
                        </div>

                        <div class="form-group col-md-4">
                        <label for="">Apellido Materno:</label>
                        <input type="text" class="form-control" name="txtApellidoM" required value="<?php echo $txtApellidoM; ?>" placeholder="" id="txtApellidoM" require="">
                        
                        </div>

                        <div class="form-group col-md-12">
                        <label for="">Correo:</label>
                        <input type="email" class="form-control" name="txtCorreo" required value="<?php echo $txtCorreo; ?>" placeholder="" id="txtCorreo" require="">
                        <br>
                        </div>

                        <div class="form-group col-md-12">
                        <label for="">Foto:</label>
                        <!--este if es para que se muestre laminiatura en elmodal-->
                        <?php if($txtFoto!=""){?>
                            <br>
                                <img class="img-thumbnail rounded mx-auto d-block" width="100px" src="../Imagenes/<?php echo $txtFoto; ?>" />
                            <br>
                            <br>
                        <?php } ?>
                        <input type="file" accept="image/*" name="txtFoto" value="<?php echo $txtFoto; ?>" placeholder="" id="txtFoto" require="">
                        <br>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                        <button value="btnAgregar" <?php echo $accionAgregar; ?> class="btn btn-success" type="submit" name="accion">Agregar</button>
                        <button value="btnModificar" <?php echo $accionModificar; ?> class="btn btn-warning" type="submit" name="accion">Modificar</button>
                        <button value="btnEliminar" onclick="return Confirmar('¿Deseas borrar?');" <?php echo $accionEliminar; ?> class="btn btn-danger" type="submit" name="accion">Eliminar</button>
                        <button value="btnCancelar" <?php echo $accionCancelar; ?> class="btn btn-primary" type="submit" name="accion">Cancelar</button>
                </div>
                </div>
            </div>
            </div>
            <br>
            
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            agregar registro +
            </button>
            <br>
            <br>

        </form>

        <div class="row">
                <table class="table table-hover table-bordered">
                <!-- encablesado de latabla -->
                    <thead class="thead-dark">
                        <tr>
                            <th>Foto</th>
                            <th>Nombre completo</th>
                            <th>Correo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <!--informacion de la base de tados mostrada en latabla-->
                    <?php foreach($listaEmpleados as $empleado){ ?>
                        <tr>
                            <td><img class="img-thumbnail" width="100px" src="../Imagenes/<?php echo $empleado['VchFoto']; ?>" ></td>
                            <td><?php echo $empleado['vchNombre']; ?> <?php echo $empleado['vchApellidoP']; ?> <?php echo $empleado['vchApellidoM']; ?></td>
                            <td><?php echo $empleado['VchCorreo']; ?></td>

                            <td>
                            <!--al ser precionado el boton es madado todo los datos al furmulario-->
                                <form action="" method="post">
                                    <input type="hidden" name="txtID" value="<?php echo $empleado['intId']; ?>">
                                    <input type="hidden" name="txtNombre" value="<?php echo $empleado['vchNombre']; ?>">
                                    <input type="hidden" name="txtApellidoP" value="<?php echo $empleado['vchApellidoP']; ?>">
                                    <input type="hidden" name="txtApellidoM"value="<?php echo $empleado['vchApellidoM']; ?>">
                                    <input type="hidden" name="txtCorreo" value="<?php echo $empleado['VchCorreo']; ?>">
                                    <!--input type="hidden" name="txtFoto" value="?php echo $empleado['VchFoto']; ?"-->
                                    
                                    <input type="submit" value="Seleccionar" class="btn btn-success" name="accion">
                                    <button value="btnEliminar" onclick="return Confirmar('¿Deseas borrar?');" type="submit" class="btn btn-danger" name="accion">Eliminar</button>
                                </form>
                            </td>

                        </tr>
                    <?php } ?>
                </table>
        </div>
        <!--para que el modal aaparesca-->
        <?php if($mostrarModal){ ?>
            <script>
                $('#exampleModal').modal('show');
            </script>
        <?php } ?>
        <!--para confirmar el borrado-->
        <script>
            function Confirmar(Mensaje){
                return (confirm(Mensaje))?true:false;
            }
        </script>
    </div>
    <script src="../js/jquery-3.2.1.min.js"></script>
</body>
</html>