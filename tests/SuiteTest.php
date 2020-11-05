<?php

namespace Dainsys\Locky\Tests;

use Dainsys\Locky\Tests\Feature\PermissionTestTrait;
use Dainsys\Locky\Tests\Feature\RoleTestsTrait;
use Dainsys\Locky\Tests\Feature\UserTestsTrait;
use Dainsys\Locky\Tests\TestCase;

class SuiteTest extends TestCase
{
    use PermissionTestTrait;
    use RoleTestsTrait;
    use UserTestsTrait;
}
