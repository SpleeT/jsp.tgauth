<?php


namespace Jsp\TgAuth;


use Jsp\TgAuth\Rest\GetLink;

class RestHandler
{
    /**
     * Иницализация методов Rest
     * @return \array[][]
     */
    public function init()
    {
        return array(
            'jsp.tgauth' => array(
                'jsp.link.get' => array(
                    'callback' => array(GetLink::class, 'init'),
                    'options' => array(),
                ),
            )
        );
    }
}