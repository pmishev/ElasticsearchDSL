# ElasticsearchDSL

Elasticsearch DSL library to provide objective query builder for the [elasticsearch-php](https://github.com/elastic/elasticsearch-php) client. 
You can easily build any Elasticsearch query and transform it to an array.

This is a fork of the abandoned https://github.com/ongr-io/ElasticsearchDSL

[![Tests](https://github.com/pmishev/elasticsearch-dsl-php/actions/workflows/phpunit.yml/badge.svg)](https://github.com/pmishev/elasticsearch-dsl-php/actions/workflows/phpunit.yml)
[![Coverage Status](https://coveralls.io/repos/github/pmishev/elasticsearch-dsl-php/badge.svg?branch=9.0)](https://coveralls.io/github/pmishev/elasticsearch-dsl-php?branch=8.0)
[![Latest Stable Version](http://poser.pugx.org/pmishev/elasticsearch-dsl-php/v)](https://packagist.org/packages/pmishev/elasticsearch-dsl-php)
[![PHP Version Require](http://poser.pugx.org/pmishev/elasticsearch-dsl-php/require/php)](https://packagist.org/packages/pmishev/elasticsearch-dsl-php)

## Requirements

- PHP `^8.3`
- `symfony/serializer` `^6.4 || ^7.0 || ^8.0` (Symfony 6.4 LTS, 7.x and 8.x)

## Version matrix

| Elasticsearch version | Bundle version |
|-----------------------|----------------|
| >= 9.0                | >= 9.0         |
| >= 8.0, < 9.0         | >= 8.0         |
| >= 7.0, < 8.0         | >= 7.0         |
| >= 6.0, < 7.0         | >= 6.0         |
| >= 5.0, < 6.0         | >= 5.0         |

## Documentation

[The online documentation of the bundle is here](docs/index.md)

## Try it!

### Installation

```bash
$ composer require pmishev/elasticsearch-dsl-php ^9.0
```

### Example usage

```php
 <?php
    require 'vendor/autoload.php'; // Composer autoload

    use Elasticsearch\ClientBuilder;
    use ONGR\ElasticsearchDSL\Query\MatchAllQuery;
    use ONGR\ElasticsearchDSL\Search;

    // Build an elasticsearch-php client
    $clientBuilder = ClientBuilder::create();
    $clientBuilder->setHosts(['localhost:9200']);
    $client = $clientBuilder->build();
    
    $search = (new Search())->addQuery(new MatchAllQuery());
    
    $params = [
        'index' => 'your_index',
        'body'  => $search->toArray(),
    ];
    
    $results = $client->search($params);
```
