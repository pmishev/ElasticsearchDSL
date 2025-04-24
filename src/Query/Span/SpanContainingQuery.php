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
 * Elasticsearch span containing query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-containing-query.html
 */
class SpanContainingQuery implements SpanQueryInterface
{
    use ParametersTrait;

    private SpanQueryInterface $little;

    private SpanQueryInterface $big;

    public function __construct(SpanQueryInterface $little, SpanQueryInterface $big)
    {
        $this->setLittle($little);
        $this->setBig($big);
    }

    /**
     */
    public function getLittle(): SpanQueryInterface
    {
        return $this->little;
    }

    /**
     * @return $this
     */
    public function setLittle(SpanQueryInterface $little): static
    {
        $this->little = $little;

        return $this;
    }

    /**
     */
    public function getBig(): SpanQueryInterface
    {
        return $this->big;
    }

    /**
     * @return $this
     */
    public function setBig(SpanQueryInterface $big): static
    {
        $this->big = $big;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'span_containing';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $output = [
            'little' => $this->getLittle()->toArray(),
            'big'    => $this->getBig()->toArray(),
        ];

        $output = $this->processArray($output);

        return [$this->getType() => $output];
    }
}
