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
namespace ONGR\ElasticsearchDSL\Query\TermLevel;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "regexp" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-regexp-query.html
 */
class RegexpQuery implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @param string $field
     * @param string $regexpValue
     */
    public function __construct(private $field, private $regexpValue, array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'regexp';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $query = [
            'value' => $this->regexpValue,
        ];

        $output = [
            $this->field => $this->processArray($query),
        ];

        return [$this->getType() => $output];
    }
}
