<?php

class TaskManager {
    
    private $_db;

    public function __construct($db) {
        $this->setDb($db);
    }

    public function addTask(Task $task) {
        $q = $this->_db->prepare("INSERT INTO tache (titre, etat, t_date, heure) 
            VALUES (:titre, :etat, :t_date, :heure)");
        $q->execute(array(
            'titre' => $task->getTitre(),
            'etat' => $task->getEtat(),
            't_date' => $task->getT_date(),
            'heure' => $task->getHeure()
        ));
    }

    public function countTasks() {
        $this->_db->query('SELECT COUNT(*) FROM tache')->fetchColumn();
    }

    public function exists($info) {
        if (is_int($info)) {
            return (bool) $this->_db->query("SELECT COUNT(*) FROM tache WHERE 
                id = ".$info)->fetchColumn();
        }
        $q = $this->_db->prepare('SELECT COUNT(*) FROM tache WHERE titre = :titre');
        $q->execute(array('titre' => $info));
        return (bool) $q->fetchColumn();
    }

    public function deleteTask(Task $task) {
        $this->_db->exec('DELETE FROM tache WHERE id = '.$task->getId());
    }

    public function getTask($info) {
        if (is_int($info)) {
            $q = $this->_db->query('SELECT * FROM tache WHERE id = '.$info);
            $data = $q->fetch(PDO::FETCH_ASSOC);
            return new Task($data);
        }
        $q = $this->_db->prepare('SELECT * FROM tache WHERE titre = :titre');
        $q->execute(array('titre' => $info));
        return new Task($q->fetch(PDO::FETCH_ASSOC));
    }

    public function getTasks($info) {
        $q = $this->_db->query('SELECT * FROM tache WHERE etat = '.$info.'
            ORDER BY t_date DESC');
        return $q;
    }

    public function updateTask(Task $task) {
        $q = $this->_db->prepare('UPDATE tache SET titre = :titre, etat = :etat,
            t_date = :t_date, heure = :heure WHERE id = :id');
        $q->execute(array(
            'titre' => $task->getTitre(),
            'etat' => $task->getEtat(),
            't_date' => $task->getT_date(),
            'heure' => $task->getHeure(),
            'id' => $task->getId()
        ));
    }

    public function setDb(PDO $db) {
        $this->_db = $db;
    }
}