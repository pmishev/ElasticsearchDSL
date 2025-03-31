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

    private ?BuilderInterface $highlight = null;

    /**
     * @var string Key for highlight storing.
     */
    private $key;

    /**
     * {@inheritdoc}
     */
    public function normalize(NormalizerInterface $normalizer, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        if ($this->highlight instanceof BuilderInterface) {
            return $this->highlight->toArray();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function add(BuilderInterface $builder, $key = null): void
    {
        if ($this->highlight instanceof BuilderInterface) {
            throw new \OverflowException('Only one highlight can be set');
        }

        $this->key = $key;
        $this->highlight = $builder;
    }

    /**
     * {@inheritdoc}
     */
    public function getAll($boolType = null): array
    {
        return [$this->key => $this->highlight];
    }

    /**
     */
    public function getHighlight(): ?BuilderInterface
    {
        return $this->highlight;
    }
}
