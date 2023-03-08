<?php

namespace App\Repository;
use PDO;

class DataUserRepository {

    private $bdd_host = 'localhost';
    private $bdd_ident = 'root';
    private $bdd_password = '';
    private $bdd_name = 'geopv';

    private function connBdd() {
        try {
            $pdo = new PDO("mysql:host=$this->bdd_host;dbname=$this->bdd_name", $this->bdd_ident, $this->bdd_password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (\PDOException $e) {
            die("Connexion à la BDD failed: " . $e->getMessage());
        }

    }

    public function getAllUsers() {
        $sql = 'SELECT * FROM `user`';
        $stm = $this->connBdd()->prepare($sql);
        $stm->execute();
        $users = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

    public function getOneUser(int $id) {
        $sql = 'SELECT * FROM `user` WHERE `id` = ?';
        $stm = $this->connBdd()->prepare($sql);
        $stm->execute([ $id ]);
        //$user = $stm->fetch(PDO::FETCH_ASSOC);
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function delOneUser($id) {
        $sql = 'DELETE FROM `user` WHERE `id` = ?';
        $stm = $this->connBdd()->prepare($sql);
        $stm->execute([ $id ]);
    }

    public function purgeUserTable() {
        $sql = 'DELETE FROM `user`';
        $stm = $this->connBdd()->prepare($sql);
        $stm->execute();
    }

    public function createOneUser($email, $roles, $pwd, $fname, $lname, $phone, $company, $zipcode, $city) {
        $sql = 'INSERT INTO `user` (`email`, `roles`, `password`, `firstname`, `lastname`, `phone`, `company`, `zipcode`, `city`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $stm = $this->connBdd()->prepare($sql);
        $stm->execute([ $email, $roles, $pwd, $fname, $lname, $phone, $company, $zipcode, $city ]);
    }
	
	public function editOneUser($email, $fname, $lname, $phone, $company, $zipcode, $city) {
        $sql = 'UPDATE `user` SET (`email`, `firstname`, `lastname`, `phone`, `company`, `zipcode`, `city`) VALUES (?, ?, ?, ?, ?, ?, ?)';
        $stm = $this->connBdd()->prepare($sql);
        $stm->execute([ $email, $fname, $lname, $phone, $company, $zipcode, $city ]);
    }
}