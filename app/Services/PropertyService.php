<?php

namespace App\Services;

use App\Helpers\DescricaoWebHelper;
use Carbon\Carbon;
use Http;
use Log;

class PropertyService extends ApiService
{
    public function listProperty($params = [])
    {
        return $this->get('/imoveis/listar', $params);
    }

    public function updateProperty(string $imovelId, string $data)
    {
        $params = [
            'imovel' => $imovelId,
            'cadastro' => json_encode([
                'fields' => [
                    'DescricaoWeb' => $data
                ]
            ]),
        ];
        return $this->put("/imoveis/detalhes", $params);
    }

    public function startAutomation()
    {

        $lockFile = "automation.lock";
        $currentDay = date('Y-m-d');

        if (file_exists($lockFile)) {
            $lastExecutionDay = trim(file_get_contents($lockFile));

            if ($lastExecutionDay == $currentDay) {
                Log::info("Processo já foi executado hoje. Saindo...");
                exit(1);
            }
        }

        file_put_contents($lockFile, $currentDay);

        Log::info("Processamento iniciado.");
        $params = static::getParamns(1, 50);
        $imoveis = $this->listProperty($params);

        $paginas = $imoveis['paginas'];

        $allImoveis = [];
        $contTotal = 0;

        for ($pag = 1; $pag <= $paginas; $pag++) {
            $params = static::getParamns($pag, 50);
            $imoveis = $this->listProperty($params);

            foreach ($imoveis as $codigo => $imovel) {
                if (!in_array($codigo, ["total", "paginas", "pagina", "quantidade"]) && $codigo !== '') {
                    $allImoveis[$codigo] = $imovel;
                    $contTotal++;
                }
            }
        }

        $contParc = 0;
        foreach ($allImoveis as $codigo => $imovel) {
            $response = $this->updateProperty($codigo, DescricaoWebHelper::getTextByDay($imovel['DescricaoWeb']));

            $contParc++;

            if ($response['status'] === 200 && $response['message'] === 'Ok') {
                Log::info("$contParc de $contTotal - Imóvel ID $codigo atualizado com sucesso.");
            } else {
                $err = "$contParc de $contTotal - Erro no imóvel $codigo - " . $response['message'];
                Log::error($err);
            }
            sleep(1);
        }

        Log::info("Processamento finalizado.");
        return "Automação de atualização dos imóveis concluída!";
    }

    private static function getParamns(int $pag, ?int $qtd = 50): array
    {
        $params = [
            'showtotal' => 1,
            'pesquisa' => json_encode([
                'fields' => ['Codigo', 'DescricaoWeb'],
                // 'filter' => [
                //     'Codigo' => ['RMX1208', 'RMX1901', 'RMX1658'],
                // ],
                'order' => [
                    'Bairro' => 'asc',
                ],
                'paginacao' => [
                    'pagina' => $pag,
                    'quantidade' => $qtd,
                ],
            ]),
        ];

        return $params;
    }
}
