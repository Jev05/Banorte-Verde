<?php
header("Content-Type: application/json");
include("conexion.php"); // tu archivo con mysqli_connect()

$data = json_decode(file_get_contents("php://input"), true);

$correo = $data["correo"] ?? "";
$cantidad = intval($data["puntos"] ?? 0);

if (!$correo || $cantidad <= 0) {
    echo json_encode(["success" => false, "message" => "Datos inválidos."]);
    exit;
}

// Verificar si el usuario existe
$query = "SELECT * FROM usuarios WHERE correo = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Si existe, aumentar la cantidad de botellas
    $update = "UPDATE usuarios SET puntos = puntos + ? WHERE correo = ?";
    $stmt2 = $conn->prepare($update);
    $stmt2->bind_param("is", $cantidad, $correo);
    $stmt2->execute();
    echo json_encode(["success" => true, "message" => "Cantidad actualizada."]);
} else {
    // Si no existe, crear el registro
    $insert = "INSERT INTO usuarios (correo, puntos) VALUES (?, ?)";
    $stmt3 = $conn->prepare($insert);
    $stmt3->bind_param("si", $correo, $cantidad);
    $stmt3->execute();
    echo json_encode(["success" => true, "message" => "Usuario agregado con éxito."]);
}
?>
