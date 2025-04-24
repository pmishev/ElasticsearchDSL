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
namespace ONGR\ElasticsearchDSL\Tests\Unit\Query\FullText;

use ONGR\ElasticsearchDSL\Query\FullText\MultiMatchQuery;
use PHPUnit\Framework\TestCase;

final class MultiMatchQueryTest extends TestCase
{
    /**
     * Tests toArray().
     */
    public function testToArray(): void
    {
        $query = new MultiMatchQuery(['message', 'title'], 'this is a test');
        $expected = [
            'multi_match' => [
                'query'  => 'this is a test',
                'fields' => ['message', 'title'],
            ],
        ];

        $this->assertEquals($expected, $query->toArray());
    }

    /**
     * Tests multi-match query with no fields.
     */
    public function testToArrayWithNoFields(): void
    {
        $query = new MultiMatchQuery([], 'this is a test');
        $expected = [
            'multi_match' => [
                'query' => 'this is a test',
            ],
        ];

        $this->assertEquals($expected, $query->toArray());
    }
}
