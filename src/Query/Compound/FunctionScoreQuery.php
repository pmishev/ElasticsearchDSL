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
 * Represents Elasticsearch "function_score" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-function-score-query.html
 */
class FunctionScoreQuery implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @var array[]
     */
    private ?array $functions = null;

    public function __construct(private BuilderInterface $query, array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    /**
     * Returns the query instance.
     *
     * @return BuilderInterface object
     */
    public function getQuery(): BuilderInterface
    {
        return $this->query;
    }

    /**
     * Creates field_value_factor function.
     *
     * @param string $field
     * @param float  $factor
     * @param string $modifier
     * @param mixed  $missing
     *
     * @return $this
     */
    public function addFieldValueFactorFunction(
        $field,
        $factor,
        $modifier = 'none',
        ?BuilderInterface $query = null,
        $missing = null,
    ): static {
        $function = [
            'field_value_factor' => array_filter([
                'field'    => $field,
                'factor'   => $factor,
                'modifier' => $modifier,
                'missing'  => $missing,
            ]),
        ];

        $this->applyFilter($function, $query);

        $this->functions[] = $function;

        return $this;
    }

    /**
     * Modifier to apply filter to the function score function.
     */
    private function applyFilter(array &$function, ?BuilderInterface $query = null): void
    {
        if ($query instanceof BuilderInterface) {
            $function['filter'] = $query->toArray();
        }
    }

    /**
     * Add decay function to function score. Weight and query are optional.
     *
     * @param string $type
     * @param string $field
     * @param int    $weight
     *
     * @return $this
     */
    public function addDecayFunction(
        $type,
        $field,
        array $function,
        array $options = [],
        ?BuilderInterface $query = null,
        $weight = null,
    ): static {
        $function = array_filter(
            [
                $type => array_merge(
                    [$field => $function],
                    $options
                ),
                'weight' => $weight,
            ]
        );

        $this->applyFilter($function, $query);

        $this->functions[] = $function;

        return $this;
    }

    /**
     * Adds function to function score without decay function. Influence search score only for specific query.
     *
     * @param float $weight
     *
     * @return $this
     */
    public function addWeightFunction($weight, ?BuilderInterface $query = null): static
    {
        $function = [
            'weight' => $weight,
        ];

        $this->applyFilter($function, $query);

        $this->functions[] = $function;

        return $this;
    }

    /**
     * Adds random score function. Seed is optional.
     *
     * @param mixed $seed
     *
     * @return $this
     */
    public function addRandomFunction($seed = null, ?BuilderInterface $query = null): static
    {
        $function = [
            'random_score' => $seed ? ['seed' => $seed] : new \stdClass(),
        ];

        $this->applyFilter($function, $query);

        $this->functions[] = $function;

        return $this;
    }

    /**
     * Adds script score function.
     *
     * @param string $source
     *
     * @return $this
     */
    public function addScriptScoreFunction(
        $source,
        array $params = [],
        array $options = [],
        ?BuilderInterface $query = null,
    ): static {
        $function = [
            'script_score' => [
                'script' => array_filter(
                    array_merge(
                        [
                            'lang'   => 'painless',
                            'source' => $source,
                            'params' => $params,
                        ],
                        $options
                    )
                ),
            ],
        ];

        $this->applyFilter($function, $query);
        $this->functions[] = $function;

        return $this;
    }

    /**
     * Adds custom simple function. You can add to the array whatever you want.
     *
     * @return $this
     */
    public function addSimpleFunction(array $function): static
    {
        $this->functions[] = $function;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $query = [
            'query'     => $this->query->toArray(),
            'functions' => $this->functions,
        ];

        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'function_score';
    }
}
