<?php

namespace ZfMetal\Security\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AdminRoleController extends AbstractActionController {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \ZfMetal\Security\DataGrid\DataGrid
     */
    protected $dataGrid;

    /**
     *
     * @var \ZfMetal\Security\Options\ModuleOptions
     */
    protected $moduleOptions;

    /**
     *
     * @var \ZfMetal\Security\Repository\RoleRepository
     */
    protected $roleRepository;

    /**
     * AdminRoleController constructor.
     * @param \Doctrine\ORM\EntityManager $em
     * @param \ZfMetal\Security\DataGrid\DataGrid $dataGrid
     * @param \ZfMetal\Security\Options\ModuleOptions $moduleOptions
     * @param \ZfMetal\Security\Repository\RoleRepository $roleRepository
     */
    public function __construct(\Doctrine\ORM\EntityManager $em, \ZfMetal\Security\DataGrid\DataGrid $dataGrid, \ZfMetal\Security\Options\ModuleOptions $moduleOptions, \ZfMetal\Security\Repository\RoleRepository $roleRepository)
    {
        $this->em = $em;
        $this->dataGrid = $dataGrid;
        $this->moduleOptions = $moduleOptions;
        $this->roleRepository = $roleRepository;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function setEm($em)
    {
        $this->em = $em;
    }

    /**
     * @return \ZfMetal\Security\DataGrid\DataGrid
     */
    public function getDataGrid()
    {
        return $this->dataGrid;
    }

    /**
     * @param \ZfMetal\Security\DataGrid\DataGrid $dataGrid
     */
    public function setDataGrid($dataGrid)
    {
        $this->dataGrid = $dataGrid;
    }

    /**
     * @return \ZfMetal\Security\Options\ModuleOptions
     */
    public function getModuleOptions()
    {
        return $this->moduleOptions;
    }

    /**
     * @param \ZfMetal\Security\Options\ModuleOptions $moduleOptions
     */
    public function setModuleOptions($moduleOptions)
    {
        $this->moduleOptions = $moduleOptions;
    }

    /**
     * @return \ZfMetal\Security\Repository\RoleRepository
     */
    public function getRoleRepository()
    {
        return $this->roleRepository;
    }

    /**
     * @param \ZfMetal\Security\Repository\RoleRepository $roleRepository
     */
    public function setRoleRepository($roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function indexAction()
    {
        $params = $this->getRequest()->getQuery();
        $this->dataGrid->prepare();

        return ["dataGrid" => $this->dataGrid];
    }
}
