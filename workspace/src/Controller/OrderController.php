<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Manager\OrderManager;
use App\Repository\OrderRepository;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Knp\Component\Pager\PaginatorInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OrderController.
 */
class OrderController extends AbstractFOSRestController
{
    const STATUS_SUCCESS = 'SUCCESS';

    /**
     * @var OrderManager
     */
    private $orderManager;

    /**
     * OrderController constructor.
     */
    public function __construct(OrderManager $orderManager)
    {
        $this->orderManager = $orderManager;
    }

    /**
     * Place an order.
     *
     * @Rest\Post("/orders")
     * @SWG\Response(
     *     response=Response::HTTP_OK,
     *     description="Place an order",
     *     @SWG\Schema(
     *          type="object",
     *          @SWG\Property(property="id", type="integer", example=1),
     *          @SWG\Property(property="distance", type="integer", example=21538, description="Distance between origin and destination in meters"),
     *          @SWG\Property(property="status", type="string", example="UNASSIGNED"),
     *     )
     * )
     * @SWG\Response(
     *     response=Response::HTTP_BAD_REQUEST,
     *     description="Place an order failure",
     *     @SWG\Schema(
     *          type="object",
     *          @SWG\Property(property="error", type="string", example="ERROR_DESCRIPTION"),
     *     )
     * )
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Order form JSON Payload",
     *     required=true,
     *     format="application/json",
     *     @SWG\Schema(
     *          type="object",
     *          @SWG\Property(property="origin", type="array", @SWG\Items(type="string")),
     *          @SWG\Property(property="destination", type="array", @SWG\Items(type="string"))
     *     )
     * )
     */
    public function placeOrder(Request $request): View
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->submit($request->request->all());

        if ($form->isSubmitted() && $form->isValid()) {
            $this->orderManager->create($order);

            return View::create($order, Response::HTTP_OK)
                ->setContext((new Context())->addGroups([
                    'post',
                ]));
        }

        return $this->getFormErrorsView($form, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Take an order.
     *
     * @Rest\Patch("/orders/{id}")
     * @ParamConverter("order", class="App\Entity\Order")
     * @SWG\Response(
     *     response=Response::HTTP_OK,
     *     description="Take an order success",
     *     @SWG\Schema(
     *          type="object",
     *          @SWG\Property(property="status", type="string", example="SUCCESS"),
     *     )
     * )
     * @SWG\Response(
     *     response=Response::HTTP_NOT_FOUND,
     *     description="Order not found failure",
     *     @SWG\Schema(
     *          type="object",
     *          @SWG\Property(property="error", type="string", example="Not found"),
     *     )
     * )
     * @SWG\Response(
     *     response=Response::HTTP_BAD_REQUEST,
     *     description="Take an order failure",
     *     @SWG\Schema(
     *          type="object",
     *          @SWG\Property(property="error", type="string", example="ERROR_DESCRIPTION"),
     *     )
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="integer",
     *     description="Order's id"
     * )
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Order form JSON Payload",
     *     required=true,
     *     format="application/json",
     *     @SWG\Schema(
     *          type="object",
     *          @SWG\Property(property="status", type="string", example="TAKEN"),
     *     )
     * )
     */
    public function takeOrder(Request $request, Order $order): View
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->submit($request->request->all(), false);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->orderManager->take($order);

                return View::create($this->getFormattedMessage('status', self::STATUS_SUCCESS), Response::HTTP_OK);
            } catch (\Exception $e) {
                return View::create($this->getFormattedMessage('error', 'An order can only be taken once.'), Response::HTTP_BAD_REQUEST);
            }
        }

        return $this->getFormErrorsView($form, Response::HTTP_BAD_REQUEST);
    }

    /**
     * List orders.
     *
     * @Rest\Get("/orders")
     * @SWG\Response(
     *     response=Response::HTTP_OK,
     *     description="List orders",
     *     @SWG\Schema(
     *          type="array",
     *          @SWG\Items(ref=@Model(type=Order::class, groups={"list"}))
     *     )
     * )
     * @SWG\Response(
     *     response=Response::HTTP_BAD_REQUEST,
     *     description="List orders failure",
     *     @SWG\Schema(
     *          type="object",
     *          @SWG\Property(property="error", type="string", example="ERROR_DESCRIPTION"),
     *     )
     * )
     * @SWG\Parameter(
     *     name="page",
     *     in="path",
     *     type="integer",
     *     description="Page number",
     *     default=1
     * )
     * @SWG\Parameter(
     *     name="limit",
     *     in="path",
     *     type="integer",
     *     description="Number of element per page",
     *     default=10,
     * )
     */
    public function getOrders(OrderRepository $repository, Request $request, PaginatorInterface $paginator): View
    {
        try {
            $pagination = $paginator->paginate(
                $repository->getQueryBuilder(),
                $request->query->getInt('page', 1),
                $request->query->getInt('limit', 10)
            );

            return View::create($pagination->getItems(), Response::HTTP_OK)
                ->setContext((new Context())->addGroups([
                    'list',
                ]));
        } catch (\Exception $e) {
            return View::create($this->getFormattedMessage('error', $e->getMessage()), Response::HTTP_BAD_REQUEST);
        }
    }

    private function getFormErrorsView(FormInterface $form, int $statusCode): View
    {
        return View::create([
            'error' => (string) $form->getErrors(true, true),
        ], $statusCode);
    }

    private function getFormattedMessage(string $status, string $message): array
    {
        return [$status => $message];
    }
}
