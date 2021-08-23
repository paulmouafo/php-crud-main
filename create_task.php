<?php
    function chargerClasse($classe) {
        require './src/'.$classe.'.class.php';
    }
    spl_autoload_register('chargerClasse');
    
    $db = new PDO('mysql:host=localhost;dbname=my_db', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    
    $manager = new TaskManager($db);

    if (isset($_POST['submit_task'])) {
        if (strlen($_POST['titre']) <= 50 ) {
            if (!$manager->exists($_POST['titre'])) {
                $task = new Task(array(
                    'titre' => $_POST['titre'],
                    'etat' => 0,
                    't_date' => $_POST['t_date'],
                    'heure' => $_POST['time'] 
                ));
                $manager->addTask($task);
            }
            else 
                $error = 'this title already exist!';
        }
        else 
            $error = 'the title length has not to be greather than 50 characters';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="vendor/bootstrap-font/css/bootstrap.css" />
	<link rel="stylesheet" href="vendor/bootstrap-font/css/compiled_mdb.css" />
	<link rel="stylesheet" href="vendor/bootstrap-font/css/fontawesome.css" />
    <link rel="stylesheet" href="css/style.css">
    <title>MA TODO LIST</title>
</head>
<body>
    <h3 class="text-center mt-4">Create a task</h3><br>
    <div class="container">
        <form action="" method="post">
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <input type="text" name="titre" class="form-control" placeholder="Title" required />
                </div>
            </div><br>
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-4">
                    <input type="date" name="t_date" class="form-control" placeholder="date" required />
                </div>
                <div class="col-sm-4">
                    <input type="time" name="time" class="form-control" placeholder="hour" required />
                </div>
            </div><br>
            <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <button type="submit" class="btn btn-primary btn-block" name="submit_task">ADD TASK</button>
            </div>
            </div>
        </form>
        <?php
            if (isset($error)) {
        ?>
            <br><br>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $error ?>    
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php
            }
        ?>
    </div><br><br>

    <div class="text-center"><a href="index.php"> go home << </a></div>

    <script src="vendor/bootstrap-font/js/jquery.js"></script>
    <script src="vendor/bootstrap-font/js/bootstrap.js"></script>
    <script src="vendor/bootstrap-font/js/fontawesome.js"></script>
    <script src="vendor/bootstrap-font/js/all.js"></script>
    <script src="vendor/bootstrap-font/js/mdb.js"></script>
</body>
</html>