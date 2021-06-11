<?php

namespace Emberfuse\Lockbox;

use PHPUnit\Framework\TestCase;

class EnvTest extends TestCase
{
    public function testGetFalseValue()
    {
        $repository = Env::createRepository();
        $repository->set('FOO', '(false)');

        $this->assertEquals(false, Env::get('FOO'));
        $this->assertNotEquals(false, $repository->get('FOO'));
    }
}
