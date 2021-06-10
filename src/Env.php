<?php

namespace Emberfuse\Lockbox;

use Generator;
use PhpOption\Option;
use Dotenv\Repository\Adapter\MultiReader;
use Dotenv\Repository\Adapter\MultiWriter;
use Dotenv\Repository\RepositoryInterface;
use Dotenv\Repository\Adapter\EnvConstAdapter;
use Dotenv\Repository\Adapter\ServerConstAdapter;

class Env
{
    /**
     * The set of default adapters.
     *
     * @var string[]
     */
    protected static $adapters = [
        ServerConstAdapter::class,
        EnvConstAdapter::class,
    ];

    /**
     * The environment repository instance.
     *
     * @var \Dotenv\Repository\RepositoryInterface|null
     */
    protected static $repository;

    /**
     * Creates a new repository instance.
     *
     * @return \Dotenv\Repository\RepositoryInterface
     */
    protected static function createRepository(): RepositoryInterface
    {
        if (static::$repository === null) {
            $adapters = \iterator_to_array(self::defaultAdapters());

            static::$repository = new Repository(
                new MultiReader($adapters),
                new MultiWriter($adapters)
            );
        }

        return static::$repository;
    }

    /**
     * Gets the value of an environment variable.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        return Option::fromValue(static::createRepository()->get($key))
            ->map(function ($value) {
                switch (strtolower($value)) {
                    case 'true':
                    case '(true)':
                        return true;
                    case 'false':
                    case '(false)':
                        return false;
                    case 'empty':
                    case '(empty)':
                        return '';
                    case 'null':
                    case '(null)':
                        return;
                }

                if (preg_match('/\A([\'"])(.*)\1\z/', $value, $matches)) {
                    return $matches[2];
                }

                return $value;
            })
            ->getOrCall(fn () => $default);
    }

    /**
     * Return the array of default adapters.
     *
     * @return \Generator<\Dotenv\Repository\Adapter\AdapterInterface>
     */
    protected static function defaultAdapters(): Generator
    {
        foreach (self::$adapters as $adapter) {
            $instance = $adapter::create();

            if ($instance->isDefined()) {
                yield $instance->get();
            }
        }
    }
}
