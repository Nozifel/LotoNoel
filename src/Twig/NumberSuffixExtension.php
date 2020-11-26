<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class NumberSuffixExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('suffix', [$this, 'doSomething']),
        ];
    }

    public function doSomething($value)
    {
        $ends = array('ème','er','ème','ème','ème','ème','ème','ème','ème','ème');
        if ((($value % 100) >= 11) && (($value%100) <= 13))
            return $value. 'th';
        else
            return $value. $ends[$value % 10];
    }
}
