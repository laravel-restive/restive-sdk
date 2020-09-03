<?php

namespace RestiveSDk\PipelineActions;

use League\Pipeline\PipelineBuilder;
use League\Pipeline\StageInterface;

class TrashedClauseSorter implements StageInterface
{
    public function __invoke($payload)
    {
        $trashedMap = ['withTrashed', 'onlyTrashed'];

        $fragments = collect($payload->getFragments());
        $trashed = ($fragments->whereIn('type', $trashedMap))->toArray();
        $payload->addOrderedFragments('trashed', $trashed);
        return $payload;
    }
}