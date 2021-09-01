<?php
    class Fpfti {
        //DB stuff
        private $conn;
        private $table = 'fpfti';

        //Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        public function read_waiting($number) {
            $first = ($number - 1)*5;
            $query = 'SELECT * FROM ' . $this->table . ' f WHERE accepted = 0 ORDER BY f.created DESC LIMIT ' . $first . ', 5';
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        public function read_main($page) {
            $first = ($page - 1)*5;
            $query = 'SELECT * FROM ' . $this->table . ' f WHERE accepted = 1 ORDER BY f.created DESC LIMIT ' . $first . ', 5';
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        public function read_top10() {
            $query = 'SELECT * FROM ' . $this->table . ' f ORDER BY f.likes DESC LIMIT 10';
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        public function read_admin($page) {
            $first = ($page - 1)*5;
            $query = 'SELECT * FROM ' . $this->table . ' f WHERE accepted = 0 ORDER BY f.created DESC LIMIT ' . $first . ', 5';
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        public function read_fpfti($fpfti_id) {
            $query = 'SELECT * FROM ' . $this->table . ' f WHERE id = ' . $fpfti_id . '';
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        public function read_fpfti_tags($fpfti_id) { 
            $query = 'SELECT tag FROM tags WHERE fpfti_id = ' . $fpfti_id . '';
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        public function read_profile($user_id) {
            $query = 'SELECT * FROM users u WHERE id = ' . $user_id . '';
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        public function read_user_fpfti($user_id) {
            $query = 'SELECT * FROM ' . $this->table . ' f WHERE user_id = ' . $user_id . '';
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        public function read_user_likes($user_id) {
            $query = 'SELECT f.id, f.title, f.user_id, f.link, f.accepted, f.likes, f.created
                FROM fpfti as f
                JOIN likes as l
                ON f.id = l.fpfti_id
                WHERE l.user_id = :user_id';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        }

        public function read_fpfti_comments($fpfti_id) {
            $query = 'SELECT c.*, u.login FROM comments c JOIN users u ON c.user_id = u.id WHERE fpfti_id = ' . $fpfti_id . ' ORDER BY c.created DESC';
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        public function read_search_by_tag($page, $tag) {
            $first = ($page - 1)*5;
            $query = 'SELECT * FROM fpfti f JOIN tags t ON f.id = t.fpfti_id WHERE t.tag = \'' . $tag . '\' ORDER BY f.created DESC LIMIT ' . $first . ', 5';
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        public function read_search_by_login($page, $login) {
            $first = ($page - 1)*5;
            $query = 'SELECT f.* FROM fpfti f JOIN users u ON f.user_id = u.id WHERE u.login = \'' . $login . '\' ORDER BY f.created DESC LIMIT ' . $first . ', 5';
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        public function read_search_by_user_id($page, $user_id) {
            $first = ($page - 1)*5;
            $query = 'SELECT f.* FROM fpfti f JOIN users u ON f.user_id = u.id WHERE u.id = '. $user_id .' ORDER BY f.created DESC LIMIT ' . $first . ', 5';
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }
    }