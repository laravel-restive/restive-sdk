<?php

namespace RestiveSDk\PipelineActions;

use League\Pipeline\PipelineBuilder;
use League\Pipeline\StageInterface;

class OrderClauseBuilder implements StageInterface
{
    public function __invoke($payload)
    {
        return $payload;
    }
}