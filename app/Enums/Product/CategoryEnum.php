<?php
namespace App\Enums\Product;

use App\Traits\EnumsWithOptions;

enum CategoryEnum: string {

    use EnumsWithOptions;

    case ELECTRONICS     = "Electronics";
    case ACCESSORIES     = "Accessories";
    case FITNESS         = "Fitness";
    case SPORTSWEAR      = "Sportswear";
    case FASHION         = "Fashion";
    case HOME_APPLIANCES = "Home Appliances";
}
