<?php

namespace ZfMetal\Security\Factory\DataGrid;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Authentication\Storage\Session;

class DataGridFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {

        //INSTANCE
        $dataGrid = new \ZfMetal\Security\DataGrid\DataGrid();

        //PARAMS
        $application = $container->get('application');
        $params = $application->getMvcevent()->getRequest()->getQuery();
        $dataGrid->setParams($params);

        //RETURN
        return $dataGrid;
    }

}
