<?php

namespace App\Observers;

use App\Models\Service;
use App\Models\ServiceComment;
use App\Models\ServiceCompany;
use App\Models\ServiceCompanyComment;

class ServiceCompanyCommentObserver
{
    /**
     * Handle the service company comment "created" event.
     *
     * @param \App\Models\ServiceCompanyComment $serviceCompanyComment
     * @return void
     */
    public function created(ServiceCompanyComment $serviceCompanyComment)
    {
        $this->syncPointAverage($serviceCompanyComment);
    }

    /**
     * Handle the service company comment "updated" event.
     *
     * @param \App\Models\ServiceCompanyComment $serviceCompanyComment
     * @return void
     */
    public function updated(ServiceCompanyComment $serviceCompanyComment)
    {
        $this->syncPointAverage($serviceCompanyComment);
    }

    /**
     * Handle the service company comment "deleted" event.
     *
     * @param \App\Models\ServiceCompanyComment $serviceCompanyComment
     * @return void
     */
    public function deleted(ServiceCompanyComment $serviceCompanyComment)
    {
        $this->syncPointAverage($serviceCompanyComment);
    }

    /**
     * Handle the service company comment "restored" event.
     *
     * @param \App\Models\ServiceCompanyComment $serviceCompanyComment
     * @return void
     */
    public function restored(ServiceCompanyComment $serviceCompanyComment)
    {
        //
    }

    private function syncPointAverage(ServiceCompanyComment $serviceCompanyComment)
    {
        Service::where(['id' => $serviceCompanyComment->service_id])->update([
            'point' => ServiceCompanyComment::where(['service_id' => $serviceCompanyComment->service_id,'status' => 1])->avg('point')
        ]);
    }
}
