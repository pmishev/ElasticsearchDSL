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

    /**
     * @var string
     */
    private $field;

    private ?BuilderBag $aggregations = null;

    /**
     * Abstract supportsNesting method.
     *
     * @return bool
     */
    abstract protected function supportsNesting();

    abstract protected function getArray(): array|\stdClass;

    /**
     * Inner aggregations container init.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->setName($name);
    }

    /**
     * @param string $field
     *
     * @return $this
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Adds a sub-aggregation.
     *
     * @return $this
     */
    public function addAggregation(AbstractAggregation $abstractAggregation)
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
    public function getAggregations()
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
    public function toArray()
    {
        $array = $this->getArray();
        $result = [
            $this->getType() => is_array($array) ? $this->processArray($array) : $array,
        ];

        if ($this->supportsNesting()) {
            $nestedResult = $this->collectNestedAggregations();

            if (!empty($nestedResult)) {
                $result['aggregations'] = $nestedResult;
            }
        }

        return $result;
    }

    /**
     * Process all nested aggregations.
     *
     * @return array
     */
    protected function collectNestedAggregations()
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
