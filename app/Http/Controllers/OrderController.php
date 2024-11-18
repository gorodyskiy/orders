<?php

namespace App\Http\Controllers;

use App\Helpers\Export\Csv;
use App\Http\Requests\OrderUpdateRequest;
use App\Http\Requests\OrderCreateRequest;
use App\Services\OrderService as Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * @var OrderService
     */
    private $service;

    /**
     * OrderController constructor.
     * 
     * @param OrderService $service
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $page = (is_numeric($request->page)) ? $request->page : 1;
        $orders = $this->service->paginate($page);
        if (count($orders) > 0) {
            return response()->json([
                'success' => true,
                'data' => $orders,
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Orders not foud.',
        ], 404);
    }

    /**
     * 
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $order = $this->service->get($id);
        if (!empty($order)) {
            return response()->json([
                'success' => true,
                'data' => $order,
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Order not foud.',
        ], 404);
    }

    /**
     * 
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function store(OrderCreateRequest $request)
    {
        if ($this->service->create($request->safe())) {
            return response()->json([
                'success' => true,
                'message' => 'Order created.',
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => '',
        ], 500);
    }

    /**
     * 
     * 
     * @param int $id
     * @param OrderUpdateRequest $request
     * @return JsonResponse
     */
    public function update($id, OrderUpdateRequest $request)
    {
        // return $this->service->update($id, $request->safe());
        $send_mail = 'gorodyskiy@gmail.com';
        dispatch(new \App\Jobs\SendEmailJob($send_mail));

        if ($this->service->update($id, $request->safe())) {
            return response()->json([
                'success' => true,
                'message' => 'Order updated.',
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => '',
        ], 500);
    }

    /**
     * 
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        if ($this->service->delete($id)) {
            return response()->json([
                'success' => true,
                'message' => 'Order deleted.',
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => '',
        ], 500);
    }

    /**
     * 
     */
    public function export()
    {
        $orders = $this->service->all();
        if ($export = Csv::prepare($orders)->export()) {
            return response()->json([
                'success' => true,
                'message' => 'Orders exported.',
                'data' => [
                    'download' => $export,
                ],
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => '',
        ], 500);
    }
}
