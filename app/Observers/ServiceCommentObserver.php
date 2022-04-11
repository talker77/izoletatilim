<?php

namespace App\Observers;

use App\Models\ServiceComment;

class ServiceCommentObserver
{
    /**
     * Handle the service comment "created" event.
     *
     * @param \App\Models\ServiceComment $serviceComment
     * @return void
     */
    public function created(ServiceComment $serviceComment)
    {
        //
    }

    /**
     * Handle the service comment "updated" event.
     *
     * @param \App\Models\ServiceComment $serviceComment
     * @return void
     */
    public function updated(ServiceComment $serviceComment)
    {
        $this->syncPointAverage($serviceComment);
    }

    /**
     * Handle the service comment "deleted" event.
     *
     * @param \App\Models\ServiceComment $serviceComment
     * @return void
     */
    public function deleted(ServiceComment $serviceComment)
    {
        $this->syncPointAverage($serviceComment);
    }


    private function syncPointAverage(ServiceComment $serviceComment)
    {
        $serviceComment->service->update([
            'point' => ServiceComment::where(['service_id' => $serviceComment->service_id, 'status' => 1])->avg('point')
        ]);
    }
}
