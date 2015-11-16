<?php
namespace App\Http\Services;

use Illuminate\Http\Response as LumenResponse;

class Response extends LumenResponse
{
    public function json($content = [], $code = LumenResponse::HTTP_OK)
    {
        return $this->setStatusCode($code)->setContent(
            [
                'meta' => [
                    'code' => $code,
                ],
                'data' => $content,
            ]
        );
    }
}