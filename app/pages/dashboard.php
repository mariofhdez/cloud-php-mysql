<?php
require __DIR__ . '/../config.php';

if (!isset($conn) || $conn->connect_error) {
    die("Error de conexión a la base de datos");
}

// Estadísticas sin optimización
$usuarios_count = $conn->query("SELECT COUNT(*) as total FROM usuarios")->fetch_assoc();
$mensajes_count = $conn->query("SELECT COUNT(*) as total FROM mensajes")->fetch_assoc();

// Simular procesamiento lento
sleep(1);

// Consultas múltiples sin índices
$ultimos_usuarios = $conn->query("SELECT * FROM usuarios ORDER BY created_at DESC");
$ultimos_mensajes = $conn->query("SELECT m.*, u.nombre FROM mensajes m JOIN usuarios u ON m.usuario_id = u.id ORDER BY m.created_at DESC");

?>

<h2>Dashboard</h2>

<div style="display: flex; gap: 20px; margin-bottom: 30px;">
    <div style="background: #e3f2fd; padding: 20px; border-radius: 5px; flex: 1;">
        <h3>Total de Usuarios</h3>
        <p style="font-size: 24px; font-weight: bold;"><?php echo $usuarios_count['total']; ?></p>
    </div>
    <div style="background: #f3e5f5; padding: 20px; border-radius: 5px; flex: 1;">
        <h3>Total de Mensajes</h3>
        <p style="font-size: 24px; font-weight: bold;"><?php echo $mensajes_count['total']; ?></p>
    </div>
</div>

<h3>Últimos Usuarios</h3>
<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Creado</th>
    </tr>
    <?php
    $count = 0;
    while (($usuario = $ultimos_usuarios->fetch_assoc()) && $count < 5):
        $count++;
    ?>
    <tr>
        <td><?php echo $usuario['id']; ?></td>
        <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
        <td><?php echo htmlspecialchars($usuario['email']); ?></td>
        <td><?php echo $usuario['created_at']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<h3>Últimos Mensajes</h3>
<table>
    <tr>
        <th>ID</th>
        <th>Usuario</th>
        <th>Contenido</th>
        <th>Creado</th>
    </tr>
    <?php
    $count = 0;
    while (($msg = $ultimos_mensajes->fetch_assoc()) && $count < 5):
        $count++;
    ?>
    <tr>
        <td><?php echo $msg['id']; ?></td>
        <td><?php echo htmlspecialchars($msg['nombre']); ?></td>
        <td><?php echo substr(htmlspecialchars($msg['contenido']), 0, 50); ?>...</td>
        <td><?php echo $msg['created_at']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>