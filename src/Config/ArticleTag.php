<?php

declare(strict_types=1);

namespace App\Config;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum ArticleTag: string implements TranslatableInterface
{
    case Cosearching = 'cosearching';
    case Event = 'event';
    case Promo = 'promo';

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return $translator->trans($this->name, locale: $locale);
    }

    public function color(): string
    {
        return match ($this) {
            self::Cosearching => 'bg-navy-900',
            self::Event => 'bg-brand-orange',
            self::Promo => 'bg-navy-900',
            // default => ''
        };
    }
}
