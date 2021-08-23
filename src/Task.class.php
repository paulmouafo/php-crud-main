<?php
    class Task {
        
        protected $id, $titre, $etat, $t_date, $heure;

        public function __construct(array $data) {
            $this->hydrate($data);
        }

        private function hydrate(array $data) {
            foreach ($data as $key => $value) {
                $method = 'set'.ucfirst($key);
                if (method_exists($this, $method)) {
                    $this->$method($value);
                }
            }
        }

        public function getId() {
            return $this->id;
        }

        public function getTitre() {
            return $this->titre;
        }

        public function getEtat() {
            return $this->etat;
        }

        public function getT_date() {
            return $this->t_date;
        }

        public function getHeure() {
            return $this->heure;
        }

        public function setId($id) {
            $id = (int) $id;
            if ($id >= 0) 
                $this->id = $id;
        }

        public function setTitre($titre) {
            if (is_string($titre)) {
                $this->titre = $titre;
            }
        }

        public function setEtat($etat) {
            if (is_int($etat)) {
                $this->etat = $etat;
            }   
        }

        public function setT_date($t_date) {
            if (strtotime($t_date)) {
                $this->t_date = $t_date;
            }
        }

        public function setHeure($heure) {
            if (strtotime($heure)) {
                $this->heure = $heure;
            }
        }
    }