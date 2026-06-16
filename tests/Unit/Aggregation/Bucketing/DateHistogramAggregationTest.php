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
namespace ONGR\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use ONGR\ElasticsearchDSL\Aggregation\Bucketing\DateHistogramAggregation;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for children aggregation.
 */
final class DateHistogramAggregationTest extends TestCase
{
    /**
     * Tests getType method.
     */
    public function testDateHistogramAggregationGetType(): void
    {
        $aggregation = new DateHistogramAggregation('foo', 'test');
        self::assertSame('foo', $aggregation->getName());
        $result = $aggregation->getType();
        self::assertEquals('date_histogram', $result);
    }

    /**
     * Tests getArray method.
     */
    public function testChildrenAggregationGetArray(): void
    {
        $aggregation = new DateHistogramAggregation('foo', 'test');
        $aggregation->setField('date');
        $aggregation->setCalendarInterval('month');
        $result = $aggregation->getArray();
        $expected = ['field' => 'date', 'calendar_interval' => 'month'];
        self::assertEquals($expected, $result);
    }

    public function testWithoutInterval(): void
    {
        static::expectException(\LogicException::class);
        (new DateHistogramAggregation('foo', 'test'))->toArray();
    }

    public function testTimeZoneWillBePassed(): void
    {
        $aggregation = new DateHistogramAggregation('foo', 'test');
        $aggregation->setTimeZone('Europe/Berlin');
        $aggregation->setCalendarInterval('1m');
        $aggregation->setFixedInterval('1m');
        $aggregation->setFormat('YYYY-mm-dd');

        self::assertSame([
            'date_histogram' => [
                'field'             => 'test',
                'calendar_interval' => '1m',
                'fixed_interval'    => '1m',
                'time_zone'         => 'Europe/Berlin',
                'format'            => 'YYYY-mm-dd',
            ],
        ], $aggregation->toArray());
    }

    public function testCalenderInterval(): void
    {
        $aggregation = new DateHistogramAggregation('foo', 'test', '1m', '1m', 'test', 'Europe/Berlin');

        self::assertSame('1m', $aggregation->getCalendarInterval());
        self::assertSame('1m', $aggregation->getFixedInterval());
        self::assertSame('test', $aggregation->getFormat());
        self::assertSame('Europe/Berlin', $aggregation->getTimeZone());
    }
}