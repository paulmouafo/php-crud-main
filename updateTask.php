<?php
    function chargerClasse($classe) {
        require './src/'.$classe.'.class.php';
    }
    spl_autoload_register('chargerClasse');
    
    $db = new PDO('mysql:host=localhost;dbname=my_db', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    $id = $_POST['id'];
    $action = $_POST['action'];
    $manager = new TaskManager($db);
    $message = '';

    if ($manager->exists((int)$id)) {
        $task = $manager->getTask((int)$id);
        if ($action === "check") {
            $task->setEtat(1);
            $task->setT_date(date('Y/m/d'));
            $task->setHeure(date('H:i:s'));
            $manager->updateTask($task);
            $message = 'This task is now DONE !!';
        }
        else if ($action === "uncheck") {
            $task->setEtat(0);
            $task->setT_date(date('Y/m/d'));
            $task->setHeure(date('H:i:s'));
            $manager->updateTask($task);
            $message = 'This task has been unchecked !!';
        }
        else if ($action === "delete") {
            $manager->deleteTask($task);
            
            $message = 'This task has been deleted !!';
        }
        echo $message;
    }
    else {
        echo 'YOUR ID DOESN\'T EXIST !! ';
    }