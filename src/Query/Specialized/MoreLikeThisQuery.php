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
namespace ONGR\ElasticsearchDSL\Query\Specialized;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "more_like_this" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-mlt-query.html
 */
class MoreLikeThisQuery implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @param string $like The text to find documents like it, required if ids or docs are not specified.
     */
    public function __construct(private $like, array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'more_like_this';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $query = [];

        if ((false === $this->hasParameter('ids')) || (false === $this->hasParameter('docs'))) {
            $query['like'] = $this->like;
        }

        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }
}
