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
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Search highlight dsl endpoint.
 */
class HighlightEndpoint extends AbstractSearchEndpoint
{
    /**
     * Endpoint name
     */
    public const NAME = 'highlight';

    /**
     * {@inheritdoc}
     */
    public function normalize(NormalizerInterface $normalizer, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        $highlight = current($this->container);
        if ($highlight instanceof BuilderInterface) {
            return $highlight->toArray();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function add(BuilderInterface $builder, $key = null): string
    {
        if ($this->container !== []) {
            throw new \OverflowException('Only one highlight can be set');
        }

        return parent::add($builder, $key);
    }

    /**
     */
    public function getHighlight(): ?BuilderInterface
    {
        return current($this->container);
    }
}
