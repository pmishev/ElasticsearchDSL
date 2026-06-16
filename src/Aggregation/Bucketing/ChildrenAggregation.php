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

/**
 * Class representing ChildrenAggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-children-aggregation.html
 */
class ChildrenAggregation extends AbstractAggregation
{
    use BucketingTrait;

    private ?string $children = null;

    /**
     * Return children.
     */
    public function getChildren(): ?string
    {
        return $this->children;
    }

    public function __construct(string $name, ?string $children = null)
    {
        parent::__construct($name);

        $this->setChildren($children);
    }

    public function setChildren(?string $children): static
    {
        $this->children = $children;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'children';
    }

    /**
     * {@inheritdoc}
     */
    public function getArray(): array
    {
        if (0 === count($this->getAggregations())) {
            throw new \LogicException("Children aggregation `{$this->getName()}` has no aggregations added");
        }

        return ['type' => $this->getChildren()];
    }
}
