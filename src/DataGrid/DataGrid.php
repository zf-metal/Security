<?php

namespace ZfMetal\Security\DataGrid;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Description of Grid
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class DataGrid {

    /**
     * Filters
     * 
     * @var Array
     */
    protected $filters;

    /**
     * Order
     * 
     * @var Array
     */
    protected $order;
    
    /**
     * recordPerPage
     * 
     * @var int
     */
    protected $recordPerPage = 10;

    /**
     * QueryBuilder
     * 
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $qb;

    /**
     * Paginator
     * 
     * @var \Zend\Paginator\Paginator
     */
    protected $paginator;

    /**
     * Params
     * 
     * @var array
     */
    protected $params = [];

    function getParams() {
        return $this->params;
    }

    function setParams($params) {
        $this->params = $params;
    }

    public function getParamsArray() {
        $return = [];
        foreach ($this->params as $key => $value) {
            $return[$key] = $value;
        }
        return $return;
    }

    function getPaginator() {
        return $this->paginator;
    }

    function getQb() {
        return $this->qb;
    }

    function setQb(\Doctrine\ORM\QueryBuilder $qb) {
        $this->qb = $qb;
    }
    
    function getRecordPerPage() {
        return $this->recordPerPage;
    }

    function setRecordPerPage($recordPerPage) {
        $this->recordPerPage = $recordPerPage;
    }

    
    protected function getCurrentPage() {
        return ($this->params["page"]) ? $this->params["page"] : 1;
    }

    public function prepare() {
        if (!$this->qb) {
            throw new Exception("QB MUST BE SET");
        }
        
        //Genero el adapter Paginator de Doctrine
        $doctrineAdapterPaginator = new DoctrinePaginator(new Paginator($this->qb));
        
        //Genero el Paginzador de Zend y le inyecto el adaptador de Doctrine
        $this->paginator = new \Zend\Paginator\Paginator($doctrineAdapterPaginator);
        
        //Indico la cantidad de registros por pagina
        $this->paginator->setDefaultItemCountPerPage($this->getRecordPerPage());
        
        //Indico la pagina actual
        $this->paginator->setCurrentPageNumber($this->getCurrentPage());
    }

    public function getCurrentItems() {
        if (!$this->paginator) {
            throw new \Exception("PAGINATOR NEED BE PREPARE");
        }
        return $this->paginator->getCurrentItems();
    }

}
