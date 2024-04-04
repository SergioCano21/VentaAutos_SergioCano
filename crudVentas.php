<?php
include('conn.php');

if(isset($_GET['accion'])){
    $accion = $_GET['accion'];

    if($accion == 'leer'){
        $sql = "SELECT ventas.id, clientes.nombre, clientes.apellido, autos.marca, autos.modelo, autos.año, autos.no_serie 
                FROM ventas 
                JOIN clientes ON (ventas.id_Cliente = clientes.id)
                JOIN autos ON (ventas.id_Auto = autos.id)
                WHERE 1";
        $result = $db->query($sql);

        if($result->num_rows > 0){
            while($fila = $result->fetch_assoc()){
                $item['id'] = $fila['id'];
                $item['nombre'] = $fila['nombre'];
                $item['apellido'] = $fila['apellido'];
                $item['marca'] = $fila['marca'];
                $item['modelo'] = $fila['modelo'];
                $item['año'] = $fila['año'];
                $item['no_serie'] = $fila['no_serie'];

                $arrVentas[] = $item;
            }
            $response["status"] = "OK";
            $response["mensaje"] = $arrVentas;
        }
        else{
            $response["status"] = "Error";
            $response["mensaje"] = "No hay ventas registradas";
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
$data = json_decode(file_get_contents('php://input'), true);
if(isset($data)){
    $accion = $data["accion"];

    if($accion == 'insertar'){
        $id_Cliente = $data["id_Cliente"];
        $id_Auto = $data["id_Auto"];

        $qry = "INSERT INTO ventas (id_Cliente, id_Auto) values ('$id_Cliente','$id_Auto')";
        if($db->query($qry)){
            $response["status"] = 'OK';
            $response["mensaje"] = 'El registro se creo correctamente';
        } else {
            $response["status"] = 'ERROR';
            $response["mensaje"] = 'No se pudo guardar el registro debido a un error';
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    if($accion == 'modificar'){
        $id = $data["id"];
        $id_Cliente = $data["id_Cliente"];
        $id_Auto = $data["id_Auto"];

        $qry = "UPDATE ventas SET id_Cliente = '$id_Cliente', id_Auto = '$id_Auto' WHERE id = '$id'";
        if($db->query($qry)){
            $response["status"] = 'OK';
            $response["mensaje"] = 'El registro se modifico correctamente';
        } else {
            $response["status"] = 'ERROR';
            $response["mensaje"] = 'No se pudo modificar el registro debido a un error';
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    if($accion == 'eliminar'){
        $id = $data["id"];

        $qry = "DELETE FROM ventas WHERE id = '$id'";
        if($db->query($qry)){
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