<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('dateInterval', [$this, 'dateInterval']),
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
}
