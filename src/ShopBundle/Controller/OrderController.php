<?php

namespace ShopBundle\Controller;

use AppBundle\Services\EntityService;
use Doctrine\ORM\EntityManagerInterface;
use ShopBundle\Entity\Order;
use ShopBundle\Entity\OrderItem;
use ShopBundle\Form\Factory\OrderFormFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class OrderController extends AbstractController
{
    public function __construct(
        protected EntityService          $entityService,
        protected EntityManagerInterface $entityManager,
        protected OrderFormFactory       $formFactory,
        protected SerializerInterface    $serializer,
    )
    {
    }

    public function showAction(): Response
    {
        return $this->render('@Shop/Order/public/show.html.twig');
    }

    public function successAction($id): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneBy(['id' => $id]);
        $orderItems = $this->entityManager->getRepository(OrderItem::class)->findBy(['order' => $order]);

        return $this->render('@Shop/Order/public/success.html.twig', [
            'jsData' => [
                'order' => $this->serializer->normalize($order, null, [
                    AbstractNormalizer::GROUPS => Order::NORMALIZER_GROUPS,
                ]),
                'orderItems' => $this->serializer->normalize($orderItems, null, [
                    AbstractNormalizer::GROUPS => OrderItem::NORMALIZER_GROUPS,
                ]),
            ]
        ]);
    }

    public function cancelAction($id): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneBy(['id' => $id]);

        if ($order->getStatus() == 'pending') {
            $order->setStatus('cancelled');
            $orderItems = $this->entityManager->getRepository(OrderItem::class)->findBy(['order' => $order]);

            foreach ($orderItems as $item) {
                $product = $item->getProduct();

                if ($product) {
                    $product->setStock($product->getStock() + $item->getQuantity());
                    $this->entityManager->persist($product);
                }
            }

            $this->entityManager->flush();
        }

        return $this->render('@Shop/Order/public/cancel.html.twig');
    }

    #[IsGranted('ROLE_USER')]
    public function newAction(Request $request): Response
    {
        $order = new Order();

        $form = $this->formFactory->getCreateForm($order);

        $payload = json_decode($request->getContent(), true);
        $form->submit($payload['data'] ?? []);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityService->save($order);
        }

        return new JsonResponse([
            'data' => $this->serializer->normalize($order, null, [
                AbstractNormalizer::GROUPS => Order::NORMALIZER_GROUPS,
            ])
        ]);
    }

    #[IsGranted('ROLE_USER')]
    public function editAction($id, Request $request): Response
    {
        $order = $this->entityService->findOrReject(Order::class, $id);

        $form = $this->formFactory->getEditForm($order);

        $payload = json_decode($request->getContent(), true);
        $form->submit($payload['data'] ?? []);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
        }

        return new JsonResponse([
            'data' => $this->serializer->normalize($order, null, [
                AbstractNormalizer::GROUPS => Order::NORMALIZER_GROUPS,
            ])
        ]);
    }

    public function deleteAction($id, Request $request): Response
    {
        $order = $this->entityService->findOrReject(Order::class, $id);

        $this->entityService->delete($order);

        return new JsonResponse([
            'data' => []
        ]);
    }

}
