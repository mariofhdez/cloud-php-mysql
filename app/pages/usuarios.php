<?php
require __DIR__ . '/../config.php';

$mensaje = '';

// CREATE - Crear usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_usuario'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    
    // Sin validación adecuada
    $query = "INSERT INTO usuarios (nombre, email, created_at) VALUES ('$nombre', '$email', NOW())";
    
    if ($conn->query($query)) {
        $mensaje = '<span class="success">Usuario creado exitosamente</span>';
    } else {
        $mensaje = '<span class="error">Error al crear usuario: ' . $conn->error . '</span>';
    }
}

// UPDATE - Actualizar usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar_usuario'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    
    $query = "UPDATE usuarios SET nombre='$nombre', email='$email' WHERE id=$id";
    
    if ($conn->query($query)) {
        $mensaje = '<span class="success">Usuario actualizado exitosamente</span>';
    } else {
        $mensaje = '<span class="error">Error al actualizar: ' . $conn->error . '</span>';
    }
}

// DELETE - Eliminar usuario
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $query = "DELETE FROM usuarios WHERE id=$id";
    
    if ($conn->query($query)) {
        $mensaje = '<span class="success">Usuario eliminado exitosamente</span>';
    }
}

$usuario_edit = null;
if (isset($_GET['edit_id'])) {
    $id = $_GET['edit_id'];
    $result = $conn->query("SELECT * FROM usuarios WHERE id=$id");
    $usuario_edit = $result->fetch_assoc();
}
?>

<h2>Gestión de Usuarios</h2>

<?php if ($mensaje) echo $mensaje; ?>

<h3>Crear Nuevo Usuario</h3>
<form method="POST">
    <input type="text" name="nombre" placeholder="Nombre" required>
    <input type="email" name="email" placeholder="Email" required>
    <button type="submit" name="crear_usuario">Crear Usuario</button>
</form>

<?php if ($usuario_edit): ?>
    <h3>Editar Usuario</h3>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $usuario_edit['id']; ?>">
        <input type="text" name="nombre" value="<?php echo $usuario_edit['nombre']; ?>" required>
        <input type="email" name="email" value="<?php echo $usuario_edit['email']; ?>" required>
        <button type="submit" name="actualizar_usuario">Actualizar Usuario</button>
    </form>
<?php endif; ?>

<h3>Lista de Usuarios</h3>
<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Creado</th>
        <th>Acciones</th>
    </tr>
    <?php
    // SELECT - Listar todos los usuarios sin paginación
    $result = $conn->query("SELECT * FROM usuarios");
    
    while ($usuario = $result->fetch_assoc()):
    ?>
    <tr>
        <td><?php echo $usuario['id']; ?></td>
        <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
        <td><?php echo htmlspecialchars($usuario['email']); ?></td>
        <td><?php echo $usuario['created_at']; ?></td>
        <td class="actions">
            <a href="?action=usuarios&edit_id=<?php echo $usuario['id']; ?>">Editar</a>
            <a href="?action=usuarios&delete_id=<?php echo $usuario['id']; ?>" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>