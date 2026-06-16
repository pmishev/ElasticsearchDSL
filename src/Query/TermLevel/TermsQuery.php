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
 * Represents Elasticsearch "terms" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-terms-query.html
 */
class TermsQuery implements BuilderInterface
{
    use ParametersTrait;

    public function __construct(private readonly string $field, private readonly array $terms, array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'terms';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $query = [
            $this->field => $this->terms,
        ];

        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }
}
