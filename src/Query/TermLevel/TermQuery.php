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
 * Represents Elasticsearch "term" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-term-query.html
 */
class TermQuery implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @param string                $field
     * @param string|int|float|bool $value
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
        return 'term';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $query = $this->processArray();

        if ($query === []) {
            $query = $this->value;
        } else {
            $query['value'] = $this->value;
        }

        $output = [
            $this->field => $query,
        ];

        return [$this->getType() => $output];
    }
}
