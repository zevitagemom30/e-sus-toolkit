<?php

namespace OM30\EsusToolkit\Helpers;

use DateTime;
use OM30\EsusToolkit\Models\AbstractModel;

/**
 * Classe para concentrar ações referentes a data e hora/tempo
 */
class DateTimeHelper
{
    /**
     * Função para validar uma data
     *
     * @param string $date
     * @param string $format
     * @return bool
     */
    public static function validateDate(string $date, string $format = 'Y-m-d H:i:s'): bool
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    /**
     * Função para formatar uma data com formato DD/MM/YYYY
     * @param mixed $date
     * @param string $fromFormat
     * @param string $toFormat
     * @return string
     */
    public static function formatDate(string $date, string $fromFormat, string $toFormat = 'Y-m-d'): string
    {
        $d = DateTime::createFromFormat($fromFormat, $date);
        return $d->format($toFormat);
    }

    /**
     * Adiciona as colunas created_at e updated_at no array de dados que nao possui, evitando
     * assim dar problema na hora de inserir os dados no banco de dados
     *
     * @param array $data
     * @param AbstractModel $model
     * @return array
     */
    public static function addTimestampColumns(array $data, AbstractModel $model): array
    {
        return array_map(function ($value) use ($model) {
            return self::addTimestampColumnsSoft(
                $value,
                $model->getCreatedAtColumn(),
                $model->getUpdatedAtColumn()
            );
        }, $data);
    }

    /**
     * Adiciona as colunas created_at e updated_at no array de dados que nao possui, evitando
     * assim dar problema na hora de inserir os dados no banco de dados
     *
     * @param array $data
     * @param string $createdAt
     * @param string $updatedAt
     * @return array
     */
    public static function addTimestampColumnsSoft(array $data, string $createdAt, string $updatedAt): array
    {
        return array_merge($data, [
            $createdAt => now(),
            $updatedAt => now()
        ]);
    }

    /**
     * Calcula quantidade de meses entre duas datas
     * Caso parâmetro final for nulo, utilizará a data atual
     *
     * @param string $dateInit
     * @param string $dateFinish
     * @return array
     */
    public static function calcDiffMonths(string $dateInit, string $dateFinish = null) : int
    {
        $dateInit   = new \DateTime($dateInit);
        $dateFinish = null;
        if ($dateFinish === null)
            $dateFinish = new \DateTime();
        else $dateFinish = new \DateTime($dateFinish);

        $interval = $dateInit->diff($dateFinish);

        $months = (int)$interval->format('%m');
        $years  = (int)$interval->format('%y');
        if ($years > 0)
            $months += ($years * 12);
        return $months;
    }
}