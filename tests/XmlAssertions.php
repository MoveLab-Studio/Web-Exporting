<?php

namespace Tests;

trait XmlAssertions
{

    public function assertXmlSchema(string $input, string $schema): void
    {
        libxml_use_internal_errors(true);

        $xml = new \DOMDocument();
        $xml->loadXML($input);

        if (!$xml->schemaValidate($schema)) {
            $errors = libxml_get_errors();
            $messages = [];
            foreach ($errors as $error) {
                $messages[] = $error->message;
            }
            libxml_clear_errors();
            libxml_use_internal_errors();
            throw new \PHPUnit\Framework\ExpectationFailedException(implode(', ', $messages));
        }
        libxml_use_internal_errors();
    }

}