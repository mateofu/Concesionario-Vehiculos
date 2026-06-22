<?php

declare(strict_types=1);

namespace App\Domain\Owner\ValueObjects;

enum DocumentType: string
{
    case CC         = 'CC';
    case CE         = 'CE';
    case NIT        = 'NIT';
    case PASAPORTE  = 'PASAPORTE';
    case TI         = 'TI';
}
