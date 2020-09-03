<?php

namespace RestiveSDk\PipelineActions;

use League\Pipeline\PipelineBuilder;
use League\Pipeline\StageInterface;

class JoinClauseBuilder implements StageInterface
{
    public function __invoke($payload)
    {
        $orderFragments = $payload->getOrderedFragments();
        if (!isset($orderFragments['joins'])) {
            return $payload;
        }
        $url = '';
        foreach ($orderFragments['joins'] as $join) {
            $url .= 'join[]=' . $join['parameters'][1] . ':';
            $url .= $join['parameters'][0] . ':';
            $url .= $join['parameters'][2] . ':';
            $url .= $join['parameters'][2];
        }
        $url .= '&';
        $payload->addToUrl($url);
        return $payload;
    }
}