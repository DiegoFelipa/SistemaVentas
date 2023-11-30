<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo Inventario</title>
    <!-- Bootstrap 4.6 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!-- css datatable -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <!-- Icono de pestaña -->
    <link rel="shortcut icon" href="../img/inventario.png">
</head>
<body>
<!-- Zona para componentes HTML -->
<div style="width:93%;margin: auto" class="mt-2">
    <h2 class="text-center md-4">Módulo de Inventario</h2>
    <butto class="btn btn-dark" id="mostrar-modal-registro" type="button" data-toggle="modal" data-target="#modal-inventario"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo</butto>
    <hr>
    <div class="table-responsive">
        <table class="table table-striped table-sm" id="tabla-inventario">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Precio IGV</th>
                    <th>Código de Barra</th>
                    <th>Stock</th>
                    <th>Tipo(Producto/Servicio)</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

</div>

<!-- Zona de Modales -->
<div class="modal fade" id="modal-inventario" tabindex="-1" aria-labelledby="titulo-modal-inventario" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="titulo-modal-inventario"> Registrar Producto/Servicio</h5>
      </div>
      <div class="modal-body">
        <form action="" id="formulario-inventario" autocomplete="off">
            <!-- Creación de controles -->
            <div class="row">
                <div class="col-md-8 form-group">
                    <label for="nombreproducto">Nombre:</label>
                    <input type="text" id="nombreproducto" class="form-control form-control-sm">
                </div>

                <div class="col-md-4 form-group">
                    <label for="precio">Precio:</label>
                    <input type="text" id="precio" class="form-control form-control-sm">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="precioigv">Precio con IGV:</label>
                    <input type="text" id="precioigv" class="form-control form-control-sm">
                </div>

                <div class="col-md-8 form-group">
                    <label for="codigobarra">Código de Barra:</label>
                    <input type="text" id="codigobarra" class="form-control form-control-sm">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="stock">Stock:</label>
                    <input type="text" id="stock" class="form-control form-control-sm">
                </div>

                <div class="col-md-8 form-group">
                    <label for="tipo">Tipo:</label>
                    <select name="tipo" id="tipo" class="form-control form-sm">
                        <option value="P" selected>Producto</option>
                        <option value="S">Servicio</option>
                    </select>
                </div>
            </div>
            

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="cancelar-modal" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button"  id="guardar-inventario" class="btn btn-sm btn-dark">Guardar</button>
      </div>
    </div>
  </div>
</div>


<!-- jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- Bootstrap 4.6 -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
<!-- DataTable -->
<script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Script de Fontawesome -->
<script src="https://kit.fontawesome.com/1380163bda.js" crossorigin="anonymous"></script>

