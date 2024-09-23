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

        $params = static::getParamns(1, 50);
        $imoveis = $this->listProperty($params);

        $paginas = $imoveis['paginas'];

        for ($pag = 1; $pag <= $paginas; $pag++) {
            $params = static::getParamns($pag, 50);
            $imoveis = $this->listProperty($params);

            foreach ($imoveis as $codigo => $imovel) {
                if (!in_array($codigo, ["total", "paginas", "pagina", "quantidade"]) && $codigo !== '') {
                    $response = $this->updateProperty($codigo, DescricaoWebHelper::getTextByDay($imovel['DescricaoWeb']));
                    $response = $response->getBody();
                    $response = json_decode($response, true);

                    if ($response['status'] === 200) {
                        Log::info("Imóvel ID $codigo atualizado com sucesso.");
                    } else {
                        $err = "Erro no imóvel $codigo: status: " . $response["status"] . ' - ' . $response['message'];
                        Log::info($err);
                    }
                    sleep(1);
                }
            }
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
                //     'Bairro' => ['Centro'],
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
