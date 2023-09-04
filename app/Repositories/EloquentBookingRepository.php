<?php

namespace App\Repositories;

class EloquentBookingRepository extends EloquentBaseRepository implements \App\Repositories\Contracts\BookingRepository
{
    public function findBy(array $searchCriteria = [], $withTrashed = false)
    {
        if(isset($searchCriteria['query'])) {
          $searchCriteria['id'] = $this->model->where('email', 'like', '%' . $searchCriteria['query'] . '%')
               ->orWhere('first_name', 'like', '%' . $searchCriteria['query'] . '%')->pluck('id')->toArray();

            unset($searchCriteria['query']);
        }

        return parent::findBy($searchCriteria);
    }
    
}
