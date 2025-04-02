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
namespace ONGR\ElasticsearchDSL\Tests\Unit\SearchEndpoint;

use ONGR\ElasticsearchDSL\SearchEndpoint\AggregationsEndpoint;
use ONGR\ElasticsearchDSL\SearchEndpoint\SearchEndpointFactory;
use ONGR\ElasticsearchDSL\SearchEndpoint\SearchEndpointInterface;
use PHPUnit\Framework\TestCase;

/**
 * Unit test class for search endpoint factory.
 */
final class SearchEndpointFactoryTest extends TestCase
{
    /**
     * Tests get method exception.
     */
    public function testGet(): void
    {
        $this->expectException(\RuntimeException::class);
        SearchEndpointFactory::get('foo');
    }

    /**
     * Tests if factory can create endpoint.
     */
    public function testFactory(): void
    {
        $endpoint = SearchEndpointFactory::get(AggregationsEndpoint::NAME);
        $this->assertInstanceOf(SearchEndpointInterface::class, $endpoint);
    }
}
