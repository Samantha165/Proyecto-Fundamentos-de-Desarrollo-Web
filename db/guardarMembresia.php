<?php

require "./db.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php?error=Inicia sesion");
    return;
}

$membresia_id = $_POST['membresia_id'];
$precio       = $_POST['precio'];
$descripcion  = $_POST['descripcion'];
$slug         = $_POST['slug'];

$pivot_ids     = $_POST['pivot_id'];
$beneficio_ids = $_POST['beneficio_id'];
$textos        = $_POST['texto'];
$incluidos     = $_POST['incluido'];


$stmt = $con->prepare("UPDATE membresias SET precio = ?, descripcion = ? WHERE id = ?");
$stmt->bind_param("dsi", $precio, $descripcion, $membresia_id);

try {
    $stmt->execute();

if (isset($_POST['eliminar']) && is_array($_POST['eliminar'])) {
    foreach ($_POST['eliminar'] as $pivot_id) {
        if (!empty($pivot_id)) {
            $stmtGet = $con->prepare("SELECT beneficio_id FROM membresias_beneficios WHERE id = ?");
            $stmtGet->bind_param("i", $pivot_id);
            $stmtGet->execute();
            $res = $stmtGet->get_result();
            $row = $res->fetch_assoc();
            $beneficio_id = $row['beneficio_id'];

            $stmtDel1 = $con->prepare("DELETE FROM membresias_beneficios WHERE id = ?");
            $stmtDel1->bind_param("i", $pivot_id);
            $stmtDel1->execute();

            $stmtDel2 = $con->prepare("DELETE FROM beneficios WHERE id = ?");
            $stmtDel2->bind_param("i", $beneficio_id);
            $stmtDel2->execute();
        }
    }
}

    for ($i = 0; $i < count($pivot_ids); $i++) {
        $pivot_id     = $pivot_ids[$i];
        $beneficio_id = $beneficio_ids[$i];
        $texto        = $textos[$i];
        $incluido     = intval($incluidos[$i]);

        if ($pivot_id === 'nuevo') {
            
            $stmt1 = $con->prepare("INSERT INTO beneficios (texto) VALUES (?)");
            $stmt1->bind_param("s", $texto);
            $stmt1->execute();
            $nuevo_ben_id = $con->insert_id;

            $stmtOrden = $con->prepare("SELECT COALESCE(MAX(orden), 0) + 1 as siguiente FROM membresias_beneficios WHERE membresia_id = ?");
            $stmtOrden->bind_param("i", $membresia_id);
            $stmtOrden->execute();
            $resOrden = $stmtOrden->get_result();
            $rowOrden = $resOrden->fetch_assoc();
            $orden    = $rowOrden['siguiente'];

            $stmt2 = $con->prepare("INSERT INTO membresias_beneficios (membresia_id, beneficio_id, incluido, orden) VALUES (?,?,?,?)");
            $stmt2->bind_param("iiii", $membresia_id, $nuevo_ben_id, $incluido, $orden);
            $stmt2->execute();

        } else {

            $stmtTxt = $con->prepare("UPDATE beneficios SET texto = ? WHERE id = ?");
            $stmtTxt->bind_param("si", $texto, $beneficio_id);
            $stmtTxt->execute();

            $stmtInc = $con->prepare("UPDATE membresias_beneficios SET incluido = ? WHERE id = ?");
            $stmtInc->bind_param("ii", $incluido, $pivot_id);
            $stmtInc->execute();
        }
    }

    header("Location: ../adminMembresias.php?tipo=$slug&success=Cambios guardados");

} catch (Exception $e) {
    header("Location: ../adminMembresias.php?tipo=$slug&error=" . $e->getMessage());
    return;
}
?>