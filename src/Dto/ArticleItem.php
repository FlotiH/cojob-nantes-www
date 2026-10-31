<?php

declare(strict_types=1);

namespace App\Dto;

use App\Config\ArticleItemType;
use App\Config\ArticleTag;
use App\Entity\Article;
use App\Entity\Promo;

final readonly class ArticleItem
{
    public function __construct(
        public string $title,
        public ?\DateTimeInterface $start,
        public ?\DateTimeInterface $end,
        public string $buttonLabel,
        public ?string $location,
        public ?ArticleTag $tag,
        public string $imageLink,
        public ArticleItemType $source,
        public ?string $content,
        public ?string $buttonLink = null,
        public ?\DateTimeInterface $startTime = null,
    ) {
    }

    public static function fromArticle(Article $article): self
    {
        return new self(
            title: $article->getTitle(),
            start: $article->getStart(),
            end: $article->getEnd(),
            startTime: $article->getStartTime(),
            buttonLink: $article->getButtonLink(),
            buttonLabel: $article->getButtonLabel(),
            location: $article->getLocation(),
            tag: $article->getTag(),
            imageLink: $article->getImageLink(),
            source: ArticleItemType::Article,
            content: $article->getContent(),
        );
    }

    public static function fromPromo(Promo $promo): self
    {
        return new self(
            title: $promo->getName(),
            start: $promo->getStart(),
            end: $promo->getEnd(),
            buttonLabel: 'S\'inscrire',
            location: 'Cospace',
            tag: ArticleTag::Promo,
            imageLink: 'https://cojobnantes.fr/uploads/images/medias/image-1-6ae59f14ba646281339313.jpg',
            source: ArticleItemType::Promo,
            content: $promo->isRegisteringOpen() ? '<span class="font-semibold">Inscriptions ouvertes !</span>' : 'Ouverture des inscriptions le '.$promo->getRegisteringStart()->format('d/m'),
        );
    }
}
