<?php

namespace ColinHDev\CPlotAPI\flags;

abstract class BaseFlag implements FlagIDs {

    protected string $ID;
    protected string $category;
    protected string $valueType;
    protected string $description;

    /**
     * BaseFlag constructor.
     * @param string    $ID
     * @param array     $data
     */
    public function __construct(string $ID, array $data) {
        $this->ID = $ID;
        $this->category = $data["category"];
        $this->valueType = $data["type"];
        $this->description = $data["description"];
    }

    /**
     * @return string
     */
    public function getID() : string {
        return $this->ID;
    }

    /**
     * @return string
     */
    public function getCategory() : string {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getValueType() : string {
        return $this->valueType;
    }

    /**
     * @return string
     */
    public function getDescription() : string {
        return $this->description;
    }

    abstract public function getDefault() : mixed;

    abstract public function getValue() : mixed;
    abstract public function getValueNonNull() : mixed;
    abstract public function setValue(mixed $value) : void;

    abstract public function serializeValueType(mixed $data) : string;
    abstract public function unserializeValueType(string $serializedValue) : mixed;

    /**
     * @return array
     */
    public function __serialize() : array {
        return [
            "ID" => $this->ID,
            "category" => $this->category,
            "valueType" => $this->valueType,
            "description" => $this->description,
        ];
    }

    /**
     * @param array $data
     */
    public function __unserialize(array $data) : void {
        $this->ID = $data["ID"];
        $this->category = $data["category"];
        $this->valueType = $data["valueType"];
        $this->description = $data["description"];
    }
}