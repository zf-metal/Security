<?php

namespace ZfMetal\Security\Entity;

//use Zend\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="groups")
 * @ORM\Entity(repositoryClass="ZfMetal\Security\Repository\GroupRepository")
 */
class Group {

    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=48, unique=true)
     */
    protected $name;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="User")
     */
    protected $users = [];

    /**
     * Init the Doctrine collection
     */
    public function __construct() {
        $this->users = new ArrayCollection();
    }

    /**
     * Get the role identifier
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set the role name
     *
     * @param  string $name
     * @return void
     */
    public function setName($name) {
        $this->name = (string) $name;
    }

    /**
     * Get the role name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    public function hasUser() {
        if ($this->users->contains($user)) {
            return true;
        }
        return false;
    }

    public function addUsers(\Doctrine\Common\Collections\ArrayCollection $users) {
        foreach ($users as $user) {
            $this->addUser($user);
        }
    }

    public function removeUsers(\Doctrine\Common\Collections\ArrayCollection $users) {
        foreach ($users as $user) {
            $this->removeUser($user);
        }
    }

    public function addUser(\ZfMetal\Security\Entity\User $user) {
        if ($this->users->contains($user)) {
            return;
        }

        $this->users[] = $user;
       // $user->addGroup($this); //Pendiente: synchronously updating inverse side
    }

    public function removeUser(\ZfMetal\Security\Entity\User $user) {
        if (!$this->users->contains($user)) {
            return;
        }

     //   $user->removeGroup($this); //Pendiente: synchronously updating inverse side
        $this->users->removeElement($user);
    }

    function getUsers() {
        return $this->users;
    }

    function setUsers($users) {
        $this->users = $users;
    }

    public function __toString() {
        return $this->name;
    }

}
