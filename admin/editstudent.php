<?php
$corepage = explode('/', $_SERVER['PHP_SELF']);
$corepage = end($corepage);
if ($corepage !== 'index.php') {
    if ($corepage == $corepage) {
        $corepage = explode('.', $corepage);
        header('Location: index.php?page=' . $corepage[0]);
        exit();
    }
}

$id = base64_decode($_GET['id']);
$oldPhoto = base64_decode($_GET['photo']);

if (isset($_POST['updatestudent'])) {
    $name = $_POST['name'];
    $roll = $_POST['roll'];
    $address = $_POST['address'];
    $pcontact = $_POST['pcontact'];
    $semestre = $_POST['semestre'];
    $carrera = $_POST['carrera'];

    if (!empty($_FILES['photo']['name'])) {
        $photo = $_FILES['photo']['name'];
        $photo = explode('.', $photo);
        $photo = end($photo);
        $photo = $roll . date('Y-m-d-m-s') . '.' . $photo;
    } else {
        $photo = $oldPhoto;
    }

    $query = "UPDATE `student_info` SET `name`='$name',`roll`='$roll',`carrera`='$carrera',`semestre`='$semestre',`city`='$address',`pcontact`='$pcontact',`photo`='$photo' WHERE `id`= $id";
    if (mysqli_query($db_con, $query)) {
        $datainsert['insertsucess'] = '<p style="color: green;">¡Estudiante actualizado!</p>';
        if (!empty($_FILES['photo']['name'])) {
            move_uploaded_file($_FILES['photo']['tmp_name'], 'images/' . $photo);
            unlink('images/' . $oldPhoto);
        }
        echo '<div class="alert alert-success" role="alert">Estudiante actualizado correctamente.</div>';
        header('Location: index.php?page=all-student&edit=success');
        exit();
    } else {
        header('Location: index.php?page=all-student&edit=error');
        exit();
    }
}
?>

<h1 class="text-primary"><i class="fas fa-user-plus"></i> Editar Información de Estudiante<small class="text-warning"> Editar</small></h1>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
     <li class="breadcrumb-item" aria-current="page"><a href="index.php">Panel de Control</a></li>
     <li class="breadcrumb-item" aria-current="page"><a href="index.php?page=all-student">Todos los Estudiantes</a></li>
     <li class="breadcrumb-item active" aria-current="page">Agregar Estudiante</li>
  </ol>
</nav>

<?php
if (isset($id)) {
    $query = "SELECT `id`, `name`, `roll`, `carrera`, `semestre`, `city`, `pcontact`, `photo`, `datetime` FROM `student_info` WHERE `id`=$id";
    $result = mysqli_query($db_con, $query);
    $row = mysqli_fetch_array($result);
}
?>

<div class="row">
<div class="col-sm-6">
    <form enctype="multipart/form-data" method="POST" action="">
        <div class="form-group">
            <label for="name">Nombre del Estudiante</label>
            <input name="name" type="text" class="form-control" id="name" value="<?php echo $row['name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="roll">ID Estudiante</label>
            <input name="roll" type="text" class="form-control" id="roll" value="<?php echo $row['roll']; ?>" required>
        </div>
        <div class="form-group">
            <label for="address">Dirección del Estudiante</label>
            <input name="address" type="text" class="form-control" id="address" value="<?php echo $row['city']; ?>" required>
        </div>
        <div class="form-group">
            <label for="pcontact">Celular</label>
            <input name="pcontact" type="text" class="form-control" id="pcontact" value="<?php echo $row['pcontact']; ?>" required>
        </div>
        <div class="form-group">
            <label for="carrera">Carrera</label>
            <input name="carrera" type="text" class="form-control" id="carrera" value="<?php echo $row['carrera']; ?>" required>
        </div>
        <div class="form-group">
            <label for="semestre">Semestre</label>
            <select name="semestre" class="form-control" id="semestre" required>
                <option>Seleccionar</option>
                <option value="Primero" <?php echo ($row['semestre'] == 'Primero') ? 'selected' : ''; ?>>Primero</option>
                <option value="Segundo" <?php echo ($row['semestre'] == 'Segundo') ? 'selected' : ''; ?>>Segundo</option>
                <option value="Tercero" <?php echo ($row['semestre'] == 'Tercero') ? 'selected' : ''; ?>>Tercero</option>
                <option value="Cuarto" <?php echo ($row['semestre'] == 'Cuarto') ? 'selected' : ''; ?>>Cuarto</option>
                <option value="Quinto" <?php echo ($row['semestre'] == 'Quinto') ? 'selected' : ''; ?>>Quinto</option>
                <option value="Sexto" <?php echo ($row['semestre'] == 'Sexto') ? 'selected' : ''; ?>>Sexto</option>
                <option value="Séptimo" <?php echo ($row['semestre'] == 'Séptimo') ? 'selected' : ''; ?>>Séptimo</option>
                <option value="Octavo" <?php echo ($row['semestre'] == 'Octavo') ? 'selected' : ''; ?>>Octavo</option>
            </select>
        </div>
        <div class="form-group">
            <label for="photo">Fotografía</label>
            <input name="photo" type="file" class="form-control" id="photo">
        </div>
        <div class="form-group text-center">
            <input name="updatestudent" value="Editar Estudiante" type="submit" class="btn btn-danger">
        </div>
     </form>
</div>
</div>
