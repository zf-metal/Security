<?php

namespace ZfMetal\Security\Entity;

//use Zend\Form\Annotation;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use ZfcRbac\Identity\IdentityInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="ZfMetal\Security\Repository\UserRepository")
 */
class User implements IdentityInterface {

    /**
     * @var integer
     * @ORM\Column(type="integer") 
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var boolean
     * @ORM\Column(type="integer")
     */
    private $active;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, unique=false, nullable=false, name="name")
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=20, unique=true, nullable=false)
     */
    private $username;

    /**
     * @var string
     * @ORM\Column(type="string", length=128, unique=false, nullable=false)
     */
    private $password;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, unique=true, nullable=false)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="string", length=128, unique=false, nullable=true)
     */
    private $img;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", length=128, unique=false, nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", length=128, unique=false, nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\ManyToMany(targetEntity="ZfMetal\Security\Entity\Role")
     */
    private $roles;

    function setUpdatedAt(\DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    public function __construct() {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function addRoles(\Doctrine\Common\Collections\ArrayCollection $roles) {
        foreach ($roles as $role) {
            $this->addRole($role);
        }
    }

    public function removeRoles(\Doctrine\Common\Collections\ArrayCollection $roles) {
        foreach ($roles as $role) {
            $this->removeRole($role);
        }
    }

    public function addRole(\ZfMetal\Security\Entity\Role $role) {
        if ($this->roles->contains($role)) {
            return;
        }
        $this->roles[] = $role;
    }

    public function removeRole(\ZfMetal\Security\Entity\Role $role) {
        if (!$this->roles->contains($role)) {
            return;
        }
        $this->roles->removeElement($role);
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }

    function getEmail() {
        return $this->email;
    }

    function getImg() {
        return $this->img;
    }

    function getCreateAt() {
        return $this->createdAt;
    }

    function getRoles() {
        #var_dump($this->roles->toArray());die;
        return $this->roles;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setImg($img) {
        $this->img = $img;
    }

    function setCreatedAt(\DateTime $createAt) {
        $this->createdAt = $createAt;
    }

    function setRoles(\Doctrine\Common\Collections\ArrayCollection $roles) {
        $this->roles = $roles;
    }

    function getActive() {
        return $this->active;
    }

    /**
     * @return bool
     */
    public function isActive() {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive($active) {
        $this->active = $active;
    }

}
