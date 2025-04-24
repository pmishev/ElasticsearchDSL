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
namespace ONGR\ElasticsearchDSL\Tests\Unit\Aggregation\Pipeline;

use ONGR\ElasticsearchDSL\Aggregation\Pipeline\PercentilesBucketAggregation;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for percentiles bucket aggregation.
 */
final class PercentilesBucketAggregationTest extends TestCase
{
    /**
     * Tests toArray method.
     */
    public function testToArray(): void
    {
        $aggregation = new PercentilesBucketAggregation('acme', 'test');
        $aggregation->setPercents([25.0, 50.0, 75.0]);

        $expected = [
            'percentiles_bucket' => [
                'buckets_path' => 'test',
                'percents'     => [25.0, 50.0, 75.0],
            ],
        ];

        $this->assertEquals($expected, $aggregation->toArray());
    }
}
