<?php

namespace Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\Fixtures\Models\ZcwiltPost;
use Restive\ApiQueryParser;
use Restive\ParserFactory;
use Illuminate\Support\Facades\Request;
use Tests\Fixtures\Models\ZcwiltUser;

abstract class TestCase extends Orchestra
{
    public function setUp() : void
    {
        parent::setUp();
    }
}
