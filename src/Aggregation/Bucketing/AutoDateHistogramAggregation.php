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
 * Class representing AutoDateHistogramAggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-autodatehistogram-aggregation.html
 */
class AutoDateHistogramAggregation extends AbstractAggregation
{
    use BucketingTrait;

    /**
     * Inner aggregations container init.
     *
     * @param string $name
     * @param string $field
     * @param int    $buckets
     * @param string $format
     */
    public function __construct($name, $field, $buckets = null, $format = null)
    {
        parent::__construct($name);

        $this->setField($field);

        if ($buckets) {
            $this->addParameter('buckets', $buckets);
        }

        if ($format) {
            $this->addParameter('format', $format);
        }
    }

    /**
     * {@inheritdoc}
     * @return mixed[]
     */
    public function getArray(): array
    {
        return array_filter(
            [
                'field' => $this->getField(),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'auto_date_histogram';
    }
}
