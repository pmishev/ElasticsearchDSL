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

use ONGR\ElasticsearchDSL\Aggregation\Bucketing\AdjacencyMatrixAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Bucketing\FiltersAggregation;
use ONGR\ElasticsearchDSL\BuilderInterface;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for adjacency matrix aggregation.
 */
final class AdjacencyMatrixAggregationTest extends TestCase
{
    /**
     * Test if exception is thrown when not anonymous filter is without name.
     */
    public function testIfExceptionIsThrown(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('In not anonymous filters filter name must be set.');
        $mock = $this->getMockBuilder(BuilderInterface::class)->getMock();
        $aggregation = new FiltersAggregation('test_agg');
        $aggregation->addFilter($mock);
    }

    /**
     * Test GetArray method.
     */
    public function testFiltersAggregationGetArray(): void
    {
        $mock = $this->getMockBuilder(BuilderInterface::class)->getMock();
        $aggregation = new AdjacencyMatrixAggregation('test_agg');
        $aggregation->addFilter('name', $mock);
        $result = $aggregation->getArray();
        $this->assertArrayHasKey('filters', $result);
    }

    /**
     * Tests getType method.
     */
    public function testFiltersAggregationGetType(): void
    {
        $aggregation = new AdjacencyMatrixAggregation('foo');
        $result = $aggregation->getType();
        $this->assertEquals('adjacency_matrix', $result);
    }

    /**
     * Test for filter aggregation toArray() method.
     */
    public function testToArray(): void
    {
        $aggregation = new AdjacencyMatrixAggregation('test_agg');
        $filter = $this->getMockBuilder(BuilderInterface::class)
            ->onlyMethods(['toArray', 'getType'])
            ->getMockForAbstractClass();
        $filter->expects($this->any())
            ->method('toArray')
            ->willReturn(['test_field' => ['test_value' => 'test']]);

        $aggregation->addFilter('first', $filter);
        $aggregation->addFilter('second', $filter);

        $results = $aggregation->toArray();
        $expected = [
            'adjacency_matrix' => [
                'filters' => [
                    'first' => [
                        'test_field' => [
                            'test_value' => 'test',
                        ],
                    ],
                    'second' => [
                        'test_field' => [
                            'test_value' => 'test',
                        ],
                    ],
                ],
            ],
        ];
        $this->assertEquals($expected, $results);
    }

    /**
     * Tests if filters can be passed to the constructor.
     */
    public function testFilterConstructor(): void
    {
        $builderInterface1 = $this->getMockForAbstractClass(BuilderInterface::class);
        $builderInterface2 = $this->getMockForAbstractClass(BuilderInterface::class);

        $aggregation = new AdjacencyMatrixAggregation(
            'test',
            [
                'filter1' => $builderInterface1,
                'filter2' => $builderInterface2,
            ]
        );

        $this->assertSame(
            [
                'adjacency_matrix' => [
                    'filters' => [
                        'filter1' => null,
                        'filter2' => null,
                    ],
                ],
            ],
            $aggregation->toArray()
        );

        $aggregation = new AdjacencyMatrixAggregation('test');

        $this->assertSame(
            [
                'adjacency_matrix' => [
                    'filters' => [],
                ],
            ],
            $aggregation->toArray()
        );
    }
}
