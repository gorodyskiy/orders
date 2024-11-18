<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface OrderRepositoryInterface
{
    /**
     * Get Orders.
     * 
     * @param int $id
     * @return Collection
     */
    public function getOrders(): Collection;

    /**
     * Get Order.
     * 
     * @param int $id
     * @return Collection
     */
    public function getOrder(int $id): Collection;

    /**
     * Get orders pagination.
     * 
     * @param int $page
     * @return LengthAwarePaginators
     */
    public function getPaginate(int $page, int $limit): LengthAwarePaginator;

    /**
     * Create order.
     * 
     * @param array<string, mixed> $properties
     * @return Model
     */
    public function create(array $properties): Model;

    /**
     * Update order.
     * 
     * @param int $id
     * @param array<string, mixed> $properties
     * @return Model
     */
    public function update(int $id, array $properties): Model;

    /**
     * Delete order.
     * 
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
