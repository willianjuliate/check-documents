<?php

namespace Sys\Core\Br;

use Sys\Core\Format;

/**
 * Classe CPF responsável por calcular e formatar o documento informado
 * @author willian
 */
class CPF extends Format
{
    /**
     * Função que valida o documento informado
     * @return bool
     */
    public function isValid(): bool
    {
        if (strlen($this->document) != 11 || preg_match('/^(\\d)\\1{10}$/', $this->document)) {
            return false;
        }

        for ($i = 0, $j = 10, $sum = 0; $i < 9; $i++, $j--) {
            $sum += $this->document[$i] * $j;
        }

        $first_digit = $sum % 11;

        if ($this->document[9] != ($first_digit < 2 ? 0 : 11 - $first_digit)) {
            return false;
        }

        for ($i = 0, $j = 11, $sum = 0; $i < 10; $i++, $j--) {
            $sum += $this->document[$i] * $j;
        }

        $second_digit = $sum % 11;

        return $this->document[10] == ($second_digit < 2 ? 0 : 11 - $second_digit);
    }

    /**
     * Retorna o documento formatado ex: 60442979002 -> 604.429.790-02
     * @return string
     */
    public function getFmtDocument(): string
    {
        return $this->fmt_document();
    }

    public function __toString(): string
    {
        return $this->fmt_document();
    }

    #[\Override]
    protected function fmt_document(): string
    {
        if (!$this->isValid()) {
            throw new \ErrorException('Invalid documents.');
        }

        $fmt = substr($this->document, 0, 3) . '.';
        $fmt .= substr($this->document, 3, 3) . '.';
        $fmt .= substr($this->document, 6, 3) . '-';
        $fmt .= substr($this->document, 9, 2) . '';

        return $fmt;
    }
}