<!-- Mis funciones y eventos javascript -->
<script>
    $(document).ready(function(){
        var datosNuevos = true;
        //Variables Globales
        var datos = {
            'operacion'        : "",
            'nombreproducto'   : "",
            'precio'           : "",
            'precioigv'        : "",
            'codigobarra'      : "",
            'stock'            : "",
            'tipo'             : ""
        };

        //SweetAlert2
        function alertar(textoMensaje = "") {
            Swal.fire({
                title: 'Productos/Servicios',
                text: textoMensaje,
                icon: 'info',
                footer: 'ARFECAS',
                timer: 2500,
                confirmButtonText: 'Aceptar'
            });
        }

        function alertarToast(titulo = "", textoMensaje = "", icono = "") {
            Swal.fire({
                title: titulo,
                text: textoMensaje,
                icon: icono,
                toast: true,
                position: 'bottom-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            });
        }

        //Mostrará los registro en el datatabñe
        function mostrarInventario(){
            $.ajax({
                url:'../controllers/inventario.controller.php',
                type:'GET',
                data:'operacion=listarInventario',
                success:function(result){
                    let registros = JSON.parse(result);
                    let nuevaFila = ``;

                    //Destruimos el dattable actual (solo puede existir uno)
                    let tabla = $("#tabla-inventario").DataTable();
                    tabla.destroy();

                    //Reiniciar todqaqs las filas de la tabla
                    $("#tabla-inventario tbody").html("");

                    //Recorremos toda la coleccion
                    registros.forEach(registro => {
                        //Creamos una nueva Fila HTML
                        nuevaFila = `
                            <tr>
                                <td>${registro['idinventario']}</td>
                                <td>${registro['nombreproducto']}</td>
                                <td>${registro['precio']}</td>
                                <td>${registro['precioigv']}</td>
                                <td>${registro['codigobarra']}</td>
                                <td>${registro['stock']}</td>
                                <td>${registro['tipo']}</td>
                                <td>${registro['estado']}</td>
                                <td>
                                    <a href="#" data-idinventario='${registro['idinventario']}' class="btn btn-sm btn-danger eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    <a href="#" data-idinventario='${registro['idinventario']}' class="btn btn-sm btn-info editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                        `;
                        //Agregamos a nueva fila al cuerpo de la tabla
                        $("#tabla-inventario tbody").append(nuevaFila);
                    });
                    //Construimos el DataTable con los nuevos datos
                    $('#tabla-inventario').DataTable({
                        language:{
                            url:'//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
                        }
                    });
                }
            });
        }

        //Limpiar campos del modal
        function limpiarFiltros() {
            $('#nombreproducto').val('');
            $('#precio').val('');
            $('#precioigv').val('');
            $('#codigobarra').val('');
            $('#stock').val('');
            $('#tipo').val('');
        }

        //Reiniciará los valores del formulario(inventario)
        function reiniciarFormulario(){
            $("#formulario-inventario")[0].reset();
        }

        //Modal registros datos iniciales
        function abrirModalRegistro(){
            datosNuevos = true;
            //Le indicimas el titulo del modal y su clase
            $(".modal-header").removeClass("bg-info");
            $(".modal-header").addClass("bg-dark");
            $("#titulo-modal-inventario").html("Registrar Producto/Servicio");

            //Button
            $("#guardar-cliente").removeClass("bg-info");
            $("#guardar-cliente").addClass("bg-dark");

            reiniciarFormulario();
        }

        //Registrar Producto o servicio
        function registrarInventario(){
            //Array que contiene los datos a enviar
            datos['nombreproducto']    = $("#nombreproducto").val();
            datos['precio']            = $("#precio").val();
            datos['precioigv']         = $("#precioigv").val();
            datos['codigobarra']       = $("#codigobarra").val();
            datos['stock']             = $("#stock").val();
            datos['tipo']              = $("#tipo").val();

            if (datosNuevos) {
                datos['operacion'] = "registrarInventario";
                titulo = "Registro"
                mensaje = "El Producto ha sido registrado correctamente";

            }else{
                datos['operacion'] = "actualizarInventario";
                datos['idinventario'] = idinventario;
                titulo = "Actualización"
                mensaje = "Los datos han sido actualizados correctamente";
            }

            //Validamos que los campos no esten vacios
            if(datos['nombreproducto'] == "" || datos['precio'] == "" || datos['precioigv'] == "" || datos['codigobarra'] == "" || datos['stock'] == "" || datos['tipo'] == ""){
                alertar("Complete el formulario por favor")
            }else{
                //Confirmacion de envio de datos
                Swal.fire({
                        title: titulo,
                        text: "¿Los datos ingresados son correctos?",
                        icon: "question",
                        footer: "ARFECAS",
                        confirmButtonText: "Aceptar",
                        confirmButtonColor: "#38AD4D",
                        showCancelButton: true,
                        cancelButtonText: "Cancelar",
                        cancelButtonColor: "#D3280A"
                }).then(result => {
                    if (result.isConfirmed) {
                        //Enviamos los datos por ajax
                        $.ajax({
                            url: '../controllers/inventario.controller.php',
                            type: 'GET',
                            data: datos,
                            success: function(result) {
                                alertarToast("Proceso completado", mensaje, "success")
                                setTimeout(function() {
                                    reiniciarFormulario();
                                    $('#modal-inventario').modal('hide');
                                    mostrarInventario();
                                }, 1800)
                            }
                        });
                    }
                });
            }
        }

        //Eliminar Producto/Servicio
        $("#tabla-inventario tbody").on("click", ".eliminar", function() {
            //Almacenamos la PK en una variable
            let idinventario = $(this).data("idinventario");

            Swal.fire({
                title: "Eliminar",
                text: "¿Esta seguro de eliminar el registro?",
                icon: "question",
                footer: "ARFECAS",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#38AD4D",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                cancelButtonColor: "#D3280A"
            }).then(result => {
                if (result.isConfirmed) {
                    //Enviamos los datos por ajax
                    $.ajax({
                        url: '../controllers/inventario.controller.php',
                        type: 'GET',
                        data: {
                            'operacion': 'eliminarInventario',
                            'idinventario': idinventario
                        },
                        success: function(result) {
                            if (result == "") {
                                idinventario = ``;
                                alertarToast("Eliminacion correcta", "El registro ha sido eliminado correctamente", "success")
                                mostrarInventario();
                            }
                        }
                    });
                }
            });
        });

        //Editar Producto/Servicio
        $("#tabla-inventario tbody").on("click", ".editar", function() {
            idinventario = $(this).data("idinventario");

            $.ajax({
                url: '../controllers/inventario.controller.php',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    'operacion': 'getInventario',
                    'idinventario': idinventario
                },
                success: function(result) {
                    $("#nombreproducto").val(result['nombreproducto']);
                    $("#precio").val(result['precio']);
                    $("#precioigv").val(result['precioigv']);
                    $("#codigobarra").val(result['codigobarra']);
                    $("#stock").val(result['stock']);
                    $("#tipo").val(result['tipo']);

                    //Canbiando la configuracion modal
                    $("#titulo-modal-inventario").html("Actualizar datos");
                    $(".modal-header").removeClass("bg-dark");
                    $(".modal-header").addClass("bg-info");
                    //Button
                    $("#guardar-inventario").removeClass("bg-dark");
                    $("#guardar-inventario").addClass("bg-info");

                    $("#modal-inventario").modal("show");
                    datosNuevos = false;
                }
            });

        });

        
        //Eventos
        $("#guardar-inventario").click(registrarInventario);
        $("#cancelar-modal").click(limpiarFiltros);
        $("#mostrar-modal-registro").click(abrirModalRegistro);

        //Funciones de carga automática
        mostrarInventario();

    });
</script>
    
</body>
</html>