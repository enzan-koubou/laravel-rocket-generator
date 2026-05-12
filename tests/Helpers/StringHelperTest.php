<?php
namespace EnzanRocket\Generator\Tests\Helpers;

use EnzanRocket\Generator\Helpers\StringHelper;
use EnzanRocket\Generator\Tests\TestCase;

class StringHelperTest extends TestCase
{
    public function testHasPrefix()
    {
        $result = StringHelper::hasPrefix('test_role', ['role', 'status']);
        $this->assertTrue($result);

        $result = StringHelper::hasPrefix('status', ['role', 'status']);
        $this->assertTrue($result);

        $result = StringHelper::hasPrefix('hoge', ['role', 'status']);
        $this->assertFalse($result);
    }
}
