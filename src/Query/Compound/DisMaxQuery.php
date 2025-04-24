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
namespace ONGR\ElasticsearchDSL\Query\Compound;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "dis_max" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-dis-max-query.html
 */
class DisMaxQuery implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @var BuilderInterface[]
     */
    private array $queries = [];

    /**
     * Initializes Dis Max query.
     */
    public function __construct(array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    /**
     * Add query.
     */
    public function addQuery(BuilderInterface $query): static
    {
        $this->queries[] = $query;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'dis_max';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $query = [];
        foreach ($this->queries as $type) {
            $query[] = $type->toArray();
        }
        $output = $this->processArray(['queries' => $query]);

        return [$this->getType() => $output];
    }
}
