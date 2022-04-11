<?php

namespace App\Http\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ServiceFilter extends Filter
{


    /**
     *
     * @param string|null $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function point($value = null): Builder
    {
        return $this->builder->where('point', '>=', $value);
    }

    /**
     *
     * @param string|null $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query($value = null): Builder
    {
        // todo : hem location filter hem de key filter olabilir.
        if ($this->request->anyFilled(['state', 'district', 'country'])) {
            return $this->builder;
        }
        return $this->builder->where(function ($query) use ($value) {
            $query->where('title', "like", "%$value%");
        });

    }

    /**
     *
     * @param string|null $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function country($value = null): Builder
    {
        return $this->builder->where('country_id', '=', $value);
    }

    /**
     *
     * @param string|null $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function state($value = null): Builder
    {
        return $this->builder->where('state_id', '=', $value);
    }

    /**
     *
     * @param string|null $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function district($value = null): Builder
    {
        return $this->builder->where('district_id', '=', $value);
    }

    /**
     *
     * @param string|null $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function type($value = null): Builder
    {
        return $this->builder->where('type_id', '=', $value);
    }

    /**
     *
     * @param string|null $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function person($value = 1): Builder
    {
        return $this->builder->where('person', '>=', $value);
    }

    /**
     * list order by param
     * @param string|null $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function order($value = null): Builder
    {
        $sort = in_array($this->request->get('sort'), ['asc', 'desc']) ? $this->request->sort : 'desc';

        if (in_array($value, ['created_at', 'point', 'view_count'])) {
            return $this->builder->orderBy($value, $sort);
        }
        if ($value == 'price') {
            return $this->builder
                ->join('service_appointments', 'service_appointments.service_id', 'services.id')
                ->orderBy('service_appointments.price', $sort);
        }

        return $this->builder;
    }

    /**
     *
     * @param string|null $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function startDate(string $value = null): Builder
    {
        if (!$value) return $this->builder;

        return $this->builder->whereHas('service_appointments', function ($query) {
            $query->whereDate('start_date', '<=', Carbon::parse($this->request->startDate))
                ->whereDate('end_date', '>=', Carbon::parse($this->request->endDate))
                ->where('status', 1)
                ->when($this->request->get('maxPrice'), function ($query) {
                    $query->where('price', '<=', $this->request->maxPrice);;
                })
                ->when($this->request->get('minPrice'), function ($query) {
                    $query->where('price', '>=', $this->request->minPrice);;
                });
        });
//        return $this->builder->whereDate('start_date', '>=', Carbon::createFromDate($value));
    }

    /**
     *
     * @param string|null $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function attributes(string $value = null): Builder
    {
        return $this->builder->whereHas('attributes', function ($query) use ($value) {
            $selectedAttributes = explode(',', $value);
            return $query->whereIn('service_attribute_id', $selectedAttributes);
        });
    }

//    /**
//     *
//     * @param string|null $value
//     * @return \Illuminate\Database\Eloquent\Builder
//     */
//    public function endDate(string $value = null): Builder
//    {
//        if (!$value) return $this->builder;
//
//        return $this->builder->whereHas('service_companies.appointments', function ($query) use ($value) {
//            $query->whereDate('end_date', '<=', Carbon::createFromDate($value));
//        });
//
////        return $this->builder->whereDate('end_date', '<=', Carbon::createFromDate($value));
//    }

//    /**
//     *
//     * @param string|null $value
//     * @return \Illuminate\Database\Eloquent\Builder
//     */
//    public function minPrice($value = null): Builder
//    {
//        return $this->builder->whereHas('service_companies.appointments', function ($query) use ($value) {
//            $query->where('price', '>=', $value);
//        });
////        return $this->builder->where('price', '>=', $value);
//    }

//    /**
//     *
//     * @param string|null $value
//     * @return \Illuminate\Database\Eloquent\Builder
//     */
//    public function maxPrice($value = null): Builder
//    {
//        return $this->builder->whereHas('service_companies.appointments', function ($query) use ($value) {
//            $query->where('price', '<=', $value);
//        });
//        //return $this->builder->where('price', '<=', $value);
//    }


}
