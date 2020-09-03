<?php

namespace RestiveSDk\PipelineActions;

use League\Pipeline\PipelineBuilder;
use League\Pipeline\StageInterface;

class BuildUrlFragments implements StageInterface
{
    protected $whereMap = ['where'];

    protected $pipelines = [
        'RestiveSDK\\PipelineActions\\SelectClauseBuilder',
        'RestiveSDK\\PipelineActions\\JoinClauseBuilder',
        'RestiveSDK\\PipelineActions\\WithClauseBuilder',
        'RestiveSDK\\PipelineActions\\WhereClauseBuilder',
        'RestiveSDK\\PipelineActions\\OrderClauseBuilder',
        'RestiveSDK\\PipelineActions\\TrashedClauseBuilder',
        ];

    public function __invoke($payload)
    {
        $pipeline = $this->buildPipeline();
        $pipeline->process($payload);
        return $payload;
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