<?php

namespace RestiveSDk\PipelineActions;

use League\Pipeline\PipelineBuilder;
use League\Pipeline\StageInterface;

class WhereClauseBuilder implements StageInterface
{

    public function __invoke($payload)
    {
        $orderFragments = $payload->getOrderedFragments();
        if (!isset($orderFragments['wheres'])) {
            return $payload;
        }
        $url = '';
        foreach ($orderFragments['wheres'] as $where) {
            $url .= $this->processUrlForWhereType($where, $payload) . '&';
        }
        $payload->addToUrl($url);
        return $payload;
    }

    protected function processUrlForWhereType($where, $payload)
    {
        switch ($where['type'])
        {
            case 'where':
            case 'orWhere':
                $fragment = $where['type'] . '[]=' . $where['parameters'][0] . ':' . $this->mapOperator($where['parameters'][1], $payload) . ':' . $where['parameters'][2];
            break;
            case'whereBetween':
            case'orWhereBetween':
            case'whereNotBetween':
            case'orWhereNotBetween':
                $values = explode(',', $where['parameters'][1]);
                $fragment = $where['type'] . '[]=' . $where['parameters'][0] . ':' . $values[0] . ':' . $values[1];
                break;
            case 'whereIn':
            case 'orWhereIn':
            case 'whereNotIn':
            case 'orWhereNotIn':
                $fragment = $where['type'] . '[]=' . $where['parameters'][0] . ':(' . $where['parameters'][1] . ')';
                break;
            default:
                $fragment = '';
        }
        return $fragment;
    }

    protected function mapOperator($operator, $payload)
    {
        $operatorMap = $payload->getOperatorMap();
        $operator = $operatorMap[$operator];
        return $operator;
    }
}