<?php

namespace RestiveSDk\PipelineActions;

use League\Pipeline\PipelineBuilder;
use League\Pipeline\StageInterface;

class WithClauseSorter implements StageInterface
{
    public function __invoke($payload)
    {
        $fragments = collect($payload->getFragments());
        $withs = ($fragments->where('type', '=', 'with'))->toArray();
        $payload->addOrderedFragments('withs', $withs);
        return $payload;
    }
}