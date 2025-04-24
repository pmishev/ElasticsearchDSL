<?php

declare(strict_types=1);

namespace ONGR\ElasticsearchDSL\Query\Joining;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-parent-id-query.html
 */
class ParentIdQuery implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @param string $parentId
     */
    public function __construct(private $parentId, private string $childType, array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'parent_id';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $query = [
            'id'   => $this->parentId,
            'type' => $this->childType,
        ];
        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }
}
