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
 * Class representing geo diversified sampler aggregation.
 *
 * @see https://goo.gl/yzXvqD
 */
class DiversifiedSamplerAggregation extends AbstractAggregation
{
    use BucketingTrait;

    /**
     * Defines how many results will be received from each shard
     *
     * @param int $shardSize
     */
    private $shardSize;

    /**
     * DiversifiedSamplerAggregation constructor.
     *
     * @param string $name      Aggregation name
     * @param string $field     Elasticsearch field name
     * @param int    $shardSize Shard size, by default it's 100
     */
    public function __construct($name, $field = null, $shardSize = null)
    {
        parent::__construct($name);

        $this->setField($field);
        $this->setShardSize($shardSize);
    }

    /**
     * @return mixed
     */
    public function getShardSize()
    {
        return $this->shardSize;
    }

    /**
     * @param mixed $shardSize
     *
     * @return $this
     */
    public function setShardSize($shardSize): static
    {
        $this->shardSize = $shardSize;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'diversified_sampler';
    }

    /**
     * {@inheritdoc}
     * @return mixed[]
     */
    protected function getArray(): array
    {
        return array_filter(
            [
                'field'      => $this->getField(),
                'shard_size' => $this->getShardSize(),
            ]
        );
    }
}
