<?php

namespace RestiveSDk\PipelineActions;

use League\Pipeline\PipelineBuilder;
use League\Pipeline\StageInterface;

class OrderClauseSorter implements StageInterface
{
    public function __invoke($payload)
    {
        $fragments = collect($payload->getFragments());
        $orders = ($fragments->where('type', '=', 'orderBy'))->toArray();
        $payload->addOrderedFragments('orderBys', $orders);
        return $payload;
    }
}