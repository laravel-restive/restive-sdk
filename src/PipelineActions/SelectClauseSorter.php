<?php

namespace RestiveSDk\PipelineActions;

use League\Pipeline\PipelineBuilder;
use League\Pipeline\StageInterface;

class SelectClauseSorter implements StageInterface
{
    public function __invoke($payload)
    {
        $fragments = collect($payload->getFragments());
        $selects = ($fragments->where('type', '=', 'columns'))->toArray();
        $payload->addOrderedFragments('columns', $selects);
        return $payload;
    }
}