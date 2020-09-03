<?php

namespace RestiveSDk\PipelineActions;

use League\Pipeline\PipelineBuilder;
use League\Pipeline\StageInterface;

class WithClauseBuilder implements StageInterface
{
    public function __invoke($payload)
    {
        $orderFragments = $payload->getOrderedFragments();
        if (!isset($orderFragments['withs'])) {
            return $payload;
        }
        $url = 'with[]=';
        foreach ($orderFragments['withs'] as $with) {

            $url .= $with['parameters'] . ',';
        }
        $url = rtrim($url, ',');
        $url .= '&';
        $payload->addToUrl($url);
        return $payload;
    }
}