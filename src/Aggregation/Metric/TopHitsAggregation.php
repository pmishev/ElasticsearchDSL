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
use ONGR\ElasticsearchDSL\Sort\FieldSort;

/**
 * Top hits aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-top-hits-aggregation.html
 */
class TopHitsAggregation extends AbstractAggregation
{
    use MetricTrait;

    /**
     * Number of top matching hits to return per bucket.
     */
    private ?int $size;

    /**
     * The offset from the first result you want to fetch.
     */
    private ?int $from;

    /**
     * @var FieldSort[] How the top matching hits should be sorted.
     */
    private array $sorts = [];

    /**
     * Constructor for top hits.
     *
     * @param string                $name Aggregation name.
     * @param int|null              $size Number of top matching hits to return per bucket.
     * @param int|null              $from The offset from the first result you want to fetch.
     * @param FieldSort|null $sort How the top matching hits should be sorted.
     */
    public function __construct($name, int $size = null, int $from = null, FieldSort $sort = null)
    {
        parent::__construct($name);
        $this->setFrom($from);
        $this->setSize($size);
        if ($sort instanceof FieldSort) {
            $this->addSort($sort);
        }
    }

    public function getFrom(): ?int
    {
        return $this->from;
    }

    public function setFrom(?int $from): static
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return FieldSort[]
     */
    public function getSorts(): array
    {
        return $this->sorts;
    }

    /**
     * @param FieldSort[] $sorts
     *
     * @return $this
     */
    public function setSorts(array $sorts): static
    {
        $this->sorts = $sorts;

        return $this;
    }

    public function addSort(FieldSort $sort): void
    {
        $this->sorts[] = $sort;
    }

    public function setSize(?int $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function getType(): string
    {
        return 'top_hits';
    }

    public function getArray(): array|\stdClass
    {
        $sortsOutput = [];
        $addedSorts = array_filter($this->getSorts());
        if ($addedSorts !== []) {
            foreach ($addedSorts as $sort) {
                $sortsOutput[] = $sort->toArray();
            }
        } else {
            $sortsOutput = null;
        }

        $output = array_filter(
            [
                'sort' => $sortsOutput,
                'size' => $this->getSize(),
                'from' => $this->getFrom(),
            ],
            fn (array|int|null $val): bool => $val !== null
        );

        return $output === [] ? new \stdClass() : $output;
    }
}
