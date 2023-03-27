<?php

namespace App\Controller;

use App\Entity\Feedback;
use App\Store\StoreFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class FeedbackController extends AbstractController
{
    /**
     * @Route("/api", name="app_api_post", methods={"POST"})
     */
    public function postApi(
        StoreFactory $store,
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator): JsonResponse
    {
        $feedback = $serializer->deserialize(
            $request->getContent(),
            Feedback::class,
            'json'
        );

        $errors = $validator->validate($feedback);
        if (count($errors) > 0) {
            return $this->json($errors);
        }

        $stores = [];
        foreach ($store->getEnableStoreTypes() as $type) {
            $stores[] = $store->create($feedback, $type);
        }

        $store->save($stores);

        return $this->json($feedback);
    }
    /**
     * @Route("/", name="app_api_get", methods={"GET"})
     */
    public function getMain()
    {
        return $this->redirect('/index.html');
    }
}
