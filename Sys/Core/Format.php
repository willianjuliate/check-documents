<?php

namespace Sys\Core;

/**
 * Description of BaseFormat
 *
 * @author willian
 */
abstract class Format
{
    protected string $document;

    public function __construct(string $document)
    {
        $this->document = $this->clean_document($document);        
    }

    private function clean_document(string $document): string
    {
        return preg_replace('/[^0-9]/', '', $document);
    }

    protected abstract function fmt_document(): string;
}

