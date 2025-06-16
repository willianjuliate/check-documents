<?php

namespace Sys\Core\Br;

use Sys\Core\Format;

/**
 * Description of CNPJ
 *
 * @author willian juliate
 */
class CNPJ extends Format
{

    public function isValid(): bool
    {
        $sum = 0;

        if (strlen($this->document) != 14 || preg_match('/^(\\d)\\1{13}$/', $this->document)) {
            return false;
        }

        $first_num = 5;
        for ($i = 0, $sum = 0; $i < 12; $i++) {
            $sum += $this->document[$i] * $first_num;
            $first_num = ($first_num == 2) ? 9 : $first_num - 1;
        }

        $first_digit = $sum % 11;
        if ($this->document[12] != ($first_digit < 2 ? 0 : 11 - $first_digit)) {
            return false;
        }

        $second_num = 6;
        for ($i = 0, $sum = 0; $i < 13; $i++) {
            $sum += $this->document[$i] * $second_num;
            $second_num = ($second_num == 2) ? 9 : $second_num - 1;
        }

        $second_digit = $sum % 11;
        return $this->document[13] == ($second_digit < 2 ? 0 : 11 - $second_digit);
    }

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

        $fmt = substr($this->document, 0, 2) . '.';
        $fmt .= substr($this->document, 2, 3) . '.';
        $fmt .= substr($this->document, 5, 3) . '/';
        $fmt .= substr($this->document, 8, 4) . '-';
        $fmt .= substr($this->document, 12, 2) . '';

        return $fmt;
    }
}
