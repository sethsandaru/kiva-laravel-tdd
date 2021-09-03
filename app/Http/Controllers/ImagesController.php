<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImagesDestroyRequest;
use App\Http\Requests\ImagesIndexRequest;
use App\Http\Requests\ImagesShowRequest;
use App\Http\Requests\ImagesStoreRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use Illuminate\Http\JsonResponse;

class ImagesController extends APIController
{
    /**
     * Get images list of user
     *
     * @param ImagesIndexRequest $request
     *
     * @return JsonResponse
     */
    public function index(ImagesIndexRequest $request): JsonResponse
    {
        $limit = $request->input('limit', 10);
        $images = Image::where('user_id', $request->user()->id)->paginate($limit);
        return $this->respondOk(ImageResource::collection($images)->resource);
    }

    /**
     * View a single image
     *
     * @param Image $image
     * @param ImagesShowRequest $request
     *
     * @return JsonResponse
     */
    public function show(Image $image, ImagesShowRequest $request): JsonResponse
    {
        return $this->respondOk(new ImageResource($image));
    }

    /**
     * Upload new image
     *
     * @param ImagesStoreRequest $request
     *
     * @return JsonResponse
     */
    public function store(ImagesStoreRequest $request): JsonResponse
    {
        $imageManageService = $request->getRequestedService();
        $image = $imageManageService->upload($request->getImage(), $request->user());
        if (!$image) {
            return $this->respondNotOk([
                'error' => 'Failed to upload the image, please try again',
            ]);
        }

        return $this->respondOk(new ImageResource($image));
    }

    /**
     * Delete a specific Image
     *
     * @param Image $image
     * @param ImagesDestroyRequest $request
     *
     * @return JsonResponse
     */
    public function destroy(Image $image, ImagesDestroyRequest $request): JsonResponse
    {
        $imageManageService = $request->getRequestedService();
        $deleteStatus = $imageManageService->delete($image);
        if (!$deleteStatus) {
            return $this->respondNotOk([
                'error' => 'Failed to delete the image, please try again',
            ]);
        }

        return $this->respondOk();
    }
}
