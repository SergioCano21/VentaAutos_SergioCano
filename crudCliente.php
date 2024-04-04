<?php
include('conn.php');


//Verificamos la accion
if(isset($_GET['accion'])){
    $accion = $_GET['accion'];

    //Leer datos
    if($accion == 'leer'){  
        $sql = "select * from clientes where 1";
        $result = $db->query($sql);

        if($result->num_rows > 0){
            while($fila = $result->fetch_assoc()){
                $item['id'] = $fila['id'];
                $item['nombre'] = $fila['nombre'];
                $item['apellido'] = $fila['apellido'];
                $item['correo'] = $fila['correo'];

                $arrClientes[] = $item;
            }
            $response["status"] = "Ok";
            $response["mensaje"] = $arrClientes;
        }
        else{
            $response["status"] = "Error";
            $response["mensaje"] = "No hay clientes registrados";
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
    if($accion=='insertar') {

        //obtener los demas datos del body
        $nombre = $data["nombre"];
        $apellido = $data["apellido"];
        $correo = $data["correo"];

        $qry = "INSERT INTO clientes (nombre, apellido, correo) values ('$nombre','$apellido','$correo')";
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
        $nombre = $data["nombre"];
        $apellido = $data["apellido"];
        $correo = $data["correo"];

        $qry = "UPDATE clientes SET nombre = '$nombre',  apellido = '$apellido', correo = '$correo' WHERE id = '$id'";
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

        $qry = "DELETE FROM clientes WHERE id = '$id'";
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