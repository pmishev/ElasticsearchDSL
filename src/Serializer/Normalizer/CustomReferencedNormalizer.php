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
namespace ONGR\ElasticsearchDSL\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\CustomNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Normalizer used with referenced normalized objects.
 */
class CustomReferencedNormalizer implements NormalizerInterface, SerializerAwareInterface
{
    use SerializerAwareTrait;

    private array $references = [];

    private CustomNormalizer $inner;

    public function __construct()
    {
        $this->inner = new CustomNormalizer();
    }

    public function setSerializer(SerializerInterface $serializer): void
    {
        $this->serializer = $serializer;
        $this->inner->setSerializer($this->serializer);
    }

    public function supportsNormalization(mixed $data, ?string $format = null /* , array $context = [] */): bool
    {
        return $data instanceof AbstractNormalizable;
    }

    public function normalize(mixed $object, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        $object->setReferences($this->references);
        $data = $this->inner->normalize($object, $format, $context);
        $this->references = array_merge($this->references, $object->getReferences());

        return $data;
    }
}
