<?php

declare(strict_types=1);

namespace App\Enum;

use Elao\Enum\Enum;

class CountryCodeEnum extends Enum
{
    public const AT = 'AT';
    public const BE = 'BE';
    public const BG = 'BG';
    public const CY = 'CY';
    public const CZ = 'CZ';
    public const DE = 'DE';
    public const DK = 'DK';
    public const EE = 'EE';
    public const ES = 'ES';
    public const FI = 'FI';
    public const FR = 'FR';
    public const GR = 'GR';
    public const HR = 'HR';
    public const HU = 'HU';
    public const IE = 'IE';
    public const IT = 'IT';
    public const LT = 'LT';
    public const LU = 'LU';
    public const LV = 'LV';
    public const MT = 'MT';
    public const NL = 'NL';
    public const PO = 'PO';
    public const PT = 'PT';
    public const RO = 'RO';
    public const SE = 'SE';
    public const SI = 'SI';
    public const SK = 'SK';

    public static function values(): array
    {
        return [
            self::AT,
            self::BE,
            self::BG,
            self::CY,
            self::CZ,
            self::DE,
            self::DK,
            self::EE,
            self::ES,
            self::FI,
            self::FR,
            self::GR,
            self::HR,
            self::HU,
            self::IE,
            self::IT,
            self::LT,
            self::LU,
            self::LV,
            self::MT,
            self::NL,
            self::PO,
            self::PT,
            self::RO,
            self::SE,
            self::SI,
            self::SK,
        ];
    }
}
