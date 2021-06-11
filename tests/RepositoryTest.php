<?php

namespace Emberfuse\Lockbox\Tests;

use Mockery as m;
use Emberfuse\Lockbox\Env;
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

    public function testCreateRepository()
    {
        $this->assertInstanceOf(RepositoryInterface::class, Env::createRepository());
    }

    public function testRetrieveValue()
    {
        $repository = Env::createRepository();
        $repository->set('FOO', 'BAR');

        $this->assertEquals('BAR', $repository->get('FOO'));
    }

    public function testDetermineExistanceOfValue()
    {
        $repository = Env::createRepository();
        $repository->set('FOO', 'BAR');

        $this->assertTrue($repository->has('FOO'));
        $this->assertFalse($repository->has('FUR'));
    }

    public function testRemoveValue()
    {
        $repository = Env::createRepository();
        $repository->set('FOO', 'BAR');

        $this->assertTrue($repository->has('FOO'));

        $repository->clear('FOO');

        $this->assertFalse($repository->has('FOO'));
    }
}
