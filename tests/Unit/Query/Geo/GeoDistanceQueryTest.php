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
namespace ONGR\ElasticsearchDSL\Tests\Unit\Query\Geo;

use ONGR\ElasticsearchDSL\Query\Geo\GeoDistanceQuery;
use PHPUnit\Framework\TestCase;

final class GeoDistanceQueryTest extends TestCase
{
    /**
     * Data provider for testToArray().
     *
     */
    public static function getArrayDataProvider(): array
    {
        return [
            // Case #1.
            [
                'location',
                '200km',
                ['lat' => 40, 'lon' => -70],
                [],
                ['distance' => '200km', 'location' => ['lat' => 40, 'lon' => -70]],
            ],
            // Case #2.
            [
                'location',
                '20km',
                ['lat'       => 0, 'lon' => 0],
                ['parameter' => 'value'],
                ['distance'  => '20km', 'location' => ['lat' => 0, 'lon' => 0], 'parameter' => 'value'],
            ],
        ];
    }

    /**
     * Tests toArray() method.
     *
     * @param string $field      Field name.
     * @param string $distance   Distance.
     * @param array  $location   Location.
     * @param array  $parameters Optional parameters.
     * @param array  $expected   Expected result.
     *
     * @dataProvider getArrayDataProvider
     */
    public function testToArray(string $field, string $distance, array $location, array $parameters, array $expected): void
    {
        $query = new GeoDistanceQuery($field, $distance, $location, $parameters);
        $result = $query->toArray();
        $this->assertEquals(['geo_distance' => $expected], $result);
    }
}
