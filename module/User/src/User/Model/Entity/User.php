<?php

namespace User\Model\Entity;

class User {

    protected $id;
    protected $role;
    protected $name;
    protected $email;
    protected $phone;
    protected $photo;

    /**
     * @return the $id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return the $role
     */
    public function getRole() {
        return $this->role;
    }

    /**
     * @return the $email
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @return the $phone
     */
    public function getPhone() {
        return $this->phone;
    }

    /**
     * @param filed_type $id
     */
    public function setId($id) {
        return $this->id = $id;
    }

    /**
     * @param fiel_type $role
     */
    public function setRole($role) {
        return $this->role = $role;
    }

    /**
     * @param fiel_type $email
     */
    public function setEmail($email) {
        return $this->email = $email;
    }

    /**
     * @param fiel_type $phone
     */
    public function setPhone($phone) {
        return $this->phone = $phone;
    }

    /**
     * @return the $name
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param fiel_type $name
     */
    public function setName($name) {
        return $this->name = $name;
    }

    public function getPhoto() {
        return $this->photo;
    }

    public function setPhoto($photo) {
        return $this->photo = $photo;
    }

    /**
     * Gets the current password hash
     * 
     * @return the $password
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Sets the password
     * 
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = $this->hashPassword($password);
    }

    /**
     * Verifies if the password match
     * 
     * @param string $password
     * @return boolean
     */
    public function verifyPassword($password) {
        return ($this->password == $this->hashPassword($password));
    }

    /**
     * Hashes a password
     * 
     * @param string $password
     * @return string
     */
    private function hashPassword($password) {
        return md5($password);
    }

}
