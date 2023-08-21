<?php

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class EloquentBaseRepository implements BaseRepository
{
    private Model $model;

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
        return $this->model->orderBy('id', 'DESC')->get();
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


    protected function updatePaymentData(\ArrayAccess $model, array $data)
    {
        if ($model->payment) {
            $paymentData = [
                'customer_email' => $data['email'],
                'amount_total' => $data['total_price'],
                'payment_status' => $data['payment_status'],
                // Update other payment fields if needed
            ];
            $model->payment->update($paymentData);
        }
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
        // Update the payment data
        $this->updatePaymentData($model, $data);

        return $model;
    }

    /**
     * @inheritdoc
     */
    public function delete(\ArrayAccess $model): bool
    {
        return $model->delete();
    }
}
