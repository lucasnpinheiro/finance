<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace HyperfTest\Unit\Controller;

use Hyperf\Testing\TestCase;

/**
 * @internal
 * @coversNothing
 */
class AccountControllerTest extends TestCase
{
    public function testResponseSuccess()
    {
        $this->post('/account')->assertOk();
    }
}
