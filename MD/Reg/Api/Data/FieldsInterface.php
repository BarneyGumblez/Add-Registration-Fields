<?php
namespace MD\Reg\Api\Data;

interface FieldsInterface
{
    const FIELD_ID = 'field_id';
    const NAME = 'name';
    const TYPE = 'type';
    const OPTIONS = 'options';
    const STATUS = 'status';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function getId();

    public function getName();

    public function getType();

    public function getOptions();

    public function getStatus();

    public function getCreatedAt();

    public function getUpdatedAt();

    public function setId($id);

    public function setName($name);

    public function setType($type);

    public function setOptions($options);

    public function setStatus($status);

    public function setCreatedAt($created_at);

    public function setUpdatedAt($updated_at);
}

