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
namespace ONGR\ElasticsearchDSL\Aggregation;

use ONGR\ElasticsearchDSL\BuilderBag;
use ONGR\ElasticsearchDSL\NameAwareTrait;
use ONGR\ElasticsearchDSL\NamedBuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * AbstractAggregation class.
 */
abstract class AbstractAggregation implements NamedBuilderInterface
{
    use ParametersTrait;
    use NameAwareTrait;

    private ?string $field = null;

    private ?BuilderBag $aggregations = null;

    /**
     * Abstract supportsNesting method.
     */
    abstract protected function supportsNesting(): bool;

    abstract protected function getArray(): array|\stdClass;

    /**
     * Inner aggregations container init.
     */
    public function __construct(string $name)
    {
        $this->setName($name);
    }

    public function setField(?string $field): static
    {
        $this->field = $field;

        return $this;
    }

    public function getField(): ?string
    {
        return $this->field;
    }

    /**
     * Adds a sub-aggregation.
     */
    public function addAggregation(AbstractAggregation $abstractAggregation): static
    {
        if (!$this->aggregations instanceof BuilderBag) {
            $this->aggregations = $this->createBuilderBag();
        }

        $this->aggregations->add($abstractAggregation);

        return $this;
    }

    /**
     * Returns all sub aggregations.
     *
     * @return NamedBuilderInterface[]
     */
    public function getAggregations(): array
    {
        if ($this->aggregations instanceof BuilderBag) {
            /** @var NamedBuilderInterface[] $result */
            $result = $this->aggregations->all();
            return $result;
        } else {
            return [];
        }
    }

    /**
     * Returns sub aggregation.
     *
     * @param string $name Aggregation name to return.
     */
    public function getAggregation(string $name): ?NamedBuilderInterface
    {
        if ($this->aggregations instanceof BuilderBag && $this->aggregations->has($name)) {
            /** @var NamedBuilderInterface $result */
            $result = $this->aggregations->get($name);
            return $result;
        } else {
            return null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $array = $this->getArray();
        $result = [
            $this->getType() => is_array($array) ? $this->processArray($array) : $array,
        ];

        if ($this->supportsNesting()) {
            $nestedResult = $this->collectNestedAggregations();

            if ($nestedResult !== []) {
                $result['aggregations'] = $nestedResult;
            }
        }

        return $result;
    }

    /**
     * Process all nested aggregations.
     */
    protected function collectNestedAggregations(): array
    {
        $result = [];
        /** @var AbstractAggregation $aggregation */
        foreach ($this->getAggregations() as $aggregation) {
            $result[$aggregation->getName()] = $aggregation->toArray();
        }

        return $result;
    }

    /**
     * Creates BuilderBag new instance.
     *
     */
    private function createBuilderBag(): BuilderBag
    {
        return new BuilderBag();
    }
}
