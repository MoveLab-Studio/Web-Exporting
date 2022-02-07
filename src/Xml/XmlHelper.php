<?php

namespace MlsExporting\Xml;

use DOMDocument;
use DOMNode;
use DOMText;

/**
 * @public
 */
class XmlHelper
{
    /**
     * Transform an array into a DOMDocument
     *
     * @param XmlSerializable $xmlSerializable Array with data
     * @return string
     * @throws XmlException
     */
    public static function fromSerializable(XmlSerializable $xmlSerializable): string
    {
        $input = self::prepare($xmlSerializable);
        $dom = new DOMDocument('1.0', 'UTF-8');
        self::handle($dom, $dom, $input);

        $xml = $dom->saveXML();
        if ($xml === false) {
            throw new XmlException('Error converting to XML');
        }

        return $xml;
    }

    /**
     * @param mixed|XmlSerializable $input
     * @return mixed
     */
    private static function prepare(mixed $input): mixed
    {
        if ($input instanceof XmlSerializable) {
            $input = $input->toXml();
        }

        if (is_array($input)) {
            foreach ($input as $key => &$item) {
                if ($item instanceof XmlSerializable || is_array($item)) {
                    $input[$key] = self::prepare($item);
                }
            }
        }

        return $input;
    }

    /**
     * @param DOMDocument $dom
     * @param DOMNode $node
     * @param mixed $data
     * @throws XmlException
     */
    protected static function handle(DOMDocument $dom, DOMNode $node, mixed &$data): void
    {
        if (empty($data) || !is_array($data)) {
            return;
        }
        foreach ($data as $key => $value) {
            if (!is_string($key)) {
                throw new XmlException('Invalid array');
            }

            if (!is_array($value)) {
                $value = self::normalizeValue($value);
                if (self::isNamespace($key) !== false) {
                    /**
                     * @phpstan-ignore-next-line
                     */
                    $node->setAttributeNS('http://www.w3.org/2000/xmlns/', $key, $value);
                } else {
                    if (self::isKeyForAttribute($key)) {
                        self::appendAttribute($dom, $node, $key, $value);
                    } else {
                        self::appendChild($dom, $node, $value, $key);
                    }
                }
            } else {
                if (self::isKeyForAttribute($key)) {
                    throw new XmlException('Invalid array');
                }
                if (is_numeric(implode('', array_keys($value)))) {
                    foreach ($value as $item) {
                        self::handleChild($dom, $node, $key, $item);
                    }
                } else {
                    self::handleChild($dom, $node, $key, $value);
                }
            }
        }
    }

    protected static function handleChild(DOMDocument $dom, DOMNode $node, string $key, mixed $value): void
    {
        $childNS = null;
        $childValue = null;

        if (is_array($value)) {
            if (isset($value['@'])) {
                $childValue = (string)$value['@'];
                unset($value['@']);
            }
            if (isset($value['xmlns:'])) {
                $childNS = $value['xmlns:'];
                unset($value['xmlns:']);
            }
        } elseif (!empty($value) || $value === 0) {
            /**
             * @phpstan-ignore-next-line
             */
            $childValue = (string)$value;
        }

        $child = $dom->createElement($key);
        if ($childValue !== null) {
            $child->appendChild($dom->createTextNode($childValue));
        }
        if ($childNS) {
            $child->setAttribute('xmlns', $childNS);
        }

        self::handle($dom, $child, $value);
        $node->appendChild($child);
    }

    protected static function appendAttribute(DOMDocument $dom, DOMNode $node, string $key, mixed $value): string
    {
        $key = substr($key, 1);
        $attribute = $dom->createAttribute($key);
        /**
         * @phpstan-ignore-next-line
         */
        $attribute->appendChild($dom->createTextNode($value));
        $node->appendChild($attribute);

        return $key;
    }

    protected static function appendChild(DOMDocument $dom, DOMNode $node, mixed $value, string $key): void
    {
        if (!is_numeric($value)) {
            $child = $dom->createElement($key, '');
            /**
             * @phpstan-ignore-next-line
             */
            $child->appendChild(new DOMText($value));
        } else {
            /**
             * @phpstan-ignore-next-line
             */
            $child = $dom->createElement($key, $value);
        }
        $node->appendChild($child);
    }

    protected static function isNamespace(string $key): bool
    {
        return str_contains($key, 'xmlns:');
    }

    protected static function normalizeValue(mixed $value): mixed
    {
        if (is_bool($value)) {
            $value = (int)$value;
        } elseif ($value === null) {
            $value = '';
        }

        return $value;
    }

    protected static function isKeyForAttribute(string $key): bool
    {
        return $key[0] === '@';
    }
}
