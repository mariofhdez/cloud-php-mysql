<?php
require __DIR__ . '/../config.php';

$mensaje = '';

// CREATE - Crear mensaje
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_mensaje'])) {
    $usuario_id = $_POST['usuario_id'];
    $contenido = $_POST['contenido'];
    
    $query = "INSERT INTO mensajes (usuario_id, contenido, created_at) VALUES ($usuario_id, '$contenido', NOW())";
    
    if ($conn->query($query)) {
        $mensaje = '<span class="success">Mensaje creado exitosamente</span>';
    } else {
        $mensaje = '<span class="error">Error: ' . $conn->error . '</span>';
    }
}

// UPDATE - Actualizar mensaje
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar_mensaje'])) {
    $id = $_POST['id'];
    $contenido = $_POST['contenido'];
    
    $query = "UPDATE mensajes SET contenido='$contenido' WHERE id=$id";
    
    if ($conn->query($query)) {
        $mensaje = '<span class="success">Mensaje actualizado</span>';
    } else {
        $mensaje = '<span class="error">Error: ' . $conn->error . '</span>';
    }
}

// DELETE - Eliminar mensaje
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $conn->query("DELETE FROM mensajes WHERE id=$id");
    $mensaje = '<span class="success">Mensaje eliminado</span>';
}

$mensaje_edit = null;
if (isset($_GET['edit_id'])) {
    $id = $_GET['edit_id'];
    $result = $conn->query("SELECT * FROM mensajes WHERE id=$id");
    $mensaje_edit = $result->fetch_assoc();
}

// Obtener usuarios sin LIMIT
$usuarios_result = $conn->query("SELECT * FROM usuarios");
?>

<h2>Gestión de Mensajes</h2>

<?php if ($mensaje) echo $mensaje; ?>

<h3>Crear Nuevo Mensaje</h3>
<form method="POST">
    <select name="usuario_id" required>
        <option value="">Seleccionar usuario</option>
        <?php while ($user = $usuarios_result->fetch_assoc()): ?>
            <option value="<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['nombre']); ?></option>
        <?php endwhile; ?>
    </select>
    <textarea name="contenido" placeholder="Contenido del mensaje" required></textarea>
    <button type="submit" name="crear_mensaje">Crear Mensaje</button>
</form>

<?php if ($mensaje_edit): ?>
    <h3>Editar Mensaje</h3>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $mensaje_edit['id']; ?>">
        <textarea name="contenido" required><?php echo htmlspecialchars($mensaje_edit['contenido']); ?></textarea>
        <button type="submit" name="actualizar_mensaje">Actualizar Mensaje</button>
    </form>
<?php endif; ?>

<h3>Lista de Mensajes</h3>
<table>
    <tr>
        <th>ID</th>
        <th>Usuario</th>
        <th>Contenido</th>
        <th>Creado</th>
        <th>Acciones</th>
    </tr>
    <?php
    // Sin LIMIT - carga todos los registros
    $result = $conn->query("SELECT m.*, u.nombre FROM mensajes m JOIN usuarios u ON m.usuario_id = u.id");
    
    while ($msg = $result->fetch_assoc()):
    ?>
    <tr>
        <td><?php echo $msg['id']; ?></td>
        <td><?php echo htmlspecialchars($msg['nombre']); ?></td>
        <td><?php echo substr(htmlspecialchars($msg['contenido']), 0, 50); ?>...</td>
        <td><?php echo $msg['created_at']; ?></td>
        <td class="actions">
            <a href="?action=mensajes&edit_id=<?php echo $msg['id']; ?>">Editar</a>
            <a href="?action=mensajes&delete_id=<?php echo $msg['id']; ?>" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>