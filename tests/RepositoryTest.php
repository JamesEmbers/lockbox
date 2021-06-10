<?php

namespace Emberfuse\Lockbox\Tests;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Emberfuse\Lockbox\Repository;
use Dotenv\Repository\RepositoryInterface;
use Dotenv\Repository\Adapter\ReaderInterface;
use Dotenv\Repository\Adapter\WriterInterface;

class RepositoryTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();
    }

    public function testInstantiation()
    {
        $respository = new Repository(
            m::mock(ReaderInterface::class),
            m::mock(WriterInterface::class)
        );

        $this->assertInstanceOf(RepositoryInterface::class, $respository);
    }
}
