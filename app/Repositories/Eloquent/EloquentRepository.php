<?php   

namespace App\Repositories\Eloquent;

use App\Repositories\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentRepository implements EloquentRepositoryInterface 
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var array
     */
    protected $columns = ['*'];

    /**
     * @var int
     */
    protected $perPage = 25;

    /**
     * EloquentRepository constructor.
     * 
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
 
    /**
     * Get all model items.
     * 
     * @return Model
     */
    public function all(): Model
    {
        return $this->model->all($this->columns);
    }

    /**
     * Paginate model items.
     *
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function paginate(int $page): LengthAwarePaginator
    {
        return $this->model->paginate($this->perPage, $this->columns, 'page', $page);
    }

    /**
     * Find model item.
     * 
     * @param int $id
     * @return Model
     */
    public function find(int $id): Model
    {
        return $this->model->find($id);
    }

    /**
     * Create model item.
     * 
     * @param array<string, mixed> $properties
     * @return Model
     */
    public function create(array $properties): Model
    {
        return $this->model->create($properties);
    }

    /**
     * Update model item.
     * 
     * @param int $id
     * @param array<string, mixed> $properties
     * @return Model
     */
    public function update(int $id, array $properties): Model
    {
        return tap($this->model->where('id', $id))->update($properties)->first();
    }

    /**
     * Delete model item.
     * 
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->model->where('id', $id)->delete();
    }
}
