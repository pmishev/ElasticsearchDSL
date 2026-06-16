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
 * Class representing date range aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-daterange-aggregation.html
 */
class DateRangeAggregation extends AbstractAggregation
{
    use BucketingTrait;

    private ?string $format = null;

    private array $ranges = [];

    private bool $keyed = false;

    public function __construct(string $name, ?string $field = null, ?string $format = null, array $ranges = [], bool $keyed = false)
    {
        parent::__construct($name);

        $this->setField($field);
        $this->setFormat($format);
        $this->setKeyed($keyed);
        foreach ($ranges as $range) {
            $from = $range['from'] ?? null;
            $to = $range['to'] ?? null;
            $key = $range['key'] ?? null;
            $this->addRange($from, $to, $key);
        }
    }

    /**
     * Sets if result buckets should be keyed.
     */
    public function setKeyed(bool $keyed): static
    {
        $this->keyed = $keyed;

        return $this;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(?string $format): void
    {
        $this->format = $format;
    }

    /**
     * Add range to aggregation.
     *
     * @throws \LogicException
     */
    public function addRange(string|int|null $from = null, string|int|null $to = null, ?string $key = null): static
    {
        $range = array_filter(
            [
                'from' => $from,
                'to'   => $to,
                'key'  => $key,
            ],
            fn (int|string|null $v): bool => !is_null($v)
        );

        if ($range === []) {
            throw new \LogicException('Either from or to must be set. Both cannot be null.');
        }

        $this->ranges[] = $range;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getArray(): array
    {
        if ($this->getField() && $this->ranges !== []) {
            $data = [
                'field'  => $this->getField(),
                'ranges' => $this->ranges,
                'keyed'  => $this->keyed,
            ];
            if ($this->getFormat()) {
                $data['format'] = $this->getFormat();
            }

            return $data;
        }
        throw new \LogicException('Date range aggregation must have field and range added.');
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'date_range';
    }
}
