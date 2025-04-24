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
 * Class representing composite aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-composite-aggregation.html
 */
class CompositeAggregation extends AbstractAggregation
{
    use BucketingTrait;

    /**
     * @var BuilderInterface[]
     */
    private array $sources = [];

    /**
     * @var int
     */
    private $size;

    private ?array $after = null;

    /**
     * Inner aggregations container init.
     *
     * @param string                $name
     * @param AbstractAggregation[] $sources
     */
    public function __construct($name, $sources = [])
    {
        parent::__construct($name);

        foreach ($sources as $agg) {
            $this->addSource($agg);
        }
    }

    /**
     * @throws \LogicException
     */
    public function addSource(AbstractAggregation $agg): static
    {
        $array = $agg->getArray();

        $array = is_array($array) ? array_merge($array, $agg->getParameters()) : $array;

        $this->sources[] = [
            $agg->getName() => [$agg->getType() => $array],
        ];

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getArray(): array
    {
        $array = [
            'sources' => $this->sources,
        ];

        if (null !== $this->size) {
            $array['size'] = $this->size;
        }

        if ($this->after !== null && $this->after !== []) {
            $array['after'] = $this->after;
        }

        return $array;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'composite';
    }

    /**
     * Sets size
     *
     * @param int $size Size
     *
     * @return $this
     */
    public function setSize($size): static
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Returns size
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Sets after
     *
     * @param array $after After
     *
     * @return $this
     */
    public function setAfter(array $after): static
    {
        $this->after = $after;

        return $this;
    }

    /**
     * Returns after
     *
     */
    public function getAfter(): ?array
    {
        return $this->after;
    }
}
