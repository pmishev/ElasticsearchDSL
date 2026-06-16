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
namespace ONGR\ElasticsearchDSL\Aggregation\Metric;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Type\MetricTrait;

/**
 * Class representing matrix stats aggregation.
 *
 * @see https://www.elastic.co/docs/reference/aggregations/search-aggregations-matrix-stats-aggregation
 */
class MatrixStatsAggregation extends AbstractAggregation
{
    use MetricTrait;

    /**
     * @param string[]                  $fields  Fields to compute statistics over.
     * @param array<string, mixed>|null $missing Per-field default values for documents missing a value.
     * @param string|null               $mode    Reduction of multi-valued fields: avg, min, max, sum or median.
     */
    public function __construct(
        string $name,
        private array $fields = [],
        private ?array $missing = null,
        private ?string $mode = null,
    ) {
        parent::__construct($name);
    }

    /**
     * @return string[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param string[] $fields
     */
    public function setFields(array $fields): static
    {
        $this->fields = $fields;

        return $this;
    }

    public function getMode(): ?string
    {
        return $this->mode;
    }

    public function setMode(?string $mode): static
    {
        $this->mode = $mode;

        return $this;
    }

    public function getMissing(): ?array
    {
        return $this->missing;
    }

    public function setMissing(?array $missing): static
    {
        $this->missing = $missing;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'matrix_stats';
    }

    /**
     * {@inheritdoc}
     * @return mixed[]
     */
    protected function getArray(): array
    {
        $out = [];

        if ($this->fields !== []) {
            $out['fields'] = $this->fields;
        }

        if ($this->mode !== null) {
            $out['mode'] = $this->mode;
        }

        if ($this->missing !== null && $this->missing !== []) {
            $out['missing'] = $this->missing;
        }

        return $out;
    }
}
