<?php

declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ONGR\ElasticsearchDSL;

/**
 * Container for named builders.
 */
class BuilderBag
{
    /**
     * @var BuilderInterface[]
     */
    private array $bag = [];

    /**
     * @param BuilderInterface[] $builders
     */
    public function __construct($builders = [])
    {
        foreach ($builders as $builder) {
            $this->add($builder);
        }
    }

    /**
     * Adds a builder.
     *
     * @return string
     */
    public function add(BuilderInterface $builder)
    {
        $name = method_exists($builder, 'getName') ? $builder->getName() : bin2hex(random_bytes(30));

        $this->bag[$name] = $builder;

        return $name;
    }

    /**
     * Checks if builder exists by a specific name.
     *
     * @param string $name Builder name.
     *
     */
    public function has($name): bool
    {
        return isset($this->bag[$name]);
    }

    /**
     * Removes a builder by name.
     *
     * @param string $name Builder name.
     */
    public function remove($name): void
    {
        unset($this->bag[$name]);
    }

    /**
     * Clears contained builders.
     */
    public function clear(): void
    {
        $this->bag = [];
    }

    /**
     * Returns a builder by name.
     *
     * @param string $name Builder name.
     *
     * @return BuilderInterface
     */
    public function get($name)
    {
        return $this->bag[$name];
    }

    /**
     * Returns all builders contained.
     *
     * @param string|null $type Builder type.
     *
     * @return BuilderInterface[]
     */
    public function all($type = null): array
    {
        return array_filter(
            $this->bag,
            fn (BuilderInterface $builder): bool => null === $type || $builder->getType() == $type
        );
    }

    /**
     * @return mixed[]
     */
    public function toArray(): array
    {
        $output = [];
        foreach ($this->all() as $builder) {
            $output = array_merge($output, $builder->toArray());
        }

        return $output;
    }
}
