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

use ONGR\ElasticsearchDSL\Query\MatchAllQuery;
use ONGR\ElasticsearchDSL\SearchEndpoint\PostFilterEndpoint;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class PostFilterEndpointTest.
 */
final class PostFilterEndpointTest extends TestCase
{
    /**
     * Tests constructor.
     */
    public function testItCanBeInstantiated(): void
    {
        $this->assertInstanceOf(PostFilterEndpoint::class, new PostFilterEndpoint());
    }

    /**
     * Tests if correct order is returned. It's very important that filters must be executed second.
     */
    public function testGetOrder(): void
    {
        $instance = new PostFilterEndpoint();
        $this->assertEquals(1, $instance->getOrder());
    }

    /**
     * Test normalization.
     */
    public function testNormalization(): void
    {
        $instance = new PostFilterEndpoint();
        $normalizerInterface = $this->getMockForAbstractClass(
            NormalizerInterface::class
        );
        $this->assertNull($instance->normalize($normalizerInterface));

        $matchAll = new MatchAllQuery();
        $instance->add($matchAll);

        $this->assertEquals(
            json_encode($matchAll->toArray()),
            json_encode($instance->normalize($normalizerInterface))
        );
    }

    /**
     * Tests if endpoint returns builders.
     */
    public function testEndpointGetter(): void
    {
        $filterName = 'acme_post_filter';
        $filter = new MatchAllQuery();

        $endpoint = new PostFilterEndpoint();
        $endpoint->add($filter, $filterName);
        $builders = $endpoint->getAll();

        $this->assertCount(1, $builders);
        $this->assertSame($filter, $builders[$filterName]);
    }
}
