<?php

namespace ZfMetal\Security\Entity;

//use Zend\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Rbac\Role\HierarchicalRoleInterface;
use ZfcRbac\Permission\PermissionInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="roles")
 * @ORM\Entity(repositoryClass="ZfMetal\Security\Repository\RoleRepository")
 */
class Role implements HierarchicalRoleInterface {

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
     * @var HierarchicalRoleInterface[]|\Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Role")
     */
    protected $children = [];
    
    /**
     * @var PermissionInterface[]|\Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Permission", indexBy="name", fetch="EAGER")
     */
    protected $permissions;

    /**
     * @return \Doctrine\Common\Collections\Collection|PermissionInterface[]
     */
    public function getPermissions() {
        return $this->permissions;
    }
    function setPermissions($permissions = array()) {
        $this->permissions = $permissions;
    }

        /**
     * Init the Doctrine collection
     */
    public function __construct() {
        $this->children = new ArrayCollection();
        $this->permissions = new ArrayCollection();
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
    

    /**
     * {@inheritDoc}
     */
    public function getChildren() {
        return $this->children;
    }

    function setChildren($children = array()) {
        $this->children = $children;
    }

        /**
     * {@inheritDoc}
     */
    public function hasChildren() {
        return !$this->children->isEmpty();
    }

    public function addChildren(\Doctrine\Common\Collections\ArrayCollection $roles) {
        foreach ($roles as $role) {
            $this->addChild($role);
        }
    }

    public function removeChildren(\Doctrine\Common\Collections\ArrayCollection $roles) {
        foreach ($roles as $role) {
            $this->removeChild($role);
        }
    }

    public function addChild(\ZfMetal\Security\Entity\Role $role) {
        if ($this->children->contains($role)) {
            return;
        }
        $this->children[] = $role;
    }

    public function removeChild(\ZfMetal\Security\Entity\Role $role) {
        if (!$this->children->contains($role)) {
            return;
        }
        $this->children->removeElement($role);
    }

    public function addPermissions(\Doctrine\Common\Collections\ArrayCollection $permissions) {
        foreach ($permissions as $permission) {
            $this->addPermission($permission);
        }
    }

    public function removePermissions(\Doctrine\Common\Collections\ArrayCollection $permissions) {
        foreach ($permissions as $permission) {
            $this->removePermission($permission);
        }
    }

    public function addPermission(\ZfMetal\Security\Entity\Permission $permission) {
//        if (is_string($permission)) {
//            $permission = new Permission($permission);
//        }
        if ($this->permissions->contains($permission)) {
            return;
        }

        $this->permissions[(string) $permission] = $permission;
    }

    public function removePermission(\ZfMetal\Security\Entity\Permission $permission) {
        if (!$this->permissions->contains($permission)) {
            return;
        }
        $this->permissions->removeElement($permission);
    }
    
    /**
     * {@inheritDoc}
     */
    public function hasPermission($permission) {
        // This can be a performance problem if your role has a lot of permissions. Please refer
        // to the cookbook to an elegant way to solve this issue

        return isset($this->permissions[(string) $permission]);
    }

    public function __toString() {
    return $this->name;    
    }

    
}
