<?php

namespace User\Model\Entity;

use User\Model\PasswordAwareInterface;
use Zend\Crypt\Password\PasswordInterface;
use Zend\Form\Annotation;
use Zend\Crypt\Password\Bcrypt;

/**
 * @Annotation\Name("users")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 * 
 * @Entity @Table(name="users")
 */
class User implements PasswordAwareInterface {

    /**
     * @Annotation\Exclude()
     * @var PasswordInterface
     */
    protected $adapter;

    /**
     * @Annotation\Exclude()
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
     * @Annotation\Flags({"priority":"1000"})
     * @Column(type="string")
     */
    protected $email;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Password")
     * @Annotation\Options({"label":"Password:","priority":"900"})
     * @Annotation\Attributes({"placeholder":"Password Here...","required":"required"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"NotEmpty","options":{"messages":{"isEmpty":"Password is required"}}})
     * @Annotation\Flags({"priority":"900"})
     * @Column(type="string")
     */
    protected $password;
    // When form is generating then password_verify gets priority 800 (password priority - 100)

    /**
     * @Annotation\Exclude()
     * @Column(type="string")
     */
    protected $role;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Name:"})
     * @Annotation\Attributes({"placeholder":"Type name...","required":"required"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator(
     * {"name":"NotEmpty","options":{"messages":{"isEmpty":"Name is required"}}})
     * @Annotation\Flags({"priority":"700"})
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
     * @Annotation\Flags({"priority":"600"})
     * @Column(type="string")
     */
    protected $phone;
    
    /**
     * @Annotation\Type("Zend\Form\Element\File")
     * @Annotation\Options({"label":"Your photo:"})
     * @Annotation\Attributes({"required":"required","id":"photo"})
     * @Annotation\Filter({"name":"filerenameupload","options":{"target":"data/image/photos/","randomize":true}})
     * @Annotation\Validator({"name":"filesize","options":{"max":2097152}})
     * @Annotation\Validator({"name":"filemimetype","options":{"mimeType":"image/png,image/x-png,image/jpg,image/jpeg,image/gif"}})
     * @Annotation\Validator({"name":"fileimagesize","options":{"maxWidth":200,"maxHeight":200}})
     * @Annotation\Flags({"priority":"500"})
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
     * @param field_type $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @param field_type $role
     */
    public function setRole($role) {
        $this->role = $role;
    }

    /**
     * @param field_type $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @param field_type $phone
     */
    public function setPhone($phone) {
        $this->phone = $phone;
    }

    /**
     * @return the $name
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param field_type $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    public function getPhoto() {
        return $this->photo;
    }

    public function setPhoto($photo) {
        if(isset($photo['tmp_name'])) {
            $this->photo = $photo['tmp_name'];
        }
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
     * Verifies if the provided password matches the stored one.
     * 
     * @param string $password clear text password
     * @return boolean
     */
    public function verifyPassword($password) {

        return $this->adapter->verify($password, $this->password);

    }

    /**
     * Hashes a password
     * 
     * @param string $password
     * @return string
     */
    private function hashPassword($password) {

        return $this->adapter->create($password);

    }

    /**
     * Sets the password adapter.
     * @param PasswordInterface $adapter
     */
    public function setPasswordAdapter(PasswordInterface $adapter) {
        $this->adapter = $adapter;
    }

    /**
     * Gets the password adapter.
     * @return PasswordInterface
     */
    public function getPasswordAdapter() {
        return $this->adapter;
    }

}
