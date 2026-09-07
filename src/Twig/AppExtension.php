<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('dateInterval', [$this, 'dateInterval']),
            new TwigFilter('dateIntervalv2', [$this, 'dateIntervalv2']),
        ];
    }

    public function dateInterval(\DateTime $from, \DateTime $to): string
    {
        $formatter = new \IntlDateFormatter('fr_FR', \IntlDateFormatter::SHORT, \IntlDateFormatter::SHORT);
        $formatter->setPattern('LLLL');

        if ($from->format('m') === $to->format('m')) {
            return $from->format('j').' au '.$to->format('j').' '.$formatter->format($from);
        }

        return $from->format('j').' '.$formatter->format($from).' au '.$to->format('j').' '.$formatter->format($to);
    }

    public function dateIntervalv2(\DateTime $from, \DateTime $to): string
    {
        $formatter = new \IntlDateFormatter('fr_FR', \IntlDateFormatter::SHORT, \IntlDateFormatter::SHORT);
        $formatter->setPattern('LLLL');

        if ($from->format('m') === $to->format('m')) {
            return $from->format('j').' au '.$to->format('j').' '.$formatter->format($from).' '.$to->format('Y');
        }

        if ($from->format('Y') === $to->format('Y')) {
            return $from->format('j').' '.$formatter->format($from).' au '.$to->format('j').' '.$formatter->format($to).' '.$to->format('Y');
        }

        return $from->format('j').' '.$formatter->format($from).' '.$from->format('Y').' au '.$to->format('j').' '.$formatter->format($to).' '.$to->format('Y');
    }
}
