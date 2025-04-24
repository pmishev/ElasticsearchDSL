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
namespace ONGR\ElasticsearchDSL\Tests\Unit\Aggregation\Metric;

use ONGR\ElasticsearchDSL\Aggregation\Metric\TopHitsAggregation;
use ONGR\ElasticsearchDSL\Sort\FieldSort;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for top hits aggregation.
 */
final class TopHitsAggregationTest extends TestCase
{
    /**
     * Check if aggregation returns the expected array.
     */
    public function testToArray(): void
    {
        $sort = new FieldSort('acme', FieldSort::ASC);
        $aggregation = new TopHitsAggregation('acme', 1, 1, $sort);

        $expected = [
            'top_hits' => [
                'sort' => [
                    ['acme' => ['order' => 'asc']],
                ],
                'size' => 1,
                'from' => 1,
            ],
        ];

        $this->assertSame($expected, $aggregation->toArray());
    }

    /**
     * Check if parameters can be set to agg.
     */
    public function testParametersAddition(): void
    {
        $aggregation = new TopHitsAggregation('acme', 0, 1);
        $aggregation->addParameter('_source', ['include' => ['title']]);

        $expected = [
            'top_hits' => [
                'size'    => 0,
                'from'    => 1,
                '_source' => [
                    'include' => ['title'],
                ],
            ],
        ];

        $this->assertSame($expected, $aggregation->toArray());
    }
}
