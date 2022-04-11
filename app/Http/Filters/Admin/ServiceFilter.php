<?php

namespace App\Http\Filters\Admin;

use App\Http\Filters\Filter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ServiceFilter extends Filter
{
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
    public function status($value = null): Builder
    {
        return $this->builder->where('status', '=', $value);
    }

    /**
     *
     * @param string|null $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function company($value = null): Builder
    {
        return $this->builder->whereHas('service_companies', function ($q) use ($value) {
            $q->where('company_id', $value);
        });
    }

    /**
     *
     * @param string|null $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function serviceType($value = null): Builder
    {
        return $this->builder->where('type_id', '=', $value);
    }

    /**
     *
     * @param string|null $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function type($value = null): Builder
    {
        return $this->builder->where('store_type', '=', $value);
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
    public function startDate(string $value = null): Builder
    {
        if (!$value) return $this->builder;

        return $this->builder->whereHas('service_companies.appointments', function ($query) {
            $query->whereDate('start_date', '=', Carbon::parse($this->request->startDate))
                ->whereDate('end_date', '>=', Carbon::parse($this->request->endDate))
                ->when($this->request->get('maxPrice'), function ($query) {
                    $query->where('price', '<=', $this->request->maxPrice);;
                })
                ->when($this->request->get('minPrice'), function ($query) {
                    $query->where('price', '>=', $this->request->minPrice);;
                });
        });
//        return $this->builder->whereDate('start_date', '>=', Carbon::createFromDate($value));
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


}
