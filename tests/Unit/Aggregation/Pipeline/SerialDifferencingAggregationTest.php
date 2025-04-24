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

use ONGR\ElasticsearchDSL\Aggregation\Pipeline\SerialDifferencingAggregation;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for serial differencing aggregation.
 */
final class SerialDifferencingAggregationTest extends TestCase
{
    /**
     * Tests toArray method.
     */
    public function testToArray(): void
    {
        $aggregation = new SerialDifferencingAggregation('acme', 'test');
        $aggregation->addParameter('lag', '7');

        $expected = [
            'serial_diff' => [
                'buckets_path' => 'test',
                'lag'          => '7',
            ],
        ];

        $this->assertEquals($expected, $aggregation->toArray());
    }
}
