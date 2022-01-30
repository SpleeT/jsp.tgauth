<?php


namespace Jsp\TgAuth\Rest;


use Jsp\TgAuth\GenerateLink;

class GetLink
{
    protected $tg_id;
    protected $success = false;
    protected $message = '';
    protected $link = '';


    public static function init($query, $n, \CRestServer $server)
    {
        if(empty($query)) {
            throw new \Bitrix\Rest\RestException(
                'Query array is empty',
                'POST_DATA_EMPTY',
                $server::STATUS_PAYMENT_REQUIRED
            );
        }

        $obj = new self($query);
        $obj->generateLink();
        return $obj->prepareAnswer();
    }

    function __construct(array $query)
    {
        if($query['tg_id']) {
            $this->tg_id = $query['tg_id'];
        } else {
            $this->message = 'parameter tg_id is empty';
        }
    }

    public function generateLink()
    {
        if($this->tg_id) return false;
        $obLink = new GenerateLink();
        $access = $obLink->checkAccess($this->tg_id);
        if($access) {
            $this->link = $obLink->generateLink();
        } else {
            $this->message = 'access denied';
        }
    }

    protected function prepareAnswer()
    {
        return [
            "SUCCESS" => $this->success,
            "MESSAGE" => $this->message,
            "LINK" => $this->link
        ];
    }

}