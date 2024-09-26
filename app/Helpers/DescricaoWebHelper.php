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
            1 => 'Localização privilegiada.',
            2 => 'Morar bem nunca foi tão fácil.',
            3 => 'Descubra o prazer de viver em um dos bairros mais desejados da cidade.',
            4 => 'Imóvel em rua tranquila, com fácil acesso às principais vias da cidade.',
            5 => 'Próximo a parques e áreas verdes.',
            6 => 'A poucos minutos do centro, com a praticidade de ter tudo perto de você.',
            7 => 'Localização estratégica, ideal para quem busca praticidade e mobilidade.',
            8 => 'Viva em um bairro com excelente infraestrutura.',
            9 => 'A poucos passos de tudo o que você precisa para viver bem.',
            10 => 'Localização privilegiada.',
            11 => 'Apartamento com planta inteligente e funcional.',
            12 => 'Imóvel com detalhes que fazem a diferença.',
            13 => 'Bem localizado e funcional.',
            14 => 'Quartos aconchegantes e com boa iluminação.',
            15 => 'Cômodos bem distribuídos.',
            16 => 'Imóvel com excelente ventilação e iluminação.',
            17 => 'Infraestrutura bem distribuída.',
            18 => 'Fácil acesso.',
            19 => 'Imóvel com potencial para personalização.',
            20 => 'Apartamento pronto para morar.',
            21 => 'Oportunidade única de adquirir um imóvel em uma localização privilegiada.',
            22 => 'Preço de ocasião, não perca essa chance!',
            23 => 'Imóvel com excelente custo-benefício.',
            24 => 'Condições de pagamento facilitadas, entre em contato e saiba mais.',
            25 => 'A hora de realizar o sonho da casa própria é agora!',
            26 => 'Imóvel bem precificado, uma excelente oportunidade de investimento.',
            27 => 'Não perca essa chance de morar bem e com conforto.',
            28 => 'Entre em contato e agende uma visita, você vai se apaixonar por esse imóvel!',
            29 => 'Uma nova vida te espera neste imóvel incrível.',
            30 => 'A sua casa nova te espera.',
            31 => 'Aproveite essa oportunidade única.'
        ];

        foreach ($array as $value) {
            $descricaoWebOrigin = str_replace($value, '', $descricaoWebOrigin);
        }

        $descricaoWebOrigin = trim($descricaoWebOrigin);

        if (str_ends_with($descricaoWebOrigin, '.'))
            $separator = ' ';
        else
            $separator = '. ';

        return $descricaoWebOrigin . $separator . $array[(int) $day];
    }
}
