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
namespace ONGR\ElasticsearchDSL\Tests\Unit\Query\Span;

use ONGR\ElasticsearchDSL\Query\Span\SpanOrQuery;
use ONGR\ElasticsearchDSL\Query\Span\SpanQueryInterface;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for SpanOrQuery.
 */
final class SpanOrQueryTest extends TestCase
{
    /**
     * Tests for toArray().
     */
    public function testToArray(): void
    {
        $mock = $this->getMockBuilder(SpanQueryInterface::class)->getMock();
        $mock
            ->expects($this->once())
            ->method('toArray')
            ->willReturn(['span_term' => ['key' => 'value']]);

        $query = new SpanOrQuery();
        $query->addQuery($mock);
        $result = [
            'span_or' => [
                'clauses' => [
                    0 => [
                        'span_term' => ['key' => 'value'],
                    ],
                ],
            ],
        ];
        $this->assertEquals($result, $query->toArray());

        $result = $query->getQueries();
        $this->assertEquals(1, count($result));
    }
}
