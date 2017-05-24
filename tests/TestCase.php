<?php

use App\User;
use Tests\TestsHelper;
use Tests\CreatesApplication;


abstract class TestCase extends \Laravel\BrowserKitTesting\TestCase
{
    use CreatesApplication, TestsHelper;
}
