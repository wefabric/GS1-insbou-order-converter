<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Iterator;
use RuntimeException;
use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\GetSimpleChildClassName;
use Wefabric\GS1InsbouOrderConverter\IsValid;
use Wefabric\GS1InsbouOrderConverter\Validatable;

abstract class BaseList extends DataTransferObject implements Iterator, Validatable
{
    use IsValid;

    /* @var BaseItem[] $values */
    protected array $values;
    protected int $index;

    abstract public function minAmount(): int;
    abstract public function maxAmount(): int;

    public function __construct(array $data = [])
    {
        $this->values = [];
        $this->index = 0;

        parent::__construct([]); //doesn't need or use $data. Simply instantiate with an empty array.
    }

    /**
     * Checks if the supplied array is a nested array, or a single-level array. If the latter, returns it as nested array.
     * This is due to the SimpleXML parser parsing objects that occur once as an element, and those that appear twice or more, as an array of elements.
     * And we can't specify to parse certain elements as elements and others as arrays.
     * @param array $data
     * @return array
     */
    protected static function CheckAndCorrectArrayDepth(array $data): array
    {
        if(count($data) > 0 && ! is_array($data[array_key_first($data)])) {
            $data = [$data];
        }
        return $data;
    }

    /**
     * Return the current element
     * @link https://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current(): mixed
    {
        if($this->valid()) {
            return $this->values[$this->index];
        }
        return false;
    }

    /**
     * Move forward to next element
     * @link https://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next(): void
    {
       $this->index++;
    }

    /**
     * Return the key of the current element
     * @link https://php.net/manual/en/iterator.key.php
     * @return int|null scalar on success, or null on failure.
     */
    public function key(): int|null
    {
        if($this->valid()) {
            return $this->index;
        }
        return null;
    }

    /**
     * Checks if current position is valid
     * @link https://php.net/manual/en/iterator.valid.php
     * @return bool The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid(): bool
    {
        return (0 <= $this->index && $this->index < count($this->values));
    } //Zero-based index

    /**
     * Rewind the Iterator to the first element
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind(): void
    {
        $this->index = 0;
    }

    public function toArray(): array
    {
        $return = [];

        foreach($this->values as $value){
            if(!$value instanceof BaseItem) {
                throw new RuntimeException('Type of object is '. gettype($value) . ', BaseItem expected!');
            }
            $return[] = $value->toArray(); //adds this element to END of $return.
        }

        return $return;
    }

    /**
     * @return int Size of the collection.
     */
    public function count(): int
    {
        return count($this->values);
    }

    /**
     * Method to add an object to the end of the array.
     * @param BaseItem $object
     * @return void
     */
    public function add(BaseItem $object)
    {
        $this->values[count($this->values)] = $object;
    }

    /**
     * @return string Human-readable errormessage(s) indicating the location of the invalid properties.
     */
    public function getErrorMessages() : string
    {
        $errorMessage = '';
        $innerErrorMessage = '';

        $className = GetSimpleChildClassName::from($this);

        if(count($this->values) < $this->minAmount() || count($this->values) >= $this->maxAmount()) {
            $errorMessage .= $className .' has an invalid amount of values (' . count($this->values) .'): must be between ' . $this->minAmount() .' and ' . $this->maxAmount() . '.' .'\n';
        }

        foreach($this->values as $value){
            if(!$value instanceof BaseItem) {
                throw new RuntimeException('Type of object '. $this->index .' is '. gettype($value) . ', BaseItem expected!');
            }

            $innerErrorMessage .= $value->getErrorMessages();
            if(! empty($innerErrorMessage)){
                $errorMessage .= $className . '[' . $this->index . '] is invalid.' . '\n' . $innerErrorMessage . '\n';
            }
        }

        return $errorMessage;
    }

    public function cutOffStrings()
    {
        foreach($this->values as $item) {
            $item->cutOffStrings();
        }
    }

}