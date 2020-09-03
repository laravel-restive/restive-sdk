<?php

namespace RestiveSDk\PipelineActions;

use League\Pipeline\PipelineBuilder;
use League\Pipeline\StageInterface;

class LimitClauseSorter implements StageInterface
{
    public function __invoke($payload)
    {

        $fragments = collect($payload->getFragments());
        $limit = ($fragments->where('type', '=', 'limit'))->first();
        if (!is_null($limit)) {
            $payload->addOrderedFragments('limit', $limit['parameters']);
        }
        return $payload;
    }
}