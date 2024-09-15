<?php

declare(strict_types=1);

namespace Soap\Engine\Metadata\Model;

final class Parameter
{
    private string $name;
    private XsdType $type;

    public function __construct(string $name, XsdType $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): XsdType
    {
        return $this->type;
    }
}
