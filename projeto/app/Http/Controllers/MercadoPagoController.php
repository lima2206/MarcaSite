<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;

class MercadoPagoController extends Controller
{
    public function __construct()
    {

        MercadoPagoConfig::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));
    }

    /**
     * Cria uma preferência de pagamento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createPreference(Request $request): JsonResponse
    {
        $client = new PreferenceClient();

        $preferenceData = [
            "items" => [
                [
                    "title" => $request->input('title', 'Produto Exemplo'),
                    "quantity" => $request->input('quantity', 1),
                    "unit_price" => $request->input('unit_price', 100.00),
                ],
            ],
            "back_urls" => [
                "success" => route('payment.success'),
                "failure" => route('payment.failure'),
                "pending" => route('payment.pending'),
            ],
            "auto_return" => "approved",
        ];

        $preference = $client->create($preferenceData);

        return response()->json([
            'init_point' => $preference->init_point,
        ]);
    }

    /**
     * Lida com notificações do webhook do Mercado Pago.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function webhook(Request $request)
    {
        // Aqui você pode processar as notificações recebidas do Mercado Pago
        // Por exemplo, verificar o tipo de notificação e atualizar o status do pedido

        // Exemplo de resposta para o Mercado Pago
        return response()->noContent();
    }
}
