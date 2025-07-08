<?php  
namespace App\Filament\Enums;

enum ProductType: string
{
    case PERFUME = 'perfume';
    case EAU_DE_TOILETTE = 'eau_de_toilette';
    case EAU_DE_PARFUM = 'eau_de_parfum';
    case COLOGNE = 'cologne';
    case BODY_SPRAY = 'body_spray';

    public function getLabel(): string
    {
        return match($this) {
            self::PERFUME => 'Perfume',
            self::EAU_DE_TOILETTE => 'Eau de Toilette',
            self::EAU_DE_PARFUM => 'Eau de Parfum',
            self::COLOGNE => 'Cologne',
            self::BODY_SPRAY => 'Body Spray',
        };
    }
}
