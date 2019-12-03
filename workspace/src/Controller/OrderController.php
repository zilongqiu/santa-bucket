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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
                return View::create($this->getFormattedMessage('error', 'An order can only be taken once.'), Response::HTTP_CONFLICT);
            }
        }

        return $this->getFormErrorsView($form, Response::HTTP_BAD_REQUEST);
    }

    /**
     * List orders.
     *
     * @Rest\Get("/orders")
     */
    public function getOrders(OrderRepository $repository, Request $request, PaginatorInterface $paginator): View
    {
        try {
            $pagination = $paginator->paginate(
                $repository->getQueryBuilder(),
                $request->query->getInt('page', 1),
                $request->query->getInt('limit', 10)
            );
        } catch (\Exception $e) {
            return View::create($this->getFormattedMessage('error', $e->getMessage()), Response::HTTP_BAD_REQUEST);
        }

        return View::create($pagination->getItems(), Response::HTTP_OK)
            ->setContext((new Context())->addGroups([
                'list',
            ]));
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
