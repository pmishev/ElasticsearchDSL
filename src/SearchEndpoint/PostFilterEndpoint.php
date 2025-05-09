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

use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Search post filter dsl endpoint.
 */
class PostFilterEndpoint extends QueryEndpoint
{
    /**
     * Endpoint name
     */
    public const NAME = 'post_filter';

    /**
     * {@inheritdoc}
     */
    public function normalize(NormalizerInterface $normalizer, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        if (!$this->getBool() instanceof BoolQuery) {
            return null;
        }

        return $this->getBool()->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder(): int
    {
        return 1;
    }
}
