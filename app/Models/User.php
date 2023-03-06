<?php

namespace Models;

use Libraries\Database;

class User {
    /**
     * Database ORM
     * @var Database
     */
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Find user by email
     * @param $email
     * @return bool
     */
    public function findUserByEmail($email)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        // Check if row exist
        $emailFound = $this->db->result();

        if ($emailFound) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Register user
     * @param $data
     * @return bool
     */
    public function register($data)
    {
        $this->db->query('INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':role', $data['role']);

        // Execute query
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Login user
     * @param $email
     * @param $password
     * @return false|mixed
     */
    public function login($email, $password)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $result = $this->db->result();
        $hashed_pw = $result->password;

        if (password_verify($password, $hashed_pw)) {
            return $result;
        } else {
            return false;
        }
    }


    /**
     * Get User by id
     * @param $id
     * @return mixed
     */
    public function getUserById($id)
    {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);

        // Get row data
        $result = $this->db->result();
        return $result;
    }
}