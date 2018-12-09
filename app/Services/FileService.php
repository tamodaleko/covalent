<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class FileService
{
    /**
     * @var \Illuminate\Http\UploadedFile
     */
    protected $file;

    /**
     * @var string
     */
    protected $path = 'uploads/files';

    /**
     * Create a new controller instance.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return void
     */
    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
    }

    /**
     * Upload file to server.
     *
     * @param string $filename
     * @return bool
     */
    public function upload($filename)
    {
        try {
            $this->file->move($this->path, $filename);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Upload file to S3.
     *
     * @param string $s3Path
     * @param string $filename
     * @return bool|array
     */
    public function uploadToS3($s3Path, $filename)
    {
        if (!$this->upload($filename)) {
            return false;
        }

        $s3Service = new AmazonS3Service();

        $result = $s3Service->upload($s3Path, $filename);

        File::delete($this->path . '/' . $filename);

        return $result;
    }
}
