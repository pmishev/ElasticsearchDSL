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
namespace ONGR\ElasticsearchDSL\Aggregation\Pipeline;

/**
 * Class representing Min Bucket Pipeline Aggregation.
 *
 * @see https://goo.gl/5oo4XH
 */
class MinBucketAggregation extends AbstractPipelineAggregation
{
    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'min_bucket';
    }
}
