<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Larium\Shop\Store;

use Larium\Shop\Sale\OrderableInterface;
use Larium\Shop\Common\Collection;
use Larium\Shop\Common\CollectionInterface;

/**
 * Variant
 *
 * @uses OrderableInterface
 * @author  Andreas Kollaros <andreaskollaros@ymail.com>
 * @license MIT {@link http://opensource.org/licenses/mit-license.php}
 */
class Variant implements OrderableInterface
{
    /**
     * The unique sku description.
     *
     * @var string
     * @access protected
     */
    protected $sku;

    /**
     * unit_price
     *
     * @var Money\Money
     * @access protected
     */
    protected $unit_price;

    /**
     * stock_units
     *
     * @var integer
     * @access protected
     */
    protected $stock_units;

    /**
     * is_default
     *
     * @var boolean
     * @access protected
     */
    protected $is_default;

    /**
     * product
     *
     * @var Larium\Shop\Store\Product
     * @access protected
     */
    protected $product;

    /**
     * option_values
     *
     * @var Larium\Shop\Common\Collection
     * @access protected
     */
    protected $option_values;

    /**
     * option_types
     *
     * @var Larium\Shop\Common\Collection
     * @access protected
     */
    protected $option_types;

    public function __construct()
    {
        $this->initialize();
    }

    public function initialize()
    {
        $this->option_values = new Collection(
            array(),
            'Larium\\Shop\\Store\\OptionValue'
        );

        $this->option_types = new Collection(
            array(),
            'Larium\\Shop\\Store\\OptionType'
        );
    }

    /**
     * Checks if current variant is the default one.
     *
     * @return boolean
     */
    public function isDefault()
    {
        return $this->is_default;
    }

    /**
     * Sets if the current variant is the default or not.
     *
     * @param boolean $value
     * @return void
     */
    public function setDefault($value = true)
    {
        $this->is_default = $value;
    }

    public function setIsDefault($value)
    {
        $this->setDefault($value);
    }

    /**
     * {@inheritdoc}
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Sets sku value.
     *
     * @param string $sku
     * @return void
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->getSku() . " - " . $this->getProduct()->getTitle();
    }

    /**
     * {@inheritdoc}
     */
    public function getUnitPrice()
    {
        return $this->unit_price;
    }

    /**
     * Sets unit price.
     *
     * @param float|integer $unit_price
     */
    public function setUnitPrice($unit_price)
    {
        $this->unit_price = $unit_price;
    }

    /**
     * Gets the number of stock units.
     *
     * @return integer
     */
    public function getStockUnits()
    {
        return $this->stock_units;
    }

    /**
     * Sets the number of  stock units.
     *
     * @param integer $stock_units
     * @return void
     */
    public function setStockUnits($stock_units)
    {
        $this->stock_units = $stock_units;
    }

    /**
     * Gets the product of variant.
     *
     * @return Larium\Shop\Store\Product.
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Sets the product for variant.
     *
     * @param Larium\Shop\Store\Product $product The product to set.
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Gets option_values.
     *
     * @access public
     * @return mixed
     */
    public function getOptionValues()
    {
        return $this->option_values;
    }

    /**
     * Sets option_values.
     *
     * @param CollectionInterface $option_values the value to set.
     * @access public
     * @return void
     */
    public function setOptionValues(CollectionInterface $option_values)
    {
        $this->option_values = $option_values;
    }

    /**
     * Adds an OptionValue element to Variant.
     *
     * @param OptionValue $option_value
     * @access public
     * @return void
     */
    public function addOptionValue(OptionValue $option_value)
    {
        $contains = $this->option_values->contains(
            $option_value,
            function($element) use ($option_value) {
                return $option_value->getName() == $element->getName();
            }
        );

        if (false === $contains) {
            $this->option_values->append($option_value);
        }
    }

    /**
     * Removes an OptionValue element from Variant.
     *
     * @param OptionValue $option_value
     * @access public
     * @return void
     */
    public function removeOptionValue(OptionValue $option_value)
    {
        return $this->option_values->remove(
            $option_value,
            function ($var) use ($option_value) {
                return $var->getName() == $option_value->getName();
            }
        );
    }

    /**
     * Gets option_types.
     *
     * @access public
     * @return mixed
     */
    public function getOptionTypes()
    {
        return $this->option_types;
    }

    /**
     * Sets option_types.
     *
     * @param CollectionInterface $option_types the value to set.
     * @access public
     * @return void
     */
    public function setOptionTypes(CollectionInterface $option_types)
    {
        $this->option_types = $option_types;
    }

    public function addOptionType(OptionType $option_type)
    {
        $this->option_types->append($option_type);
    }

    /**
     * Removes an OptionType element from Collection.
     *
     * @param OptionType $option_type
     * @access public
     * @return void
     */
    public function removeOptionType(OptionType $option_type)
    {
        return $this->option_types->remove(
            $option_type,
            function ($var) use ($option_type) {
                return $var->getName() == $option_type->getName();
            }
        );
    }
}
