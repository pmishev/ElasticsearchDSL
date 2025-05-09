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

use ONGR\ElasticsearchDSL\Query\FullText\QueryStringQuery;
use PHPUnit\Framework\TestCase;

final class QueryStringQueryTest extends TestCase
{
    /**
     * Tests toArray().
     */
    public function testToArray(): void
    {
        $query = new QueryStringQuery('this AND that OR thus');
        $expected = [
            'query_string' => [
                'query' => 'this AND that OR thus',
            ],
        ];

        $this->assertEquals($expected, $query->toArray());
    }
}
