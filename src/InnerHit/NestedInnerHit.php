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
namespace ONGR\ElasticsearchDSL\InnerHit;

use ONGR\ElasticsearchDSL\NameAwareTrait;
use ONGR\ElasticsearchDSL\NamedBuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;
use ONGR\ElasticsearchDSL\Search;

/**
 * Represents Elasticsearch top level nested inner hits.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-request-inner-hits.html
 */
class NestedInnerHit implements NamedBuilderInterface
{
    use ParametersTrait;
    use NameAwareTrait;

    /**
     * @var string
     */
    private $path;

    private ?Search $search = null;

    /**
     * Inner hits container init.
     *
     * @param string $name
     * @param string $path
     */
    public function __construct($name, $path, ?Search $search = null)
    {
        $this->setName($name);
        $this->setPath($path);
        if ($search instanceof Search) {
            $this->setSearch($search);
        }
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     *
     * @return $this
     */
    public function setPath($path): static
    {
        $this->path = $path;

        return $this;
    }

    /**
     */
    public function getSearch(): ?Search
    {
        return $this->search;
    }

    /**
     * @return $this
     */
    public function setSearch(Search $search): static
    {
        $this->search = $search;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'nested';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $out = $this->getSearch() instanceof Search ? $this->getSearch()->toArray() : new \stdClass();

        return [
            $this->getPathType() => [
                $this->getPath() => $out,
            ],
        ];
    }

    /**
     * Returns 'path' for nested and 'type' for parent inner hits
     *
     */
    private function getPathType(): ?string
    {
        return match ($this->getType()) {
            'nested' => 'path',
            'parent' => 'type',
            default  => null,
        };
    }
}
