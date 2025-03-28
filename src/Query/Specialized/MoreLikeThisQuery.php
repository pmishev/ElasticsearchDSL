<?php

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
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-mlt-query.html
 */
class MoreLikeThisQuery implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @param string $like The text to find documents like it, required if ids or docs are not specified.
     * @param array  $parameters
     */
    public function __construct(private $like, array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'more_like_this';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query = [];

        if (($this->hasParameter('ids') === false) || ($this->hasParameter('docs') === false)) {
            $query['like'] = $this->like;
        }

        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }
}
