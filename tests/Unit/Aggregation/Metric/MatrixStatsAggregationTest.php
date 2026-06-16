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

use ONGR\ElasticsearchDSL\Aggregation\Metric\MatrixStatsAggregation;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for matrix stats aggregation.
 */
final class MatrixStatsAggregationTest extends TestCase
{
    /**
     * Tests getType method.
     */
    public function testGetType(): void
    {
        $aggregation = new MatrixStatsAggregation('foo', ['a', 'b']);

        $this->assertSame('matrix_stats', $aggregation->getType());
    }

    /**
     * Tests that fields are rendered as an array.
     */
    public function testToArrayWithFieldsOnly(): void
    {
        $aggregation = new MatrixStatsAggregation('foo', ['poverty', 'income']);

        $this->assertSame(
            ['matrix_stats' => ['fields' => ['poverty', 'income']]],
            $aggregation->toArray()
        );
    }

    /**
     * Tests that mode and missing are rendered when set.
     */
    public function testToArrayWithAllParameters(): void
    {
        $aggregation = new MatrixStatsAggregation('foo', ['poverty', 'income'], ['income' => 50000], 'avg');

        $this->assertSame(
            [
                'matrix_stats' => [
                    'fields'  => ['poverty', 'income'],
                    'mode'    => 'avg',
                    'missing' => ['income' => 50000],
                ],
            ],
            $aggregation->toArray()
        );
    }

    /**
     * Tests that fields can be set via the setter.
     */
    public function testSetFields(): void
    {
        $aggregation = new MatrixStatsAggregation('foo');
        $aggregation->setFields(['a', 'b']);

        $this->assertSame(['a', 'b'], $aggregation->getFields());
    }
}
