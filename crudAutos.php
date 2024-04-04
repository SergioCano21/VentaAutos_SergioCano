<?php
include('conn.php');


//Verificamos la accion
if(isset($_GET['accion'])){
    $accion = $_GET['accion'];

    //Leer datos
    if($accion == 'leer'){  
        $sql = "select * from autos where 1";
        $result = $db->query($sql);

        if($result->num_rows > 0){
            while($fila = $result->fetch_assoc()){
                $item['id'] = $fila['id'];
                $item['marca'] = $fila['marca'];
                $item['modelo'] = $fila['modelo'];
                $item['año'] = $fila['año'];
                $item['no_serie'] = $fila['no_serie'];

                $arrAutos[] = $item;
            }
            $response["status"] = "Ok";
            $response["mensaje"] = $arrAutos;
        }
        else{
            $response["status"] = "Error";
            $response["mensaje"] = "No hay autos registrados";
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
$data = json_decode(file_get_contents('php://input'), true);
//Si yo paso los datos como JSON a traves del body
if(isset($data)) {

    //obtengo la accion
    $accion = $data["accion"];

    //verifico el tipo de accion
    if($accion == 'insertar') {

        //obtener los demas datos del body
        $marca = $data["marca"];
        $modelo = $data["modelo"];
        $año = $data["año"];
        $no_serie = $data["no_serie"];

        $qry = "INSERT INTO autos (marca, modelo, año, no_serie) values ('$marca','$modelo','$año', '$no_serie')";
        if($db->query($qry)) {
            $response["status"] = 'OK';
            $response["mensaje"] = 'El registro se creo correctamente';
        } else {
            $response["status"] = 'ERROR';
            $response["mensaje"] = 'No se pudo guardar el registro debido a un error';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    if($accion=='modificar') {

        //obtener los demas datos del body
        $id = $data["id"];
        $marca = $data["marca"];
        $modelo = $data["modelo"];
        $año = $data["año"];
        $no_serie = $data["no_serie"];

        $qry = "UPDATE autos SET marca = '$marca',  modelo = '$modelo', año = '$año' , no_serie = '$no_serie' WHERE id = '$id'";
        if($db->query($qry)) {
            $response["status"] = 'OK';
            $response["mensaje"] = 'El registro se actualizo correctamente';
        } else {
            $response["status"] = 'ERROR';
            $response["mensaje"] = 'No se pudo actualizar el registro debido a un error';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    if($accion=='eliminar') {

        //obtener los demas datos del body
        $id = $data["id"];

        $qry = "DELETE FROM autos WHERE id = '$id'";
        if($db->query($qry)) {
            $response["status"] = 'OK';
            $response["mensaje"] = 'El registro se elimino correctamente';
        } else {
            $response["status"] = 'ERROR';
            $response["mensaje"] = 'No se pudo eliminar el registro debido a un error';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}