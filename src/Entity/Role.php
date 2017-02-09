<?php

namespace ZfMetal\Security\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Rbac\Role\HierarchicalRoleInterface;
use ZfcRbac\Permission\PermissionInterface;
use Doctrine\Common\Collections\Criteria;
use Zend\Form\Annotation;

/**
 * @ORM\Entity
 * @ORM\Table(name="roles")
 */
class Role implements \Rbac\Role\HierarchicalRoleInterface {

    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Type("Zend\Form\Element\Hidden")
     */
    protected $id;

    /**
     * @var string|null
      * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Nombre:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":48}})
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
     * @ORM\ManyToMany(targetEntity="Permission", indexBy="name", fetch="LAZY")
     */
    protected $permissions;

    /**
     * Init the Doctrine collections
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
     * addChild
     * @param \Rbac\Role\HierarchicalRoleInterface $child
     */
    public function addChild(\Rbac\Role\HierarchicalRoleInterface $child) {
        $this->children[] = $child;
    }

    /**
     * addPermission
     */
    public function addPermission($permission) {
        if (is_string($permission)) {
            $permission = new Permission($permission);
        }

        $this->permissions[(string) $permission] = $permission;
    }

    /**
     * Check Permission
     */
    public function hasPermission($permission) {

        $criteria = Criteria::create()->where(Criteria::expr()->eq('name', (string) $permission));
        $result = $this->permissions->matching($criteria);

        return count($result) > 0;
    }

    /**
     * getChildren
     */
    public function getChildren() {
        return $this->children;
    }

    /**
     * hasChildren
     */
    public function hasChildren() {
        return !$this->children->isEmpty();
    }

    public function __toString() {
        return $this->name;
    }

}
