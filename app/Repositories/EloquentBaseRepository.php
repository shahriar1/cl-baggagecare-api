<?php

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
class EloquentBaseRepository implements BaseRepository
{
    protected Model $model;

    /**
     * EloquentBaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * get the model
     *
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }


    /**
     * @inheritdoc
     */
    public function findOne($id, $withTrashed = false): ?\ArrayAccess
    {
        $queryBuilder = $this->model;

        if (is_numeric($id)) {
            $item = $queryBuilder->find($id);
        }

        return $item;
    }

    /**
     * @inheritdoc
     */
    public function findBy(array $searchCriteria = [], $withTrashed = false)
    {
        $limit = !empty($searchCriteria['per_page']) ? (int)$searchCriteria['per_page'] : 10; // it's needed for pagination
        $orderBy = !empty($searchCriteria['order_by']) ? $searchCriteria['order_by'] : 'id';
        $orderDirection = !empty($searchCriteria['order_direction']) ? $searchCriteria['order_direction'] : 'desc';

        $this->validateOrderByField($orderBy);

        $queryBuilder = $this->model->where(function ($query) use ($searchCriteria) {
            $this->applySearchCriteriaInQueryBuilder($query, $searchCriteria);
        });

        if ($withTrashed) {
            $queryBuilder->withTrashed();
        }

        $queryBuilder = $this->applyEagerLoad($queryBuilder, $searchCriteria);

        if (isset($searchCriteria['rawOrder'])) {
            $queryBuilder->orderByRaw(DB::raw("FIELD(id, {$searchCriteria['id']})"));
        } else {
            $queryBuilder->orderBy($orderBy, $orderDirection);
        }

        if (empty($searchCriteria['withoutPagination'])) {
            return $queryBuilder->paginate($limit);
        } else {
            return $queryBuilder->get();
        }
    }

    /**
     * validate order by field
     *
     * @param string $orderBy
     */
    protected function validateOrderByField($orderBy)
    {
        $allowableFields = array_merge($this->model->getFillable(), ['id', 'created_at', 'updated_at']);
        if (!in_array($orderBy, $allowableFields)) {
            throw ValidationException::withMessages([
                'order_by' => ["You can't order with the field '" . $orderBy . "'"]
            ]);
        }
    }

    /**
     * apply eager load in query builder
     *
     * @param $queryBuilder
     * @param $searchCriteria
     * @return mixed
     */
    public function applyEagerLoad($queryBuilder, $searchCriteria)
    {
        if (isset($searchCriteria['eagerLoad'])) {
            if(isset($searchCriteria['include'])) {
                $includedRelationships = $this->eagerLoadWithIncludeParam($searchCriteria['include'], $searchCriteria['eagerLoad']);
                $queryBuilder = $queryBuilder->with($includedRelationships);
            }
        }
        return $queryBuilder;
    }

    /**
     * get eager loaded relationships
     *
     * @param string $includeString
     * @param array $eagerLoads
     * @return array
     */
    public function eagerLoadWithIncludeParam(string $includeString, array $eagerLoads)
    {
        $requestedRelationships = explode(',', $includeString);

        $shouldLoadRelationships = [];
        foreach ($requestedRelationships  as $relationship) {
            if (isset($eagerLoads[$relationship])) {
                $shouldLoadRelationships[] = $eagerLoads[$relationship];
            }
        }
        if (isset($eagerLoads['always'])) {
            $alwaysRelationships = explode(',', $eagerLoads['always']);
            $shouldLoadRelationships = array_merge($shouldLoadRelationships, $alwaysRelationships);
        }

        // always eagerload - needs to get user label
        if (in_array('user.userLabel', $requestedRelationships)) {
            $shouldLoadRelationships = array_merge($shouldLoadRelationships, ['userRoles']);
        }

        return array_unique($shouldLoadRelationships);
    }


