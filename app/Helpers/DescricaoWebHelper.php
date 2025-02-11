<?php

namespace App\Helpers;

use Carbon\Carbon;

class DescricaoWebHelper
{
    /**
     * Retorna o texto de acordo com o dia do mês
     * 
     * @return string
     */
    public static function getTextByDay(string $descricaoWebOrigin): string
    {
        $day = Carbon::now()->format('d');

        $array = [
            1 => 'Ótima oportunidade!',
            2 => 'Região com alta valorização.',
            3 => 'Preço imperdível.',
            4 => 'Localização privilegiada.',
            5 => 'Grande potencial.',
            6 => 'Para quem sonha com qualidade.',
            7 => 'Raridade no mercado.',
            8 => 'Natureza em equilíbrio.',
            9 => 'Excelente chance de investimento.',
            10 => 'A realização dos seus sonhos passa por aqui.',
            11 => 'Não perca essa oportunidade.',
            12 => 'Região bem valorizada.',
            13 => 'Preço imbatível.',
            14 => 'Localização privilegiada.',
            15 => 'Localização com potencial elevado.',
            16 => 'Redirecione sua trajetória por aqui.',
            17 => 'Invista com a certeza da valorização.',
            18 => 'Natureza e urbanismo em equilíbrio.',
            19 => 'Excelente oportunidade.',
            20 => 'Muito bem localizado.',
            21 => 'Oportunidade única.',
            22 => 'Invista e seja feliz.',
            23 => 'Acerte no melhor investimento.',
            24 => 'Garanta essa oportunidade.',
            25 => 'Permita-se!',
            26 => 'Você pode!',
            27 => 'Você merece essa chance.',
            28 => 'A melhor oportunidade no momento ideal.',
            29 => 'A oportunidade certa.',
            30 => 'A oportunidade de realizar seus sonhos.',
            31 => 'Invista em sua felicidade.'
        ];

        foreach ($array as $value) {
            $descricaoWebOrigin = str_replace($value, '', $descricaoWebOrigin);
        }

        $descricaoWebOrigin = trim($descricaoWebOrigin);

        if ($descricaoWebOrigin === '.') {
            $descricaoWebOrigin = '';
        }

        if (strlen($descricaoWebOrigin) === 0) {
            $separator = '';
        } else if (preg_match('/[[:punct:]]$/', $descricaoWebOrigin)) {
            $separator = ' ';
        } else {
            $separator = '. ';
        }

        return $descricaoWebOrigin . $separator . $array[(int) $day];
    }
}
