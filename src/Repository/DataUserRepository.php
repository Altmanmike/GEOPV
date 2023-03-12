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

    public function getUsersInfos() {
        $sql = '
            SELECT
                u.id, u.email, u.firstname, u.lastname, u.phone, u.created_at, p.id as pid, p.total_price as ptp, 
                d.id as did, d.created_at as dc, d.completed_at as dca, i.id as iid, i.created_at as ic, i.completed_at as ica
            FROM `user` u 
                LEFT JOIN `payment` p ON u.id = p.user_id 
                LEFT JOIN `delivery` d ON u.id = d.user_id 
                LEFT JOIN `invoice` i ON u.id = i.user_id
            ';
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
	
	public function editOneUser($email, $roles, $fname, $lname, $phone, $company, $zipcode, $city) {
        $sql = 'UPDATE `user` SET (`email`, `roles`, `firstname`, `lastname`, `phone`, `company`, `zipcode`, `city`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $stm = $this->connBdd()->prepare($sql);
        $stm->execute([ $email, $fname, $lname, $phone, $company, $zipcode, $city ]);
    }
}