<?php

namespace App\Services;

use App\Repositories\OrderRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class OrderService
{
    /**
     * @var OrderRepository
     */
    private $repository;

    /**
     * OrderService constructor.
     * 
     * @param OrderRepository $repository
     */
    public function __construct(OrderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 
     * 
     * @return Collection
     */
    public function all()
    {
        return $this->repository->getOrders();
    }

    /**
     * Get orders pagination.
     * 
     * @param ?int $page
     * @return
     */
    public function paginate($page)
    {
        return Cache::remember('order.page.' . $page, 600, function () use ($page) {
            return $this->repository->getPaginate($page);
        });
    }

    /**
     * Get order.
     * 
     * @param int $id
     * @return Collection
     */
    public function get($id)
    {
        return Cache::remember('order.' . $id, 600, function () use ($id) {
            return $this->repository->getOrder($id)->first();
        });
    }

    /**
     * Create order.
     * 
     * @param ?array<string, mixed> $properties
     * @return
     */
    public function create($properties)
    {
        $order = $this->repository->create($properties->toArray());
        return Cache::remember('order.' . $order->id, 600, function () use ($order) {
            return $order;
        });
    }

    /**
     * Update order.
     * 
     * @param int $id
     * @param ?array<string, mixed> $properties
     * @return
     */
    public function update($id, $properties)
    {
        Cache::forget('order.' . $id);
        return Cache::remember('order.' . $id, 600, function () use ($id, $properties) {
            return $this->repository->update($id, $properties->toArray());
        });
    }

    /**
     * Delete order.
     * 
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        Cache::forget('order.' . $id);
        return $this->repository->delete($id);
    }
}
