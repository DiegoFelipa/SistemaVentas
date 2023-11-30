<?php
require_once '../models/Inventario.php';

if(isset($_GET['operacion'])){
    $inventario = new Inventario();

    if($_GET['operacion'] == 'listarInventario'){
        echo json_encode($inventario->listarInventario());
    }

    if ($_GET['operacion'] == 'registrarInventario'){
        $datosSolicitados = [
            "nombreproducto" => $_GET['nombreproducto'],
            "precio"         => $_GET['precio'],
            "precioigv"      => $_GET['precioigv'],
            "codigobarra"    => $_GET['codigobarra'],
            "stock"          => $_GET['stock'],
            "tipo"           => $_GET['tipo']
        ];
        $inventario->registrarInventario($datosSolicitados);
    }

    if($_GET['operacion'] == 'eliminarInventario'){
        $inventario->eliminarInventario($_GET['idinventario']);
    }

    if($_GET['operacion'] == 'getInventario'){
        echo json_encode($inventario->getInventario($_GET['idinventario']));
    }

    if($_GET['operacion'] == 'actualizarInventario'){
        $datosSolicitados = [
            "idinventario"      => $_GET['idinventario'],
            "nombreproducto"    => $_GET['nombreproducto'],
            "precio"            => $_GET['precio'],
            "precioigv"         => $_GET['precioigv'],
            "codigobarra"       => $_GET['codigobarra'],
            "stock"             => $_GET['stock'],
            "tipo"              => $_GET['tipo']
        ];

        $inventario->actualizarInventario($datosSolicitados);
    }
}



?>