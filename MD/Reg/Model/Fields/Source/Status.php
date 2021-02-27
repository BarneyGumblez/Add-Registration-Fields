<?php

namespace MD\Reg\Model\Fields\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    protected $fields;

    public function __construct(\MD\Reg\Model\Fields $fields)
    {
        $this->fields = $fields;
    }

    public function toOptionArray()
    {
        $availableOptions = $this->fields->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}

