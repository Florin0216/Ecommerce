<?php

namespace ShopBundle\Controller;

use AppBundle\Services\EntityService;
use Doctrine\ORM\EntityManagerInterface;
use ShopBundle\Entity\Category;
use ShopBundle\Entity\Product;
use ShopBundle\Form\Factory\CategoryFormFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class CategoryController extends AbstractController
{
    public function __construct(
        protected EntityService          $entityService,
        protected EntityManagerInterface $entityManager,
        protected CategoryFormFactory    $formFactory,
        protected SerializerInterface    $serializer,
    )
    {
    }

    public function categoriesListAction(): Response
    {
        $categories = $this->entityManager->getRepository(Category::class)->findAll();

        return new JsonResponse([
            'data' => $this->serializer->normalize($categories, null, [
                AbstractNormalizer::GROUPS => Category::NORMALIZER_GROUPS,
            ]),
        ]);
    }

    public function listAction(): Response
    {
        return $this->render('@Shop/Category/public/list.html.twig');
    }

    public function listAdminAction(): Response
    {
        return $this->render('@Shop/Category/admin/list.html.twig');
    }

    #[IsGranted('ROLE_ADMIN')]
    public function newAdminAction(Request $request): Response
    {
        $category = new Category();

        $form = $this->formFactory->getCreateForm($category);

        $payload = json_decode($request->getContent(), true);
        $form->submit($payload['data'] ?? []);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityService->save($category);
        }

        return new JsonResponse([
            'data' => $this->serializer->normalize($category, null, [
                AbstractNormalizer::GROUPS => Category::NORMALIZER_GROUPS,
            ])
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    public function editAdminAction($id, Request $request): Response
    {
        $category = $this->entityService->findOrReject(Category::class, $id);

        $form = $this->formFactory->getEditForm($category);

        $payload = json_decode($request->getContent(), true);
        $form->submit($payload['data'] ?? []);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
        }

        return new JsonResponse([
            'data' => $this->serializer->normalize($category, null, [
                AbstractNormalizer::GROUPS => Category::NORMALIZER_GROUPS,
            ])
        ]);

    }

    #[IsGranted('ROLE_ADMIN')]
    public function deleteAdminAction($id, Request $request): Response
    {
        $category = $this->entityService->findOrReject(Category::class, $id);

        $this->entityService->delete($category);

        return new JsonResponse([
            'data' => []
        ]);
    }

}
