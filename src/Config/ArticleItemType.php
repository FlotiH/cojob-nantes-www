<?php

declare(strict_types=1);

namespace App\Config;

enum ArticleItemType: string
{
    case Promo = 'promo';
    case Article = 'article';

    public function route(): ?string
    {
        return match ($this) {
            self::Promo => 'promos',
            self::Article => null,
        };
    }

    public function isPromo(): bool
    {
        return self::Promo === $this;
    }
}
