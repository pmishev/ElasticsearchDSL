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
namespace ONGR\ElasticsearchDSL\Aggregation\Metric;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Type\MetricTrait;
use ONGR\ElasticsearchDSL\ScriptAwareTrait;

/**
 * Class representing PercentilesAggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-percentile-aggregation.html
 */
class PercentilesAggregation extends AbstractAggregation
{
    use MetricTrait;
    use ScriptAwareTrait;

    /**
     * @var array
     */
    private $percents;

    /**
     * @var int
     */
    private $compression;

    /**
     * Inner aggregations container init.
     *
     * @param string $name
     * @param string $field
     * @param array  $percents
     * @param string $script
     * @param int    $compression
     */
    public function __construct($name, $field = null, $percents = null, $script = null, $compression = null)
    {
        parent::__construct($name);

        $this->setField($field);
        $this->setPercents($percents);
        $this->setScript($script);
        $this->setCompression($compression);
    }

    /**
     * @return array
     */
    public function getPercents()
    {
        return $this->percents;
    }

    /**
     * @param array $percents
     *
     * @return $this
     */
    public function setPercents($percents): static
    {
        $this->percents = $percents;

        return $this;
    }

    /**
     * @return int
     */
    public function getCompression()
    {
        return $this->compression;
    }

    /**
     * @param int $compression
     *
     * @return $this
     */
    public function setCompression($compression): static
    {
        $this->compression = $compression;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'percentiles';
    }

    /**
     * {@inheritdoc}
     * @return mixed[]
     */
    public function getArray(): array
    {
        $out = array_filter(
            [
                'compression' => $this->getCompression(),
                'percents'    => $this->getPercents(),
                'field'       => $this->getField(),
                'script'      => $this->getScript(),
            ],
            fn ($val): bool => $val || is_numeric($val)
        );

        $this->isRequiredParametersSet($out);

        return $out;
    }

    /**
     *
     * @throws \LogicException
     */
    private function isRequiredParametersSet(array $a): void
    {
        if (!array_key_exists('field', $a) && !array_key_exists('script', $a)) {
            throw new \LogicException('Percentiles aggregation must have field or script set.');
        }
    }
}
