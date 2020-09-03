<?php

namespace RestiveSDk\PipelineActions;

use League\Pipeline\PipelineBuilder;
use League\Pipeline\StageInterface;

class ReorderFragments implements StageInterface
{
    protected $whereMap = ['where'];

    protected $pipelines = [
        'RestiveSDK\\PipelineActions\\SelectClauseSorter',
        'RestiveSDK\\PipelineActions\\JoinClauseSorter',
        'RestiveSDK\\PipelineActions\\WithClauseSorter',
        'RestiveSDK\\PipelineActions\\WhereClauseSorter',
        'RestiveSDK\\PipelineActions\\OrderClauseSorter',
        'RestiveSDK\\PipelineActions\\LimitClauseSorter',
        'RestiveSDK\\PipelineActions\\TrashedClauseSorter',
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