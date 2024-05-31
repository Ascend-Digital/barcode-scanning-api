<?php

namespace Domain\Barcodes\Contracts;

interface ScannableModel
{
    public function getCompanyId(): int;

    //    public function availableActions();
}
