<?php
include("db.php");

/**
 * Verifica si el tema está desbloqueado para el usuario.
 * Un tema está desbloqueado si:
 *  - Es el primero, o
 *  - El tema anterior fue completado (todas sus lecciones completadas).
 */
function temaDesbloqueado($id_usuario, $id_tema) {
    global $conn;

    if ($id_tema == 1) return true; // El primer tema siempre disponible

    $tema_anterior = $id_tema - 1;
    $progreso_anterior = progresoTema($id_usuario, $tema_anterior);

    return $progreso_anterior >= 100; // Solo se desbloquea si el anterior está completo
}

/**
 * Calcula el progreso total de un tema (porcentaje de lecciones completadas)
 */
function progresoTema($id_usuario, $id_tema) {
    global $conn;

    $sql_total = "SELECT COUNT(*) AS total FROM lecciones WHERE id_tema = ?";
    $stmt = $conn->prepare($sql_total);
    $stmt->bind_param("i", $id_tema);
    $stmt->execute();
    $total = $stmt->get_result()->fetch_assoc()['total'];

    if ($total == 0) return 0;

    $sql_completadas = "
        SELECT COUNT(*) AS completadas 
        FROM progreso_leccion pl
        INNER JOIN lecciones l ON pl.id_leccion = l.id
        WHERE pl.id_usuario = ? AND l.id_tema = ? AND pl.completado = 1
    ";
    $stmt = $conn->prepare($sql_completadas);
    $stmt->bind_param("ii", $id_usuario, $id_tema);
    $stmt->execute();
    $completadas = $stmt->get_result()->fetch_assoc()['completadas'];

    return round(($completadas / $total) * 100);
}

/**
 * Verifica si una lección está completada
 */
function leccionCompletada($id_usuario, $id_leccion)
{
    global $conn;

    $stmt = $conn->prepare("SELECT completado FROM progreso_leccion WHERE id_usuario=? AND id_leccion=?");
    $stmt->bind_param("ii", $id_usuario, $id_leccion);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        return $row['completado'] == 1;
    }
    return false;
}
?>