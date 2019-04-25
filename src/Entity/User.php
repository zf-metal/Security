<?php

namespace ZfMetal\Security\Entity;

//use Zend\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use ZfcRbac\Identity\IdentityInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="ZfMetal\Security\Repository\UserRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="entity", type="string")
 * @ORM\DiscriminatorMap({
 *     "User" = "\ZfMetal\Security\Entity\User",
 *     "UsuarioCurso" = "\Application\Entity\Usuario",
 * })
 */
class User implements IdentityInterface
{

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
     * @ORM\Column(type="string", length=50, unique=false, nullable=true)
     */
    private $phone;

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
     * @var \ZfMetal\Security\Entity\Role
     * @ORM\ManyToOne(targetEntity="ZfMetal\Security\Entity\Role", fetch="EAGER")
     */
    private $rol;

    /**
     * Many Users have Many Groups.
     * @ORM\ManyToMany(targetEntity="Group", inversedBy="users")
     *
     */
    private $groups;

    /**
     * @return mixed
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param mixed $groups
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
    }

    function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function __construct()
    {
        //$this->roles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function addRoles(\Doctrine\Common\Collections\ArrayCollection $roles)
    {
        foreach ($roles as $role) {
            $this->setRol($role);
        }
    }

    public function removeRoles(\Doctrine\Common\Collections\ArrayCollection $roles)
    {
        foreach ($roles as $role) {
            $this->removeRole($role);
        }
    }

    public function addRole(\ZfMetal\Security\Entity\Role $role)
    {
        $this->setRol($role);
    }

    public function removeRole(\ZfMetal\Security\Entity\Role $role)
    {
        if (!$this->roles->contains($role)) {
            return;
        }
        $this->roles->removeElement($role);
    }

    public function addGroups(\Doctrine\Common\Collections\ArrayCollection $groups)
    {
        foreach ($groups as $group) {
            $this->addGroup($group);
        }
    }

    public function removeGroups(\Doctrine\Common\Collections\ArrayCollection $groups)
    {
        foreach ($groups as $group) {
            $this->removeGroup($group);
        }
    }

    public function addGroup(\ZfMetal\Security\Entity\Group $group)
    {
        if ($this->groups->contains($group)) {
            return;
        }
        $this->groups[] = $group;
        $group->addUser($this); //synchronously updating inverse side
    }

    public function removeGroup(\ZfMetal\Security\Entity\Group $group)
    {
        if (!$this->groups->contains($group)) {
            return;
        }

        $this->groups->removeElement($group);
        $group->removeUser($this); //synchronously updating inverse side
    }

    function getId()
    {
        return $this->id;
    }

    function getName()
    {
        return $this->name;
    }

    function getUsername()
    {
        return $this->username;
    }

    function getPassword()
    {
        return $this->password;
    }

    function getEmail()
    {
        return $this->email;
    }

    function getImg()
    {
        return $this->img;
    }

    function getCreateAt()
    {
        return $this->createdAt;
    }

    /**
     * @return Role
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * @param Role $rol
     */
    public function setRol($rol)
    {
        $this->rol = $rol;
    }

    
    function getRoles()
    {
        #var_dump($this->roles->toArray());die;
        $array = new ArrayCollection();
        $array->add($this->getRol());

        return $array;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setName($name)
    {
        $this->name = $name;
    }

    function setUsername($username)
    {
        $this->username = $username;
    }

    function setPassword($password)
    {
        $this->password = $password;
    }

    function setEmail($email)
    {
        $this->email = $email;
    }

    function setImg($img)
    {
        $this->img = $img;
    }

    function setCreatedAt(\DateTime $createAt)
    {
        $this->createdAt = $createAt;
    }

    function setRoles(\Doctrine\Common\Collections\ArrayCollection $roles)
    {
        $this->roles = $roles;
    }

    function getActive()
    {
        return $this->active;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    public function __toString()
    {
        return $this->getName();
    }

    function getCreatedAt()
    {
        return $this->createdAt;
    }

    function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }


    public function hasRole($name)
    {
        foreach ($this->roles as $role) {
            if ($role->getName() == $name) {
                return true;
            }
        }
        return false;
    }


}
