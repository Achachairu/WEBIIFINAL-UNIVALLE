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

if (isset($datainsert) && isset($datainsert['insertsucess'])) {
    echo '
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      Estudiante registrado exitosamente.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
}
?>

<h1 class="text-primary"><i class="fas fa-users"></i> Lista<small class="text-warning"> de Estudiantes</small></h1>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item" aria-current="page"><a href="index.php">Panel de Control </a></li>
    <li class="breadcrumb-item active" aria-current="page">Listado Estudiantes</li>
  </ol>
</nav>

<!-- Resto del código -->


<?php if (isset($_GET['delete']) || isset($_GET['edit'])): ?>
  <div role="alert" aria-live="assertive" aria-atomic="true" class="toast fade show" data-autohide="true" data-animation="true" data-delay="2000">
    <div class="toast-header">
      <strong class="mr-auto">Insertar Estudiantes</strong>
      <small><?php echo date('d-M-Y'); ?></small>
      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="toast-body">
      <?php if (isset($_GET['delete']) && $_GET['delete'] == 'success'): ?>
        <p style="color: green; font-weight: bold;">Estudiante eliminado exitosamente</p>
      <?php elseif (isset($_GET['delete']) && $_GET['delete'] == 'error'): ?>
        <p style="color: red; font-weight: bold;">Estudiante no eliminado</p>
      <?php elseif (isset($_GET['edit']) && $_GET['edit'] == 'success'): ?>
        <p style="color: green; font-weight: bold;">Estudiante actualizado exitosamente</p>
      <?php elseif (isset($_GET['edit']) && $_GET['edit'] == 'error'): ?>
        <p style="color: red; font-weight: bold;">No se pudo editar la información del estudiante</p>
      <?php endif; ?>
    </div>
  </div>
<?php endif; ?>

<?php if (isset($datainsert) && isset($datainsert['insertsucess'])): ?>
  <div role="alert" aria-live="assertive" aria-atomic="true" class="toast fade show" data-autohide="true" data-animation="true" data-delay="3000">
    <div class="toast-header">
      <strong class="mr-auto">Registro Exitoso</strong>
      <small><?php echo date('d-M-Y'); ?></small>
      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="toast-body">
      <p style="color: green; font-weight: bold;">Estudiante registrado exitosamente</p>
    </div>
  </div>
<?php endif; ?>

<table class="table table-striped table-hover table-bordered" id="data">
  <thead class="thead-dark">
    <tr>
      <th scope="col">SL</th>
      <th scope="col">Nombre</th>
      <th scope="col">ID Estudiante</th>
      <th scope="col">Carrera</th>
      <th scope="col">Semestre</th>
      <th scope="col">Celular</th>
      <th scope="col">Fotografía</th>
      <th scope="col">Acción</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $query = mysqli_query($db_con, 'SELECT * FROM `student_info` ORDER BY `student_info`.`datetime` DESC;');
    $i = 1;
    while ($result = mysqli_fetch_array($query)):
    ?>
    <tr>
      <td><?php echo $i; ?></td>
      <td><?php echo ucwords($result['name']); ?></td>
      <td><?php echo $result['roll']; ?></td>
      <td><?php echo $result['carrera']; ?></td>
      <td><?php echo ucwords($result['semestre']); ?></td>
      <td><?php echo $result['pcontact']; ?></td>
      <td><img src="images/<?php echo $result['photo']; ?>" height="50px"></td>
      <td>
        <a class="btn btn-xs btn-warning" href="index.php?page=editstudent&id=<?php echo base64_encode($result['id']); ?>&photo=<?php echo base64_encode($result['photo']); ?>">
          Editar <i class="fa fa-edit"></i>
        </a>
        &nbsp;
        <a class="btn btn-xs btn-danger" onclick="javascript:confirmationDelete($(this));return false;" href="index.php?page=delete&id=<?php echo base64_encode($result['id']); ?>&photo=<?php echo base64_encode($result['photo']); ?>">
          Eliminar <i class="fas fa-trash-alt"></i>
        </a>
      </td>
    </tr>
    <?php
    $i++;
    endwhile;
    ?>
  </tbody>
</table>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
<script>
  function confirmationDelete(anchor) {
    var conf = confirm('Estás seguro que deseas eliminar este registro, esta opción es irreversible');
    if (conf) {
      window.location = anchor.attr("href");
    }
  }

  $(document).ready(function() {
    $('.toast').toast('show');
  });
</script>
