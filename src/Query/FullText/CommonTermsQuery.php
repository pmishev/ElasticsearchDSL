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
namespace ONGR\ElasticsearchDSL\Query\FullText;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "common" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-common-terms-query.html
 */
class CommonTermsQuery implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @param string $field
     * @param string $query
     */
    public function __construct(private $field, private $query, array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'common';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $query = [
            'query' => $this->query,
        ];

        $output = [
            $this->field => $this->processArray($query),
        ];

        return [$this->getType() => $output];
    }
}
