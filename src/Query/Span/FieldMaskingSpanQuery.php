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
namespace ONGR\ElasticsearchDSL\Query\Span;

use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Elasticsearch span within query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-field-masking-query.html
 */
class FieldMaskingSpanQuery implements SpanQueryInterface
{
    use ParametersTrait;

    /**
     * @var SpanQueryInterface
     */
    private $query;

    /**
     * @var string
     */
    private $field;

    /**
     * @param string $field
     */
    public function __construct($field, SpanQueryInterface $query)
    {
        $this->setQuery($query);
        $this->setField($field);
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param mixed $query
     *
     * @return $this
     */
    public function setQuery($query): static
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param string $field
     *
     * @return $this
     */
    public function setField($field): static
    {
        $this->field = $field;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $output = [
            'query' => $this->getQuery()->toArray(),
            'field' => $this->getField(),
        ];

        $output = $this->processArray($output);

        return [$this->getType() => $output];
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'field_masking_span';
    }
}
