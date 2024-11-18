<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Models\Status;
use App\Repositories\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class OrderRepository extends EloquentRepository implements OrderRepositoryInterface
{
    /**
     * OrderRepository constructor.
     *
     * @param Order $model
     */
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    /**
     * Get Orders.
     * 
     * @return Collection
     */
    public function getOrders(): Collection
    {
        return $this->model
            ->with([
                'user:id,name,email',
                'status:id,name',
            ])
            ->byUser()
            ->get()
            ->map(function ($query) {
                return $this->map($query);
            });
    }

    /**
     * Get Order.
     * 
     * @param int $id
     * @return Collection
     */
    public function getOrder(int $id): Collection
    {
        return $this->model
            ->where('id', $id)
            ->with([
                'user:id,name,email',
                'status:id,name',
            ])
            ->byUser()
            ->get();
    }

    /**
     * Get orders pagination.
     * 
     * @param int $page
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getPaginate(int $page, int $limit = 25): LengthAwarePaginator
    {
        return $this->model
            ->with([
                'user:id,name,email',
                'status:id,name',
            ])
            ->byUser()
            ->paginate($limit, ['*'], 'page', $page);
    }

    /**
     * Create Order.
     * 
     * @param array<string, mixed> $properties
     * @return Model
     */
    public function create(array $properties): Model
    {
        $properties = array_merge($properties, [
            'user_id' => auth()->user()->id,
            'status_id' => Status::where('slug', 'new')->first()->id,
        ]);

        return $this->model
            ->create($properties)
            ->load([
                'user:id,name,email',
                'status:id,name',
            ]);
    }

    /**
     * Update Order.
     * 
     * @param int $id
     * @param array<string, mixed> $properties
     * @return Model bool|int
     */
    public function update(int $id, array $properties): Model
    {
        $properties['status_id'] = Status::where('slug', $properties['status_name'])->first()->id;
        unset($properties['status_name']);
        return tap($this->model
            ->where('id', $id)
            ->byUser())
            ->update($properties)
            ->with([
                'user:id,name,email',
                'status:id,name',
            ])
            ->first();
    }

    /**
     * Delete Order.
     * 
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->model
            ->where('id', $id)
            ->byUser()
            ->delete();
    }

    /**
     * Prepare collection data.
     * 
     * @param Collection
     * @return Collection
     */
    private function map($query)
    {
        $query->user_name = $query->user->name;
        $query->status_name = $query->status->name;
        unset(
            $query->user,
            $query->status,
            $query->user_id,
            $query->status_id
        );
        return $query;
    }
}
