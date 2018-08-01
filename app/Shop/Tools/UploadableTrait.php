<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 8/1/18
 * Time: 1:16 PM
 */

namespace App\Shop\Tools;


use Illuminate\Http\UploadedFile;

trait UploadableTrait
{
    /**
     * Upload a single file in the server
     *
     * @param UploadedFile $file
     * @param null $folder
     * @param string $disk
     * @param null $filename
     * @return false|string
     */
    public function uploadOne(UploadedFile $file, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : str_random(25);
        return $file->storeAs(
            $folder,
            $name . "." . $file->getClientOriginalExtension(),
            $disk
        );
    }

    /**
     * @param UploadedFile $file
     *
     * @param string $folder
     * @param string $disk
     *
     * @return false|string
     */
    public function storeFile(UploadedFile $file, $folder = 'products', $disk = 'public')
    {
        $fileName = trim(time() . $file->getClientOriginalName());
        return $file->storeAs($folder, $fileName, ['disk' => $disk]);
    }
}