    /**
     * Apply condition on query builder based on search criteria
     *
     * @param Object $queryBuilder
     * @param array $searchCriteria
     * @param string $operator
     * @return mixed
     */
    protected function applySearchCriteriaInQueryBuilder(
        $queryBuilder,
        array $searchCriteria = [],
        string $operator = '='
    ): object
    {
        unset($searchCriteria['include'], $searchCriteria['eagerLoad'], $searchCriteria['rawOrder'], $searchCriteria['detailed'], $searchCriteria['withoutPagination']); //don't need that field for query. only needed for transformer.

        foreach ($searchCriteria as $key => $value) {

            //skip pagination related query params
            if (in_array($key, ['page', 'per_page', 'order_by', 'order_direction'])) {
                continue;
            }

            if ($value == 'null') {
                $queryBuilder->whereNull($key);
            } else {
                if ($value == 'notNull') {
                    $queryBuilder->whereNotNull($key);
                } else {
                    //we can pass multiple params for a filter with commas
                    if (is_array($value)) {
                        $allValues = $value;
                    } else {
                        $allValues = explode(',', $value);
                    }

                    if (count($allValues) > 1) {
                        $queryBuilder->whereIn($key, $allValues);
                    } else {
                        if ($operator == 'like') {
                            $queryBuilder->where($key, $operator, '%' . $value . '%');
                        } else {
                            $queryBuilder->where($key, $operator, $value);
                        }
                    }
                }
            }
        }

        return $queryBuilder;
    }

    /**
     * @inheritdoc
     */
    public function findOneBy(array $criteria, $withTrashed = false, $withLatest = false, $latestBy = 'created_at'): ?\ArrayAccess
    {
        $queryBuilder = $this->model->where($criteria);

        if ($withTrashed) {
            $queryBuilder->withTrashed();
        }

        if ($withLatest) {
            $queryBuilder->latest($latestBy);
        }

        $item = $queryBuilder->first();

        return $item;
    }

    /**
     * @inheritdoc
     */
    public function save(array $data): \ArrayAccess
    {
        return $this->model->create($data);
    }

    /**
     * @inheritdoc
     */
    public function update(\ArrayAccess $model, array $data): \ArrayAccess
    {
        $fillAbleProperties = $this->model->getFillable();

        foreach ($data as $key => $value) {
            // update only fillAble properties
            if (in_array($key, $fillAbleProperties)) {
                $model->$key = $value;
            }
        }

        // update the model
        $model->save();

        return $model;
    }

    /**
     * @inheritdoc
     */
    public function delete(\ArrayAccess $model): bool
    {
        return $model->delete();
    }

    public function findByWithDateRanges(array $searchCriteria = [], $withTrashed = false, $timestamp = true)
    {
        $queryBuilder = $this->model;

        if (isset($searchCriteria['endDate'])) {
            $queryBuilder  =  $queryBuilder->whereDate('created_at', '<=', Carbon::parse($searchCriteria['endDate']));
            unset($searchCriteria['endDate']);
        }

        if (isset($searchCriteria['startDate'])) {
            $queryBuilder =  $queryBuilder->whereDate('created_at', '>=', Carbon::parse($searchCriteria['startDate']));
            unset($searchCriteria['startDate']);
        }
        if (isset($searchCriteria['id'])) {
            $searchCriteria['id'] = is_array($searchCriteria['id']) ? implode(",", array_unique($searchCriteria['id'])) : $searchCriteria['id'];
        }

        $queryBuilder = $queryBuilder->where(function ($query) use ($searchCriteria) {
            $this->applySearchCriteriaInQueryBuilder($query, $searchCriteria);
        });

        $limit = !empty($searchCriteria['per_page']) ? (int)$searchCriteria['per_page'] : 15;
        $orderBy = !empty($searchCriteria['order_by']) ? $searchCriteria['order_by'] : 'id';
        $orderDirection = !empty($searchCriteria['order_direction']) ? $searchCriteria['order_direction'] : 'desc';
        $queryBuilder->orderBy($orderBy, $orderDirection);

        if (empty($searchCriteria['withoutPagination'])) {
            return $queryBuilder->paginate($limit);
        } else {
            return $queryBuilder->get();
        }
    }
}
