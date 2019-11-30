<?php

namespace App\Controller;

use App\Entity\Order;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends AbstractFOSRestController
{
    /**
     * List orders.
     *
     * @Rest\Get("/orders")
     * @SWG\Response(
     *     response=Response::HTTP_OK,
     *     description="List orders",
     *     @SWG\Schema(
     *          type="array",
     *          @SWG\Items(
     *              @Model(type=Order::class)
     *          )
     *     )
     * )
     */
    public function getOrders(ParamFetcherInterface $paramFetcher)
    {
        return new JsonResponse([]);
    }
}
