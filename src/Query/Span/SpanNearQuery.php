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

/**
 * Elasticsearch span near query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-near-query.html
 */
class SpanNearQuery extends SpanOrQuery implements SpanQueryInterface
{
    /**
     * @var int
     */
    private $slop;

    /**
     * @return int
     */
    public function getSlop()
    {
        return $this->slop;
    }

    /**
     * @param int $slop
     *
     * @return $this
     */
    public function setSlop($slop): static
    {
        $this->slop = $slop;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'span_near';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $query = [];
        foreach ($this->getQueries() as $type) {
            $query['clauses'][] = $type->toArray();
        }
        $query['slop'] = $this->getSlop();
        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }
}
