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

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Bucketing\SignificantTermsAggregation;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for children aggregation.
 */
final class SignificantTermsAggregationTest extends TestCase
{
    /**
     * Tests getType method.
     */
    public function testSignificantTermsAggregationGetType(): void
    {
        $aggregation = new SignificantTermsAggregation('foo');
        $result = $aggregation->getType();
        $this->assertEquals('significant_terms', $result);
    }

    /**
     * Tests getArray method.
     */
    public function testSignificantTermsAggregationGetArray(): void
    {
        $mock = $this->getMockBuilder(AbstractAggregation::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $aggregation = new SignificantTermsAggregation('foo', 'title');
        $aggregation->addAggregation($mock);
        $result = $aggregation->getArray();
        $expected = ['field' => 'title'];
        $this->assertEquals($expected, $result);
    }
}
