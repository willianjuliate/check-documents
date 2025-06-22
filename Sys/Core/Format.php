<?php

namespace Sys\Core;

/**
 * Classe abstrata para responsavel por limpar a formatacao do documento
 * Todas classes como CNPJ e CPF Herdam-as e implementa o seu metodo fmt_document
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

