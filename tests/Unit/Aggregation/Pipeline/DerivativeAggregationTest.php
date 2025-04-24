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

use ONGR\ElasticsearchDSL\Aggregation\Pipeline\DerivativeAggregation;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for derivative aggregation.
 */
final class DerivativeAggregationTest extends TestCase
{
    /**
     * Tests toArray method.
     */
    public function testToArray(): void
    {
        $aggregation = new DerivativeAggregation('foo', 'foo>bar');
        $aggregation->addParameter('gap_policy', 'skip');

        $expected = [
            'derivative' => [
                'buckets_path' => 'foo>bar',
                'gap_policy'   => 'skip',
            ],
        ];

        $this->assertEquals($expected, $aggregation->toArray());
    }
}
