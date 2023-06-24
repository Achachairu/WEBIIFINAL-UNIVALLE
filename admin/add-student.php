<?php 
  $corepage = explode('/', $_SERVER['PHP_SELF']);
  $corepage = end($corepage);
  if ($corepage !== 'index.php') {
    if ($corepage == $corepage) {
      $corepage = explode('.', $corepage);
      header('Location: index.php?page=' . $corepage[0]);
    }
  }

  if (isset($_POST['addstudent'])) {
    $name = $_POST['name'];
    $roll = $_POST['roll'];
    $address = $_POST['address'];
    $pcontact = $_POST['pcontact'];
    $carrera = $_POST['carrera'];
    $semestre = $_POST['semestre'];
    
    $photo = explode('.', $_FILES['photo']['name']);
    $photo = end($photo); 
    $photo = $roll . date('Y-m-d-m-s') . '.' . $photo;

    $query = "INSERT INTO `student_info`(`name`, `roll`, `carrera`, `city`, `pcontact`, `semestre`, `photo`) VALUES ('$name', '$roll', '$carrera', '$address', '$pcontact', '$semestre', '$photo');";
    if (mysqli_query($db_con, $query)) {
      move_uploaded_file($_FILES['photo']['tmp_name'], 'images/' . $photo);
      header('Location: all-student.php?message=success');
      exit;
    } else {
      $datainsert['inserterror'] = '<p style="color: red;">No se pudo registrar al estudiante, revise la información.</p>';
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Registrar Nuevo Estudiante</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
  <style>
    .success-animation {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 9999;
      background-color: #ffffff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }

    .success-animation p {
      font-size: 18px;
      color: green;
      margin-bottom: 0;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1 class="text-primary"><i class="fas fa-user-plus"></i>  Registrar<small class="text-warning"> Nuevo Estudiante</small></h1>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Panel de Control </a></li>
        <li class="breadcrumb-item active" aria-current="page">Registrar Estudiante</li>
      </ol>
    </nav>

    <div class="row">
      <div class="col-sm-6">
        <?php if (isset($_GET['message']) && $_GET['message'] === 'success') { ?>
        <div class="success-animation">
          <p>Estudiante registrado exitósamente</p>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
          $(document).ready(function() {
            $('.success-animation').fadeIn('slow');
            setTimeout(function() {
              $('.success-animation').fadeOut('slow');
            }, 3000);
          });
        </script>
        <?php } ?>
        <?php if (isset($datainsert)) { ?>
        <div role="alert" aria-live="assertive" aria-atomic="true" class="toast fade" data-autohide="true" data-animation="true" data-delay="2000">
          <div class="toast-header">
            <strong class="mr-auto">Student Insert Alert</strong>
            <small><?php echo date('d-M-Y'); ?></small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="toast-body">
            <?php 
              if (isset($datainsert['insertsucess'])) {
                echo $datainsert['insertsucess'];
              }
              if (isset($datainsert['inserterror'])) {
                echo $datainsert['inserterror'];
              }
            ?>
          </div>
        </div>
        <?php } ?>
        <form enctype="multipart/form-data" method="POST" action="">
          <div class="form-group">
            <label for="name">Nombre del Estudiante</label>
            <input name="name" type="text" class="form-control" id="name" value="<?= isset($name) ? $name : ''; ?>" required="">
          </div>
          <div class="form-group">
            <label for="roll">ID Estudiante</label>
            <input name="roll" type="text" value="<?= isset($roll) ? $roll : ''; ?>" class="form-control" id="roll" required="">
          </div>
          <div class="form-group">
            <label for="address">Dirección del Estudiante</label>
            <input name="address" type="text" value="<?= isset($address) ? $address : ''; ?>" class="form-control" id="address" required="">
          </div>
          <div class="form-group">
            <label for="pcontact">Celular</label>
            <input name="pcontact" type="text" class="form-control" id="pcontact" value="<?= isset($pcontact) ? $pcontact : ''; ?>" placeholder="591 . . ." required="">
          </div>
          <div class="form-group">
            <label for="carrera">Carrera</label>
            <input name="carrera" type="text" class="form-control" id="carrera" value="<?= isset($carrera) ? $carrera : ''; ?>" required="">
          </div>
          <div class="form-group">
            <label for="semestre">Semestre</label>
            <select name="semestre" class="form-control" id="semestre" required="">
              <option>Selecciona</option>
              <option value="Primero">Primero</option>
              <option value="Segundo">Segundo</option>
              <option value="Tercero">Tercero</option>
              <option value="Cuarto">Cuarto</option>
              <option value="Quinto">Quinto</option>
              <option value="Sexto">Sexto</option>
              <option value="Septimo">Septimo</option>
              <option value="Octavo">Octavo</option>
            </select>
          </div>
          <div class="form-group">
            <label for="photo">Fotografía del Estudiante</label>
            <input name="photo" type="file" class="form-control" id="photo" required="">
          </div>
          <div class="form-group text-center">
            <input name="addstudent" value="Registrar Estudiante" type="submit" class="btn btn-danger">
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
