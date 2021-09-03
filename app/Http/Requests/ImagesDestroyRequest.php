<?php

namespace App\Http\Requests;

use App\Domains\ImageManageContract;

class ImagesDestroyRequest extends ImagesShowRequest
{
    public function getRequestedService(): ImageManageContract
    {
        return app()->makeWith(ImageManageContract::class, [
            'service' => $this->route('image')->service,
        ]);
    }
}
