<?php

namespace RestiveSDk\PipelineActions;

use League\Pipeline\PipelineBuilder;
use League\Pipeline\StageInterface;

class LimitClauseBuilder implements StageInterface
{
    public function __invoke($payload)
    {
        $orderFragments = $payload->getOrderedFragments();
        if (!isset($orderFragments['limit'])) {
            return $payload;
        }
        $url = 'limit[]=' . $orderFragments['limit'] . '&';
        $payload->addToUrl($url);
        return $payload;
    }
}