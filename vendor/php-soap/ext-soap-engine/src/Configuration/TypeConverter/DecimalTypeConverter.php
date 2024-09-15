<?php declare(strict_types=1);

namespace Soap\ExtSoapEngine\Configuration\TypeConverter;

use DOMDocument;

/**
 * Class DecimalTypeConverter
 *
 * Convert between PHP float and Soap decimal objects
 */
final class DecimalTypeConverter implements TypeConverterInterface
{
    public function getTypeNamespace(): string
    {
        return 'http://www.w3.org/2001/XMLSchema';
    }

    public function getTypeName(): string
    {
        return 'decimal';
    }

    /**
     * @param non-empty-string $xml
     */
    public function convertXmlToPhp(string $xml)
    {
        $doc = new DOMDocument();
        $doc->loadXML($xml);

        if ('' === $doc->textContent) {
            return null;
        }

        return (float) $doc->textContent;
    }

    public function convertPhpToXml($php): string
    {
        return sprintf('<%1$s>%2$s</%1$s>', $this->getTypeName(), $php);
    }
}
