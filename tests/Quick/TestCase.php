<?php

namespace Tests\Quick;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Sofa\EloquentTestsuite\EloquentSuite;

abstract class TestCase extends BaseTestCase
{
    use EloquentSuite;
}
