<?php


namespace FrontBundle\Twig;


class FrontExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('replaceABS', array($this, 'replaceABSFilter'))
        );
    }

    public function replaceABSFilter($str)
    {
        $pattern = '/(.*) (ABS) (.*)/';
        $replacement = '$1 $3 $2';

        $result = preg_replace($pattern, $replacement, $str);

        return $result;
    }

    public function getName()
    {
        return 'front_extension';
    }
}