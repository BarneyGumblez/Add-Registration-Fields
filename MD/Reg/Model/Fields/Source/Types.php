<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace MD\Reg\Model\Fields\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Types extends AbstractSource
{
    /**
     * Retrieve option array
     *
     * @return array
     */
    public function getAllOptions()
    {
        return [
            ['value' => 'text', 'label' => __('Text')],
            ['value' => 'select', 'label' => __('Select element (only one value can be selected)')],
            ['value' => 'checkbox', 'label' => __('Checkbox (multiple values ​​can be selected)')],
            ['value' => 'input', 'label' => __('Input')]
        ];
    }
}
