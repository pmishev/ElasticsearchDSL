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
namespace ONGR\ElasticsearchDSL\Query\Specialized;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "template" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-template-query.html
 */
class TemplateQuery implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @var string
     */
    private $file;

    /**
     * @var string
     */
    private $inline;

    /**
     * @var array
     */
    private $params;

    /**
     * @param string $file   A template of the query
     * @param string $inline A template of the query
     * @param array  $params Parameters to insert into template
     */
    public function __construct($file = null, $inline = null, array $params = [])
    {
        $this->setFile($file);
        $this->setInline($inline);
        $this->setParams($params);
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $file
     */
    public function setFile($file): static
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return string
     */
    public function getInline()
    {
        return $this->inline;
    }

    /**
     * @param string $inline
     *
     * @return $this
     */
    public function setInline($inline): static
    {
        $this->inline = $inline;

        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param array $params
     *
     * @return $this
     */
    public function setParams($params): static
    {
        $this->params = $params;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'template';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $output = array_filter(
            [
                'file'   => $this->getFile(),
                'inline' => $this->getInline(),
                'params' => $this->getParams(),
            ]
        );

        if (!isset($output['file']) && !isset($output['inline'])) {
            throw new \InvalidArgumentException('Template query requires that either `inline` or `file` parameters are set');
        }

        $output = $this->processArray($output);

        return [$this->getType() => $output];
    }
}
