<?php

namespace User\Model\Entity;
use Zend\Form\Annotation;

/**
 * @Annotation\Name("users")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 * 
 * @Entity @Table(name="users")
 */
class User {

    /**
     * @Annotation\Exclude()
     * 
     * @Id @GeneratedValue @Column(type="integer")
     */
    protected $id;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Email")
     * @Annotation\Options({"label":"Email:"})
     * @Annotation\Attributes(
     * {"type":"email","required":true,"placeholder":"Email Address..."})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"EmailAddress","options":{"messages":{"emailAddressInvalidFormat":"Email address format is invalid"}}})
     * @Annotation\Validator({"name":"NotEmpty","options":{"messages":{"isEmpty":"Email address is required"}}})
     * @Annotation\Flags({"priority":"500"})
     * @Column(type="string")
     */
    protected $email;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Password")
     * @Annotation\Options({"label":"Password:","priority":"400"})
     * @Annotation\Attributes({"placeholder":"Password Here...","required":"required"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"NotEmpty","options":{"messages":{"isEmpty":"Password is required"}}})
     * Annotation\Flags({"priority":"400"})
     * @Column(type="string")
     */
    protected $password;
    
    
    protected $role;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Name:"})
     * @Annotation\Attributes({"placeholder":"Type name...","required":"required"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator(
     * {"name":"NotEmpty","options":{"messages":{"isEmpty":"Name is required"}}})
     * @Column(type="string")
     */
    protected $name;
        
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Phone number:"})
     * @Annotation\Attributes(
     * {"type":"tel","required":true,"pattern":"^[\d-/]+$"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Filter({"name":"digits"})
     * @Annotation\Validator(
     * {"name":"RegEx","options":{"pattern":"/^[\d-\/]+$/"}})
     * @Column(type="string")
     */
    protected $phone;
    
    /**
     * @Annotation\Type("Zend\Form\Element\File")
     * @Annotation\Options({"label":"Your photo:"})
     * @Annotation\Attributes({"required":"required","id":"photo"})
     * @Annotation\Filter({"name":"filerenameupload","options":{"target":"data\/image\/photos\/","randomize":true}})
     * @Annotation\Validator({"name":"filesize","options":{"max":2097152}})
     * @Annotation\Validator({"name":"filemimetype","options":{"mimeType":"image\/png,image\/x-png,image\/jpg,image\/jpeg,image\/gif"}})
     * @Annotation\Validator({"name":"fileimagesize","options":{"maxWidth":200,"maxHeight":200}})
     * @Column(type="string")
     */
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
