<?php
class Conexion{
    //Atributo que almacena la conexion
    protected $pdo;

    //Método que accese al server < db
    private function Conectar(){
        $cn =  new PDO("mysql:host=localhost;port=3306;dbname=SistemasVentas;charset=utf8","root","");
        return $cn;

    }

    //Método que retorna / compartirá la conexion
    public function getConexion(){
        try{
        //Almacenamos la conexion en el atributo 'pdo'
        $pdo = $this->Conectar();

        //Controlar excepciones
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Retornamos la conexion
        return $pdo;
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }
}


?>