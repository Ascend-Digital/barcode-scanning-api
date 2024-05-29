<?php

namespace Domain\Barcodes\Enums;

enum BarcodeType: string
{
    case C39 = 'C39';
    case QRCODE = 'QRCODE';
}
