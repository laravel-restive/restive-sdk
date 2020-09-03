<?php

namespace RestiveSDK;

use InvalidArgumentException;
use League\Pipeline\PipelineBuilder;

class ApiQueryBuilder
{

    protected $fragments = [];

    protected $orderedFragments = [];

    protected $url = '';

    protected $operatorMap = [
        '=' => 'eq',
        '<' => 'lt',
        '>' => 'gt',
        '<=' => 'lte',
        '>=' => 'gte',
        '<>' => 'neq',
        '!=' => 'neq',
        'like' => 'lk',
        'not like' => 'nlk'
    ];

    protected $pipelines = [
        'RestiveSDK\\PipelineActions\\ReorderFragments',
        'RestiveSDK\\PipelineActions\\BuildUrlFragments',
    ];

    public function __construct()
    {
        $this->fragments = [];
    }

    public function __call($name, $arguments)
    {
        $this->fragments[] = ['type' => 'scope', 'parameters' => [$name, $arguments]];
        return $this;
    }

    public function select($columns = ['*'])
    {
        $selects = is_array($columns) ? $columns : func_get_args();
        $selects = implode(',', $selects);
        $this->fragments[] = ['type' => 'columns', 'parameters' => $selects];
        return $this;
    }

    public function with($relations)
    {
        $relations = is_string($relations) ? func_get_args() : $relations;
        $withs = implode(',', $relations);
        $this->fragments[] = ['type' => 'with', 'parameters' => $withs];
        return $this;
    }

    public function where($column, $operator = null, $value = null, $boolean = '')
    {
        [$value, $operator] = $this->prepareValueAndOperator($value, $operator, func_num_args() === 2);
        if ($this->invalidOperator($operator)) {
            [$value, $operator] = [$value, '='];
        }
        $boolean = (in_array(strtolower($boolean), ['', 'and', 'or'])) ? $boolean : '';
        $type = ($boolean === 'or') ? 'orWhere' : 'where';
        $this->fragments[] = ['type' => $type, 'parameters' => [$column, $operator, $value]];
        return $this;
    }

    public function orWhere($column, $operator = null, $value = null)
    {
        [$value, $operator] = $this->prepareValueAndOperator(
            $value, $operator, func_num_args() === 2
        );

        return $this->where($column, $operator, $value, 'or');
    }

    public function whereIn($column, $values, $boolean = '', $not = false)
    {
        $not = $not ? 'NotIn' : 'In';
        $boolean = (in_array(strtolower($boolean), ['', 'and', 'or'])) ? $boolean : '';
        $type = ($boolean === 'or') ? 'orWhere' : 'where';
        $type .= $not;
        $values = implode(',', $values);
        $this->fragments[] = ['type' => $type, 'parameters' => [$column, $values]];
        return $this;
    }

    public function orWhereIn($column, $values)
    {
        return $this->whereIn($column, $values, 'or');
    }

    public function whereNotIn($column, $values)
    {
        return $this->whereIn($column, $values, '', true);
    }

    public function orWhereNotIn($column, $values)
    {
        return $this->whereIn($column, $values, 'or', true);
    }

    public function whereBetween($column, array $values, $boolean = 'and', $not = false)
    {
        $not = $not ? 'NotBetween' : 'Between';
        $boolean = (in_array(strtolower($boolean), ['', 'and', 'or'])) ? $boolean : '';
        $type = ($boolean === 'or') ? 'orWhere' : 'where';
        $type .= $not;
        $values = implode(',', $values);
        $this->fragments[] = ['type' => $type, 'parameters' => [$column, $values]];
        return $this;
    }

    public function whereNotBetween($column, $values)
    {
        return $this->whereBetween($column, $values, '', true);
    }

    public function orWhereBetween($column, $values)
    {
        return $this->whereBetween($column, $values, 'or', false);
    }

    public function orWhereNotBetween($column, $values)
    {
        return $this->whereBetween($column, $values, 'or', true);
    }

    public function join($table, $first, $operator = null, $second = null, $type = '')
    {
        $this->fragments[] = ['type' => 'join', 'parameters' => [$table, $type, $first, $second, $operator]];
        return $this;
    }

    public function leftJoin($table, $first, $operator = null, $second = null)
    {
        $operator = '=';
        return $this->join($table, $first, $operator, $second, 'left');
    }

    public function rightJoin($table, $first, $operator = null, $second = null)
    {
        $operator = '=';
        return $this->join($table, $first, $operator, $second, 'right');
    }

    public function crossJoin($table)
    {
        $operator = '=';
        return $this->join($table, null, null, null, 'cross');
    }

    public function withTrashed()
    {
        $this->fragments[] = ['type' => 'withTrashed', 'parameters' => []];
        return $this;
    }

    public function onlyTrashed()
    {
        $this->fragments[] = ['type' => 'onlyTrashed', 'parameters' => []];
        return $this;
    }

    public function orderBy($column, $direction = 'asc')
    {
        $this->fragments[] = ['type' => 'orderBy', 'parameters' => [$column, $direction]];
        return $this;
    }

    public function getOPeratorMap()
    {
        return $this->operatorMap;
    }
    public function get()
    {
        $url = $this->buildUrlFromFragments();
        return $url;
    }

    public function getFragments()
    {
        return $this->fragments;
    }

    public function getOrderedFragments()
    {
        return $this->orderedFragments;
    }

    public function addOrderedFragments($key, $list)
    {
        $this->orderedFragments[$key] = $list;
    }

    public function addToUrl($fragment)
    {
        $this->url .= $fragment;
    }
    protected function prepareValueAndOperator($value, $operator, $useDefault = false)
    {
        if ($useDefault) {
            return [$operator, '='];
        } elseif ($this->invalidOperatorAndValue($operator, $value)) {
            throw new InvalidArgumentException('Illegal operator and value combination.');
        }

        return [$value, $operator];
    }

    protected function invalidOperatorAndValue($operator, $value)
    {
        return is_null($value) && key_exists($operator, $this->operatorMap) &&
            ! in_array($operator, ['=', '<>', '!=']);
    }

    protected function invalidOperator($operator)
    {
        return ! key_exists(strtolower($operator), $this->operatorMap);
    }

    protected function buildUrlFromFragments()
    {
        $pipeline = $this->buildPipeline();
        $pipeline->process($this);
        return $this->url;
    }

    protected function buildPipeline()
    {
        $pipelineBuilder = new PipelineBuilder();
        foreach ($this->pipelines as $pipeline)
        {
            $pipelineBuilder->add(new $pipeline);
        }
        return $pipelineBuilder->build();
    }
}