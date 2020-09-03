<?php

namespace RestiveSDk\PipelineActions;

use League\Pipeline\PipelineBuilder;
use League\Pipeline\StageInterface;

class SelectClauseBuilder implements StageInterface
{
    public function __invoke($payload)
    {
        $orderFragments = $payload->getOrderedFragments();
        if (!isset($orderFragments['columns'])) {
            return $payload;
        }
        if (count($orderFragments['columns']) === 0) {
            return $payload;
        }
        $url = 'columns[]=';
        foreach ($orderFragments['columns'] as $column) {

            $url .= $column['parameters'] . ',';
        }
        $url = rtrim($url, ',');
        $url .= '&';
        $payload->addToUrl($url);
        return $payload;
    }
}