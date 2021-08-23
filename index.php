<?php
    function chargerClasse($classe) {
        require './src/'.$classe.'.class.php';
    }
    spl_autoload_register('chargerClasse');
    
    $db = new PDO('mysql:host=localhost;dbname=my_db', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $i = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="vendor/bootstrap-font/css/bootstrap.css" />
	<link rel="stylesheet" href="vendor/bootstrap-font/css/compiled_mdb.css" />
	<link rel="stylesheet" href="vendor/bootstrap-font/css/fontawesome.css" />
    <title>MA TODO LIST</title>
</head>
<body>
    <h3 class="text-center mt-4">TO-DO tasks</h3><br>
    <div class="container">
        <div class="row">
            <?php
                $manager = new TaskManager($db);
                $q = $manager->getTasks(0);
                while ($data = $q->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <div class="col-sm-6 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <span class="text-primary">TASK <?= $i ?> </span>
                            <span class="float-right">
                            <i>le <strong><?= $data['t_date'] ?></strong> à <strong><?= $data['heure'] ?></strong> </i>
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="text-center"> <?= $data['titre'] ?> </div>
                        </div>
                        <div class="card-footer text-center">
                            <button type="button" class="btn btn-outline-success btn-floating btn-sm mr-4" 
                                data-mdb-ripple-color="dark" onClick="updateTask('<?= $data['id'] ?>', 'check')">
                                <i class="fas fa-check-double"></i>
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-floating btn-sm" 
                                data-mdb-ripple-color="dark" onClick="updateTask('<?= $data['id'] ?>', 'delete')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php
                $i++;
                }
                $q->closeCursor();
            ?>
        </div>
        <br><br>
        <h3 class="text-center mt-4">DONE</h3><br>
        <div class="row">
            <?php
                $i = 1;
                $q = $manager->getTasks(1);
                while ($data = $q->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <div class="col-sm-6 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <span class="text-primary">TASK <?= $i ?> </span>
                            <span class="float-right">
                                <i>le <strong><?= $data['t_date'] ?></strong> à <strong><?= $data['heure'] ?></strong> </i>
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="text-center"> <?= $data['titre'] ?> </div>
                        </div>
                        <div class="card-footer text-center">
                            <button type="button" class="btn btn-outline-info btn-floating btn-sm" 
                                data-mdb-ripple-color="dark" onClick="updateTask('<?= $data['id'] ?>', 'uncheck')">
                                <i class="fas fa-undo"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php
                $i++;
                }
                $q->closeCursor();
            ?>
        </div>
    </div> <br>
    
    <p class="text-center">
        <a href="create_task.php"><i class="fas fa-plus-circle fa-3x"></i> </a>
    </p>

    <script src="vendor/bootstrap-font/js/jquery.js"></script>
    <script src="vendor/bootstrap-font/js/bootstrap.js"></script>
    <script src="vendor/bootstrap-font/js/fontawesome.js"></script>
    <script src="vendor/bootstrap-font/js/all.js"></script>
    <script src="vendor/bootstrap-font/js/mdb.js"></script>
    <script>
        function updateTask($id, $action) {
            $.ajax({
                type: 'POST',
                url: 'updateTask.php',
                data: {id: $id, action: $action},
                success: function(response) {
                    alert(response);
                    // reload the page
                    location.reload(true);
                }
            });
        }
    </script>
</body>
</html>