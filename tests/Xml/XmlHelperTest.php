<?php

namespace Tests\Xml;

use MlsExporting\Xml\XmlHelper;
use MlsExporting\Xml\XmlSerializable;
use PHPUnit\Framework\TestCase;

class XmlHelperTest extends TestCase
{

    public function test_should_convert(): void
    {
        /* Given */
        $input = new Input();

        /* When */
        $result = XmlHelper::fromSerializable($input);

        /* Then */
        $this->assertXmlStringEqualsXmlString(<<<XML
<?xml version="1.0" encoding="UTF-8"?>\n
<root>
    <first>1</first>
    <second>
        <name>Piet</name>
    </second>
</root>
XML, $result);

    }

}

class Input implements XmlSerializable
{

    public function toXml(): mixed
    {
        return [
            'root' => [
                'first' => '1',
                'second' => new Child(),
            ]
        ];
    }
}

class Child implements XmlSerializable
{

    public function toXml(): mixed
    {
        return [
            'name' => 'Piet'
        ];
    }
}