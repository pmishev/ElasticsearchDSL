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
namespace ONGR\ElasticsearchDSL\Serializer;

use ONGR\ElasticsearchDSL\Serializer\Normalizer\OrderedNormalizerInterface;
use Symfony\Component\Serializer\Serializer;

/**
 * Custom serializer which orders data before normalization.
 */
class OrderedSerializer extends Serializer
{
    public function normalize(mixed $data, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        return parent::normalize(
            is_array($data) ? $this->order($data) : $data,
            $format,
            $context
        );
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        return parent::denormalize(
            is_array($data) ? $this->order($data) : $data,
            $type,
            $format,
            $context
        );
    }

    /**
     * Orders objects if can be done.
     *
     * @param array $data Data to order.
     *
     */
    private function order(array $data): array
    {
        $filteredData = $this->filterOrderable($data);

        if ($filteredData !== []) {
            uasort(
                $filteredData,
                fn (OrderedNormalizerInterface $a, OrderedNormalizerInterface $b): int => $a->getOrder() <=> $b->getOrder()
            );

            return array_merge($filteredData, array_diff_key($data, $filteredData));
        }

        return $data;
    }

    /**
     * Filters out data which can be ordered.
     *
     * @param array $array Data to filter out.
     *
     */
    private function filterOrderable(array $array): array
    {
        return array_filter(
            $array,
            fn ($value): bool => $value instanceof OrderedNormalizerInterface
        );
    }
}
