<?php

namespace App\Services\ImageServices;

use App\Domains\ImageManageContract;
use App\Models\Image;
use App\Models\User;
use App\Services\HttpKits\ApiClient;
use App\Services\Traits\HasErrorMessage;
use Illuminate\Http\UploadedFile;
use Illuminate\Contracts\Config\Repository as ConfigContract;

class ImgbbImageService implements ImageManageContract
{
    use HasErrorMessage;

    public const NAME = 'imgbb';

    private string $apiKey;

    public function __construct(private ApiClient $apiClient, ConfigContract $config)
    {
        $this->apiClient->setBaseUrl($config->get('imgbb.base_url'));
        $this->apiKey = $config->get('imgbb.client_secret');
    }

    /**
     * Get the service name
     *
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * Upload an UploadedFile to ImgUR
     *
     * @param UploadedFile $file
     * @param User $user
     *
     * @return Image|null
     *
     * @link https://api.imgbb.com/
     */
    public function upload(UploadedFile $file, User $user): ?Image
    {
        $uploadResponse = $this->apiClient->post('1/upload?key=' . $this->apiKey, [
            'image' => $file,
        ]);
        if (!$uploadResponse->isSuccessful()) {
            return $this->setErrorMessage('Failed to upload the image to ImgBB.');
        }

        $uploadedData = $uploadResponse->getData()['data'];

        return Image::create([
            'user_id' => $user->id,
            'filename' => $uploadedData['image']['filename'],
            'url' => $uploadedData['url'],
            'type' => $this->getName(),
            'payload' => $uploadedData,
            'service' => $this->getName(),
        ]);
    }

    /**
     * Delete image from ImgBB
     *
     * @param Image $image
     *
     * @return bool
     */
    public function delete(Image $image): bool
    {
        // NOTE: imgBB doesn't have the DELETE endpoint so we only need to delete the image record here
        return $image->delete();
    }
}
