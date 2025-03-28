<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Aggregation\Matrix;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Type\MetricTrait;

/**
 * Class representing Max Aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-max-aggregation.html
 */
class MaxAggregation extends AbstractAggregation
{
    use MetricTrait;

    /**
     * @var string Used for multi value aggregation fields to pick a value.
     */
    private $mode;

    /**
     * Inner aggregations container init.
     *
     * @param string $name
     * @param string|array $field Fields list to aggregate.
     * @param array $missing Defines how documents that are missing a value should be treated.
     * @param string $mode
     */
    public function __construct($name, $field, private $missing = null, $mode = null)
    {
        parent::__construct($name);

        $this->setField($field);
        $this->setMode($mode);
    }

    /**
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param string $mode
     *
     * @return $this
     */
    public function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * @return array
     */
    public function getMissing()
    {
        return $this->missing;
    }

    /**
     * @param array $missing
     *
     * @return $this
     */
    public function setMissing($missing)
    {
        $this->missing = $missing;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'matrix_stats';
    }

    protected function getArray()
    {
        $out = [];
        if ($this->getField()) {
            $out['fields'] = $this->getField();
        }

        if ($this->getMode()) {
            $out['mode'] = $this->getMode();
        }


        if ($this->getMissing()) {
            $out['missing'] = $this->getMissing();
        }

        return $out;
    }
}
