<?php

namespace ZfMetal\Security\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AdminGroupController extends AbstractActionController {

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
     * @var \ZfMetal\Security\Repository\GroupRepository
     */
    protected $groupRepository;

    function __construct(\Doctrine\ORM\EntityManager $em, \ZfMetal\DataGrid\Grid $dataGrid, \ZfMetal\Security\Options\ModuleOptions $moduleOptions, \ZfMetal\Security\Repository\GroupRepository $groupRepository) {
        $this->em = $em;
        $this->dataGrid = $dataGrid;
        $this->moduleOptions = $moduleOptions;
        $this->groupRepository = $groupRepository;
    }

    function getDataGrid() {
        return $this->dataGrid;
    }

    function setDataGrid(\ZfMetal\Security\DataGrid\DataGrid $dataGrid) {
        $this->dataGrid = $dataGrid;
    }

    function getEm() {
        return $this->em;
    }

    function getModuleOptions() {
        return $this->moduleOptions;
    }

    function getGroupRepository() {
        return $this->groupRepository;
    }

    function setEm(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

    function setModuleOptions(\ZfMetal\Security\Options\ModuleOptions $moduleOptions) {
        $this->moduleOptions = $moduleOptions;
    }

    function setGroupRepository(\ZfMetal\Security\Repository\GroupRepository $groupRepository) {
        $this->groupRepository = $groupRepository;
    }

    public function abmAction() {
        $params = $this->getRequest()->getQuery();
        $this->dataGrid->prepare();
        return ["dataGrid" => $this->dataGrid];
    }

    public function createAction() {
        $group = new \ZfMetal\Security\Entity\Group();

        $form = new \ZfMetal\Security\Form\CreateGroup($this->getEm());
        $form->setHydrator(new \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity($this->getEm()));
        $form->bind($group);
         $form->getInputFilter()->get('users')->setRequired(false);
        $errors = '';

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                if ($this->getRequest()->getPost('users') === null) {
                    $group->setUsers(null);
                }
                $this->groupRepository->saveGroup($group);
                $this->redirect()->toRoute('zf-metal.admin/groups/view', array('id' => $group->getId()));
            } else {
                $errors = $form->getMessages();
            }
        }

        return ["form" => $form];
    }

    public function editAction() {

        $id = $this->params("id");

        $group = $this->getGroupRepository()->find($id);

        if (!$group) {
            throw new Exception("Group not found");
        }


        $form = new \ZfMetal\Security\Form\EditGroup($this->getEm());
        $form->setHydrator(new \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity($this->getEm()));
        $form->bind($group);
        $form->getInputFilter()->get('users')->setRequired(false);
        $errors = '';

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                if ($this->getRequest()->getPost('users') === null) {
                    $group->setUsers(null);
                }
                $this->groupRepository->saveGroup($group);
                $this->redirect()->toRoute('zf-metal.admin/groups/view', array('id' => $group->getId()));
            } else {
                $errors = $form->getMessages();
            }
        }

        return ["form" => $form];
    }

    public function delAction() {
        $id = $this->params("id");
        $group = $this->groupRepository->find($id);
        if (!$group) {
            throw new Exception("Group not Found");
        }
        $this->groupRepository->removeGroup($group);
        $this->redirect()->toRoute('zf-metal.admin/groups');
    }

    public function viewAction() {
        $id = $this->params("id");

        $group = $this->groupRepository->find($id);

        return ["group" => $group];
    }




}
