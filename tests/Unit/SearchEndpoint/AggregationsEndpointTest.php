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

use ONGR\ElasticsearchDSL\Aggregation\Bucketing\MissingAggregation;
use ONGR\ElasticsearchDSL\SearchEndpoint\AggregationsEndpoint;
use PHPUnit\Framework\TestCase;

/**
 * Class AggregationsEndpointTest.
 */
final class AggregationsEndpointTest extends TestCase
{
    /**
     * Tests constructor.
     */
    public function testItCanBeInstantiated(): void
    {
        $this->assertInstanceOf(
            AggregationsEndpoint::class,
            new AggregationsEndpoint()
        );
    }

    /**
     * Tests if endpoint returns builders.
     */
    public function testEndpointGetter(): void
    {
        $aggName = 'acme_agg';
        $agg = new MissingAggregation('acme');
        $endpoint = new AggregationsEndpoint();
        $endpoint->add($agg, $aggName);
        $builders = $endpoint->getAll();

        $this->assertCount(1, $builders);
        $this->assertSame($agg, $builders[$aggName]);
    }
}
