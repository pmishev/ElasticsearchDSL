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
namespace ONGR\ElasticsearchDSL\Tests\Unit\Query\Specialized;

use ONGR\ElasticsearchDSL\Query\Specialized\ScriptQuery;
use PHPUnit\Framework\TestCase;

final class ScriptQueryTest extends TestCase
{
    /**
     * Data provider for testToArray().
     *
     */
    public static function getArrayDataProvider(): array
    {
        return [
            'simple_script' => [
                "doc['num1'].value > 1",
                [],
                ['script' => ['inline' => "doc['num1'].value > 1"]],
            ],
            'script_with_parameters' => [
                "doc['num1'].value > param1",
                ['params' => ['param1' => 5]],
                ['script' => ['inline' => "doc['num1'].value > param1", 'params' => ['param1' => 5]]],
            ],
        ];
    }

    /**
     * Test for toArray().
     *
     * @param string $script     Script
     * @param array  $parameters Optional parameters
     * @param array  $expected   Expected values
     *
     * @dataProvider getArrayDataProvider
     */
    public function testToArray(string $script, array $parameters, array $expected): void
    {
        $filter = new ScriptQuery($script, $parameters);
        $result = $filter->toArray();
        $this->assertEquals(['script' => $expected], $result);
    }
}
