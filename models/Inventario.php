<?php
//Requerimos acceso a la clase conexion
require_once "Conexion.php";

//La clase producto será subclase de Conexion
class Inventario extends Conexion{
    //Objeto que almacena la conexion que obtenemos
    private $acceso;

    //Constructor
    public function __construct(){
        $this->acceso = parent::getConexion();
    }

    public function listarInventario(){
        try{
            //Preapramos la consulta
            $consulta = $this->acceso->prepare("CALL spu_inventario_listar()");

            //Ejecutamos la consulta
            $consulta->execute();
            
            $datos = $consulta->fetchALL(PDO::FETCH_ASSOC);
            return  $datos;      
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function registrarInventario($datosGuardar){
        try{
            $consulta = $this->acceso->prepare("CALL spu_inventario_registrar(?,?,?,?,?,?)");
            $consulta->execute(array(
                $datosGuardar['nombreproducto'],
                $datosGuardar['precio'],
                $datosGuardar['precioigv'],
                $datosGuardar['codigobarra'],
                $datosGuardar['stock'],
                $datosGuardar['tipo']
            ));
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function eliminarInventario($idinventario){
        try{
            $consulta = $this->acceso->prepare("CALL spu_inventario_eliminar(?)");
            $consulta->execute(array($idinventario));
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function getInventario($idinventario){
        try{
            $consulta = $this->acceso->prepare("CALL spu_inventario_obtener(?)");
            $consulta->execute(array($idinventario));

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function actualizarInventario($datosGuardar){
        try{
            $consulta = $this->acceso->prepare("CALL spu_inventario_actualizar(?,?,?,?,?,?,?)");
            $consulta->execute(array(
                $datosGuardar['idinventario'],
                $datosGuardar['nombreproducto'],
                $datosGuardar['precio'],
                $datosGuardar['precioigv'],
                $datosGuardar['codigobarra'],
                $datosGuardar['stock'],
                $datosGuardar['tipo']
            ));
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

}


?>