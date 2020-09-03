<?php

namespace RestiveSDk\PipelineActions;

use League\Pipeline\PipelineBuilder;
use League\Pipeline\StageInterface;

class TrashedClauseBuilder implements StageInterface
{
    public function __invoke($payload)
    {
        return $payload;
    }
}