<?php

namespace RestiveSDk\PipelineActions;

use League\Pipeline\PipelineBuilder;
use League\Pipeline\StageInterface;

class JoinClauseSorter implements StageInterface
{
    protected $joinMap = ['join','rightJoin','leftJoin','crossJoin'];
    public function __invoke($payload)
    {
        $fragments = collect($payload->getFragments());
        $joins = ($fragments->whereIn('type', $this->joinMap))->toArray();
        $payload->addOrderedFragments('joins', $joins);
        return $payload;
    }
}