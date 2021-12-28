<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Iterator;
use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\GetSimpleChildClassName;
use Wefabric\GS1InsbouOrderConverter\Validatable;

abstract class BaseList extends DataTransferObject implements Iterator, Validatable
{
    /* @var Validatable[] $values */
    protected array $values;
    protected int $index;

    abstract public function minAmount(): int;
    abstract public function maxAmount(): int;

    public function __construct(array $data = [])
    {
        $this->values = [];
        $this->index = 0;

        parent::__construct($data);
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

        /* @var DataTransferObject $value */
        foreach($this->values as $value){
            $return[] = $value->toArray(); //adds this element to END of $return.
        }

        return $return;
    }

    /**
     * Method to add an object to the end of the array.
     * @param mixed $object
     * @return void
     */
    public function add(mixed $object)
    {
        $this->values[count($this->values)] = $object;
    }

    /**
     * @return bool indicating whether the object is Valid (true) or invalid (false) based on the information inside the object.
     * Calls getErrorMessages() and checks if the response is empty or not.
     */
    public function isValid() : bool
    {
        return !(bool) self::getErrorMessages();
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

        /* @var Validatable $value */
        foreach($this->values as $value){
            $innerErrorMessage .= $value->getErrorMessages();
            if(! empty($innerErrorMessage)){
                $errorMessage .= $className . '[' . $this->index . '] is invalid.' . '\n' . $innerErrorMessage . '\n';
            }
        }

        return $errorMessage;
    }

}