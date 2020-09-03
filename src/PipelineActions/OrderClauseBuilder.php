<?php

namespace RestiveSDk\PipelineActions;

use League\Pipeline\PipelineBuilder;
use League\Pipeline\StageInterface;

class OrderClauseBuilder implements StageInterface
{
    public function __invoke($payload)
    {
        $orderFragments = $payload->getOrderedFragments();
        if (!isset($orderFragments['orderBys'])) {
            return $payload;
        }
        $url = 'orderBy[]=';
        foreach ($orderFragments['orderBys'] as $orderBy) {

            $url .= '' . ($orderBy['parameters'][1] == 'desc') ? '-' : '';
            $url .= $orderBy['parameters'][0] . ',';
        }
        $url = rtrim($url, ',') . '&';
        $payload->addToUrl($url);
        return $payload;
    }
}