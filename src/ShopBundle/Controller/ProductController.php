<?php

namespace ShopBundle\Controller;

use AppBundle\Services\EntityService;
use Doctrine\ORM\EntityManagerInterface;
use ShopBundle\Entity\Category;
use ShopBundle\Entity\Product;
use ShopBundle\Form\Factory\ProductFormFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class ProductController extends AbstractController
{
    public function __construct(
        protected EntityService          $entityService,
        protected EntityManagerInterface $entityManager,
        protected ProductFormFactory     $formFactory,
        protected SerializerInterface    $serializer,
    )
    {
    }

    public function productsListAction(): Response
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();

        return new JsonResponse([
            'data' => $this->serializer->normalize($products, null, [
                AbstractNormalizer::GROUPS => Product::NORMALIZER_GROUPS,
            ]),
        ]);
    }

    public function categoryProductsListAction($id, Request $request): Response
    {
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['id' => $id]);

        $products = $category->getProducts();
        return $this->render('@Shop/Product/public/list.html.twig', [
            'products' => $this->serializer->normalize($products, null, [
                AbstractNormalizer::GROUPS => Product::NORMALIZER_GROUPS,
            ])
        ]);
    }

    public function productShowAction($id, Request $request): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBy(['id' => $id]);

        return $this->render('@Shop/Product/public/show.html.twig', [
            'product' => $this->serializer->normalize($product, null, [
                AbstractNormalizer::GROUPS => Product::NORMALIZER_GROUPS,
            ])
        ]);
    }

    public function listAdminAction(): Response
    {
        return $this->render('@Shop/Product/admin/list.html.twig');
    }

    #[IsGranted('ROLE_ADMIN')]
    public function newAdminAction(Request $request): Response
    {
        $product = new Product();

        $form = $this->formFactory->getCreateForm($product);

        $payload = json_decode($request->getContent(), true);
        $form->submit($payload['data'] ?? []);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityService->save($product);
        }

        return new JsonResponse([
            'data' => $this->serializer->normalize($product, null, [
                AbstractNormalizer::GROUPS => Product::NORMALIZER_GROUPS,
            ])
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    public function editAdminAction($id, Request $request): Response
    {
        $product = $this->entityService->findOrReject(Product::class, $id);

        $form = $this->formFactory->getEditForm($product);

        $payload = json_decode($request->getContent(), true);
        $form->submit($payload['data'] ?? []);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
        }

        return new JsonResponse([
            'data' => $this->serializer->normalize($product, null, [
                AbstractNormalizer::GROUPS => Product::NORMALIZER_GROUPS,
            ])
        ]);

    }

    #[IsGranted('ROLE_ADMIN')]
    public function deleteAdminAction($id, Request $request): Response
    {
        $product = $this->entityService->findOrReject(Product::class, $id);

        $this->entityService->delete($product);

        return new JsonResponse([
            'data' => []
        ]);
    }

}
