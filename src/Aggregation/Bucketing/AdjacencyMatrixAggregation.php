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
namespace ONGR\ElasticsearchDSL\Aggregation\Bucketing;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Type\BucketingTrait;
use ONGR\ElasticsearchDSL\BuilderInterface;

/**
 * Class representing adjacency matrix aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-adjacency-matrix-aggregation.html
 */
class AdjacencyMatrixAggregation extends AbstractAggregation
{
    use BucketingTrait;
    public const FILTERS = 'filters';

    /**
     * @var BuilderInterface[]
     */
    private array $filters = [
        self::FILTERS => [],
    ];

    /**
     * Inner aggregations container init.
     *
     * @param string             $name
     * @param BuilderInterface[] $filters
     */
    public function __construct($name, $filters = [])
    {
        parent::__construct($name);

        foreach ($filters as $name => $filter) {
            $this->addFilter($name, $filter);
        }
    }

    /**
     * @param string $name
     *
     *
     * @throws \LogicException
     */
    public function addFilter($name, BuilderInterface $filter): static
    {
        $this->filters[self::FILTERS][$name] = $filter->toArray();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getArray(): array
    {
        return $this->filters;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'adjacency_matrix';
    }
}
