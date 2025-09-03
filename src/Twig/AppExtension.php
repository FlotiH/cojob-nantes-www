<?php

namespace App\Twig;

use DateTime;
use IntlDateFormatter;
use JetBrains\PhpStorm\ArrayShape;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    #[ArrayShape(['static_version' => TwigFunction::class])]
    public function getFunctions(): array
    {
        return [
            'static_version' => new TwigFunction('static_version', [$this, 'staticVersion'], ['is_safe' => ['html']])
        ];
    }

    public function staticVersion($pathFile): bool|int
    {
        return filemtime(__DIR__ . '/../../../htdocs/' . $pathFile);
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('dateInterval', [$this, 'dateInterval']),
        ];
    }

    public function dateInterval(DateTime $from, DateTime $to): string
    {
        $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::SHORT, IntlDateFormatter::SHORT);
        $formatter->setPattern('LLLL');

        if ($from->format('m') === $to->format('m')) {
            return $from->format('j') . ' au ' . $to->format('j') . ' ' . $formatter->format($from);
        }

        return $from->format('j') . ' ' . $formatter->format($from) . ' au ' . $to->format('j') . ' ' . $formatter->format($to);
    }
}
