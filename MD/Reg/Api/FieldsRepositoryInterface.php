<?php
namespace MD\Reg\Api;

interface FieldsRepositoryInterface
{
    public function save(\MD\Reg\Api\Data\FieldsInterface $fields);

    public function getById($fieldId);

    public function delete(\MD\Reg\Api\Data\FieldsInterface $fields);

    public function deleteById($fieldId);
}

