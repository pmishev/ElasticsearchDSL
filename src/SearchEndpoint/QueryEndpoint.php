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
namespace ONGR\ElasticsearchDSL\SearchEndpoint;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Serializer\Normalizer\OrderedNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Search query dsl endpoint.
 */
class QueryEndpoint extends AbstractSearchEndpoint implements OrderedNormalizerInterface
{
    /**
     * Endpoint name
     */
    public const NAME = 'query';

    private ?BoolQuery $bool = null;

    private bool $filtersSet = false;

    /**
     * {@inheritdoc}
     */
    public function normalize(NormalizerInterface $normalizer, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        if (!$this->filtersSet && $this->hasReference('filter_query')) {
            /** @var BuilderInterface $filter */
            $filter = $this->getReference('filter_query');
            $this->addToBool($filter, BoolQuery::FILTER);
            $this->filtersSet = true;
        }

        if (!$this->bool instanceof BoolQuery) {
            return null;
        }

        return $this->bool->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function add(BuilderInterface $builder, $key = null): string
    {
        return $this->addToBool($builder, BoolQuery::MUST, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function addToBool(BuilderInterface $builder, $boolType = null, $key = null): string
    {
        if (!$this->bool instanceof BoolQuery) {
            $this->bool = new BoolQuery();
        }

        return $this->bool->add($builder, $boolType, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder(): int
    {
        return 2;
    }

    /**
     */
    public function getBool(): ?BoolQuery
    {
        return $this->bool;
    }

    /**
     * {@inheritdoc}
     */
    public function getAll($boolType = null): array
    {
        return $this->bool->getQueries($boolType);
    }
}
