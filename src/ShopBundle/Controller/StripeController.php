<?php

namespace ShopBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use ShopBundle\Entity\Order;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\SignatureVerificationException;
use Stripe\StripeClient;
use Stripe\Webhook;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class StripeController extends AbstractController
{
    public function __construct(
        protected ParameterBagInterface $params,
        protected EntityManagerInterface $entityManager,
    )
    {
    }

    /**
     * @throws ApiErrorException
     */
    public function newAction(Request $request): Response
    {
        $payload = json_decode($request->getContent(), true);
        $stripe = new StripeClient($this->params->get('stripe_api_key'));
        $lineItems = [];

        foreach ($payload['data']['orderItems'] as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item['product']['name'],
                        'description' => $item['product']['description'],
                    ],
                    'unit_amount' => (int)($item['product']['price'] * 100),
                ],
                'quantity' => $item['quantity'],
            ];
        }

        $orderId = $payload['data']['orderItems'][0]['order']['id'];

        $session = $stripe->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => $this->generateUrl('shop_order_success',['id' => $orderId], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('shop_order_cancel', ['id' => $orderId], UrlGeneratorInterface::ABSOLUTE_URL),
            'metadata' => ['order_id' => $orderId],
            'shipping_options' => [
                [
                    'shipping_rate_data' => [
                        'type' => 'fixed_amount',
                        'fixed_amount' => [
                            'amount' => (int)($payload['data']['delivery']['price'] * 100),
                            'currency' => 'usd',
                        ],
                        'display_name' => $payload['data']['delivery']['name'],
                    ],
                ],
            ],
        ]);

        return new JsonResponse([
            'id' => $session->id,
            'url' => $session->url,
        ]);
    }

    public function handleWebhookAction(Request $request): Response
    {
        $payload = $request->getContent();
        $sigHeader = $request->headers->get('stripe-signature');
        $endpointSecret = $this->params->get('webhook_secret');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                $endpointSecret
            );
        } catch (SignatureVerificationException $e) {
            return new Response('Invalid signature', 400);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $orderId = $session->metadata->order_id;
                $order = $this->entityManager->getRepository(Order::class)->findOneBy(['id' => $orderId]);
                $payment = $order->getPayment();
                $payment->setStatus('completed');
                $order->setStatus('confirmed');
                $this->entityManager->flush();
                break;
            default:
                return new JsonResponse([
                    'data' => []
                ]);
        }

        return new JsonResponse([
            'data' => []
        ]);
    }


}
