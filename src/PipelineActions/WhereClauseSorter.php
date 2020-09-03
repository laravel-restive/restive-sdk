<?php

namespace RestiveSDk\PipelineActions;

use League\Pipeline\PipelineBuilder;
use League\Pipeline\StageInterface;

class WhereClauseSorter implements StageInterface
{
    protected $whereMap = ['where', 'orWhere', 'whereIn', 'orWhereIn', 'whereNotIn', 'orWhereNotIn', 'whereBetween', 'whereNotBetween', 'orWhereBetween', 'orWhereNotBetween'];

    public function __invoke($payload)
    {
        $fragments = collect($payload->getFragments());
        $wheres = ($fragments->whereIn('type', $this->whereMap))->toArray();
        $payload->addOrderedFragments('wheres', $wheres);
        return $payload;
    }
}