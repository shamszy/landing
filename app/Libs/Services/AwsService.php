<?php

namespace App\Libs\Services;

use App\Libs\Traits\AuthUserTrait;
use Illuminate\Support\Facades\Storage;

class AwsService
{
    use AuthUserTrait;

    /**
     * push file to aws s3
     * @param $request
     * @param $file
     * @return string
     */
    public function pushFileToAwsS3BucketService($request, $file): string
    {
        $clean_image = str_replace(' ', '_', $this->getAuthUser()->company->name);
        $extension = $request->file("$file")->getClientOriginalExtension();
        $fileStore = $clean_image.'_'.time().'.'.$extension;
        Storage::disk('s3')->put($fileStore, fopen($request->file("$file"), 'r+'), 'public');
        return Storage::disk('s3')->url($fileStore);
    }

    /**
     * put multiple file to aws storage
     * @param $request
     * @param $fileName
     * @return false|string
     */
    public function pushMultipleFileToAwsS3BucketService($request, $fileName): bool|string
    {
        $img_url = [];
        if ($request->hasFile($fileName)) {
            $clean_image = str_replace(' ', '_', $this->getAuthUser()->company->name);
            foreach($request->file("$fileName") as $file) {
                $extension = $file->getClientOriginalExtension();
                $fileStore = $clean_image.'_'.time().'.'.$extension;
                Storage::disk('s3')->put($fileStore, fopen($file, 'r+'), 'public');
                $img_url[] = Storage::disk('s3')->url($fileStore);
            }
        }
        return json_encode($img_url);
    }

    /**
     * delete file from aws bucket
     * @param $fileUrl
     * @return bool
     */
    public function deleteFileFromAwsS3BucketService($fileUrl): bool
    {
        return Storage::disk('s3')->delete($fileUrl);
    }

}
