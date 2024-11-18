<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface EloquentRepositoryInterface
{
    /**
     * Get all model items.
     * 
     * @return Model
     */
    public function all(): Model;

    /**
     * Paginate model.
     *
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function paginate(int $page): LengthAwarePaginator;

    /**
     * Find model item.
     * 
     * @param int $id
     * @return Model
     */
    public function find(int $id): Model;

    /**
     * Create model item.
     * 
     * @param array<string, mixed> $properties
     * @return Model
     */
    public function create(array $properties): Model;

    /**
     * Update model item.
     * 
     * @param int $id
     * @param array<string, mixed> $properties
     * @return Model
     */
    public function update(int $id, array $properties): Model;

    /**
     * Delete model item.
     * 
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
