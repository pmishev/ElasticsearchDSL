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
 * Class representing ip range aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-iprange-aggregation.html
 */
class Ipv4RangeAggregation extends AbstractAggregation
{
    use BucketingTrait;

    private array $ranges = [];

    /**
     * Inner aggregations container init.
     *
     * @param string $name
     * @param string $field
     * @param array  $ranges
     */
    public function __construct($name, $field = null, $ranges = [])
    {
        parent::__construct($name);

        $this->setField($field);
        foreach ($ranges as $range) {
            if (is_array($range)) {
                $from = $range['from'] ?? null;
                $to = $range['to'] ?? null;
                $this->addRange($from, $to);
            } else {
                $this->addMask($range);
            }
        }
    }

    /**
     * Add range to aggregation.
     *
     * @param string|null $from
     * @param string|null $to
     */
    public function addRange($from = null, $to = null): static
    {
        $range = array_filter(
            [
                'from' => $from,
                'to'   => $to,
            ],
            fn ($v): bool => !is_null($v)
        );

        $this->ranges[] = $range;

        return $this;
    }

    /**
     * Add ip mask to aggregation.
     *
     * @param string $mask
     */
    public function addMask($mask): static
    {
        $this->ranges[] = ['mask' => $mask];

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'ip_range';
    }

    /**
     * {@inheritdoc}
     */
    public function getArray(): array
    {
        if ($this->getField() && $this->ranges !== []) {
            return [
                'field'  => $this->getField(),
                'ranges' => array_values($this->ranges),
            ];
        }
        throw new \LogicException('Ip range aggregation must have field set and range added.');
    }
}
