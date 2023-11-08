<?php

namespace OM30\EsusToolkit\Helpers;

use Illuminate\Support\Facades\Http;

class UpdateValidator
{
    const TYPE_QUEUE = 'queue';
    const TYPE_SYNC  = 'sync';

    public static function trigger(int $idFicha, string $tipoFicha, string $validateType = self::TYPE_SYNC)
    {
        if ($validateType !== self::TYPE_QUEUE && $validateType !== self::TYPE_SYNC)
            throw new \Exception('Invalid validate type.');

        $baseUrl = getenv('ESUS_FICHA_VALIDACAO_UPDATE_URL');

        $response = Http::withUrlParameters([
            'id_ficha'      => $idFicha,
            'tipo_ficha'    => $tipoFicha,
            'validate_type' => $validateType
        ])->get($baseUrl);

        if ($response->badRequest()) {
            throw new \Exception('Error triggering update validator: ' . $response->json()['error']);
        }

        if ($response->ok()) {
            return true;
        }

        throw new \Exception('Error triggering update validator: Internal server error code ' . $response->status());
    }
}