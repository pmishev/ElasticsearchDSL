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
 * Class representing FilterAggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-filter-aggregation.html
 */
class FilterAggregation extends AbstractAggregation
{
    use BucketingTrait;

    protected ?BuilderInterface $filter = null;

    /**
     * Inner aggregations container init.
     *
     * @param string $name
     */
    public function __construct($name, ?BuilderInterface $filter = null)
    {
        parent::__construct($name);

        if ($filter instanceof BuilderInterface) {
            $this->setFilter($filter);
        }
    }

    /**
     * @return $this
     */
    public function setFilter(BuilderInterface $filter): static
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * Returns a filter.
     */
    public function getFilter(): ?BuilderInterface
    {
        return $this->filter;
    }

    /**
     * {@inheritdoc}
     */
    public function setField($field): never
    {
        throw new \LogicException("Filter aggregation, doesn't support `field` parameter");
    }

    /**
     * {@inheritdoc}
     */
    public function getArray(): array|\stdClass
    {
        if (!$this->filter instanceof BuilderInterface) {
            throw new \LogicException("Filter aggregation `{$this->getName()}` has no filter added");
        }

        return $this->getFilter()->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'filter';
    }
}
