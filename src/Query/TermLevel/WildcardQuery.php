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
 * Represents Elasticsearch "wildcard" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-wildcard-query.html
 */
class WildcardQuery implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @param string $field
     * @param string $value
     */
    public function __construct(private $field, private $value, array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'wildcard';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $query = [
            'value' => $this->value,
        ];

        $output = [
            $this->field => $this->processArray($query),
        ];

        return [$this->getType() => $output];
    }
}
