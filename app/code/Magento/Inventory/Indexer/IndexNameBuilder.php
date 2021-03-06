<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Inventory\Indexer;

/**
 * Index Name builder. It is Facade for simplifying IndexName object creation
 * @api
 */
class IndexNameBuilder
{
    /**
     * Index id parameter name. Used internally in this object
     *
     * Can not replace on private constant (feature of PHP 7.1) because we need to support PHP 7.0
     */
    private static $indexId = 'indexId';

    /**
     * Dimensions parameter name. Used internally in this object
     *
     * Can not replace on private constant (feature of PHP 7.1) because we need to support PHP 7.0
     */
    private static $dimensions = 'dimensions';

    /**
     * Alias parameter name. Used internally in this object
     *
     * Can not replace on private constant (feature of PHP 7.1) because we need to support PHP 7.0
     */
    private static $alias = 'alias';

    /**
     * @var IndexNameFactory
     */
    private $indexNameFactory;

    /**
     * @var DimensionFactory
     */
    private $dimensionFactory;

    /**
     * @var AliasFactory
     */
    private $aliasFactory;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @param IndexNameFactory $indexNameFactory
     * @param AliasFactory $aliasFactory
     * @param IndexNameFactory $indexNameFactory
     */
    public function __construct(
        IndexNameFactory $indexNameFactory,
        DimensionFactory $dimensionFactory,
        AliasFactory $aliasFactory
    ) {
        $this->indexNameFactory = $indexNameFactory;
        $this->dimensionFactory = $dimensionFactory;
        $this->aliasFactory = $aliasFactory;
    }

    /**
     * @param string $indexId
     * @return self
     */
    public function setIndexId(string $indexId): self
    {
        $this->data[self::$indexId] = $indexId;
        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @return IndexNameBuilder
     */
    public function addDimension(string $name, string $value): self
    {
        $this->data[self::$dimensions][] = $this->dimensionFactory->create([
            'name' => $name,
            'value' => $value,
        ]);
        return $this;
    }

    /**
     * @param string $alias
     * @return self
     */
    public function setAlias(string $alias): self
    {
        $this->data[self::$alias] = $this->aliasFactory->create(['value' => $alias]);
        return $this;
    }

    /**
     * @return IndexName
     */
    public function create()
    {
        $indexName = $this->indexNameFactory->create($this->data);
        $this->data = [];
        return $indexName;
    }
}
