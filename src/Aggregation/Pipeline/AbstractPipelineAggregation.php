<?php

declare(strict_types=1);

namespace ONGR\ElasticsearchDSL\Aggregation\Pipeline;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Type\MetricTrait;

abstract class AbstractPipelineAggregation extends AbstractAggregation
{
    use MetricTrait;

    private string|array|null $bucketsPath = null;

    public function __construct(string $name, string|array|null $bucketsPath = null)
    {
        parent::__construct($name);
        $this->setBucketsPath($bucketsPath);
    }

    public function getBucketsPath(): string|array|null
    {
        return $this->bucketsPath;
    }

    public function setBucketsPath(string|array|null $bucketsPath): static
    {
        $this->bucketsPath = $bucketsPath;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getArray(): array
    {
        return ['buckets_path' => $this->getBucketsPath()];
    }
}
