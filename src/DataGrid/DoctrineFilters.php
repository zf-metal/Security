<?php

namespace ZfMetal\Security\DataGrid;

use Doctrine\ORM\Query\Expr;

class DoctrineFilter {

    /**
     * QueryBuilder
     * 
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $qb;

    /**
     * @param \Doctrine\ORM\QueryBuilder $qb
     */
    public function __construct(\Doctrine\ORM\QueryBuilder $qb) {
        $this->qb = $qb;
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilder() {
        return $this->qb;
    }

    public function applyFilter(\ZfMetal\Grid\Filter $filter) {
        $qb = $this->getQueryBuilder();
        $ra = $this->qb->getRootAliases()[0];
        $colname = $filter->getColumn();


        $colString = $ra . "." . $colname;

        //toreview for more filters in the same column
        $valueParameterName = ":" . $colname;

        $value = $filter->getValue();


        $expr = new Expr();

        switch ($filter->getOperator()) {
            case DatagridFilter::LIKE:
                $where = $expr->like($colString, $valueParameterName);
                $qb->setParameter($valueParameterName, '%' . $value . '%');
                break;
            case DatagridFilter::LIKE_LEFT:
                $where = $expr->like($colString, $valueParameterName);
                $qb->setParameter($valueParameterName, '%' . $value);
                break;
            case DatagridFilter::LIKE_RIGHT:
                $where = $expr->like($colString, $valueParameterName);
                $qb->setParameter($valueParameterName, $value . '%');
                break;
            case DatagridFilter::NOT_LIKE:
                $where = $expr->notLike($colString, $valueParameterName);
                $qb->setParameter($valueParameterName, '%' . $value . '%');
                break;
            case DatagridFilter::NOT_LIKE_LEFT:
                $where = $expr->notLike($colString, $valueParameterName);
                $qb->setParameter($valueParameterName, '%' . $value);
                break;
            case DatagridFilter::NOT_LIKE_RIGHT:
                $where = $expr->notLike($colString, $valueParameterName);
                $qb->setParameter($valueParameterName, $value . '%');
                break;
            case DatagridFilter::EQUAL:
                $where = $expr->eq($colString, $valueParameterName);
                $qb->setParameter($valueParameterName, $value);
                break;
            case DatagridFilter::NOT_EQUAL:
                $where = $expr->neq($colString, $valueParameterName);
                $qb->setParameter($valueParameterName, $value);
                break;
            case DatagridFilter::GREATER_EQUAL:
                $where = $expr->gte($colString, $valueParameterName);
                $qb->setParameter($valueParameterName, $value);
                break;
            case DatagridFilter::GREATER:
                $where = $expr->gt($colString, $valueParameterName);
                $qb->setParameter($valueParameterName, $value);
                break;
            case DatagridFilter::LESS_EQUAL:
                $where = $expr->lte($colString, $valueParameterName);
                $qb->setParameter($valueParameterName, $value);
                break;
            case DatagridFilter::LESS:
                $where = $expr->lt($colString, $valueParameterName);
                $qb->setParameter($valueParameterName, $value);
                break;
            case DatagridFilter::BETWEEN:
                $minParameterName = ':' . str_replace('.', '', $colString . '0');
                $maxParameterName = ':' . str_replace('.', '', $colString . '1');
                $where = $expr->between($colString, $minParameterName, $maxParameterName);
                $qb->setParameter($minParameterName, $value[0]);
                $qb->setParameter($maxParameterName, $value[1]);
                break;
            default:
                throw new Exception('This operator is currently not supported: ' . $filter->getOperator());
                break;
        }

        if (!empty($where)) {
            $qb->andWhere($where);
        }
    }

}
