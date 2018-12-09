<?php

namespace App\Services;

use AWS;

class AmazonS3Service
{
    /**
     * @var string
     */
    private $bucket = 'cybernext';

    /**
     * @var string
     */
    private $filePath = 'uploads/files';

    /**
     * @var \Aws\S3\S3Client
     */
    private $client;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->client = AWS::createClient('s3');
    }

    /**
     * Upload file.
     *
     * @param string $path
     * @param string $filename
     * @return bool|array
     */
    public function upload($path, $filename)
    {
        try {
            $result = $this->client->putObject([
                'Bucket' => $this->bucket,
                'Key' => $path . '/' . $filename,
                'Body' => fopen($this->filePath . '/' . $filename, 'r'),
                'ACL' => 'public-read'
            ]);
        } catch (Exception $e) {
            return false;
        }

        return $result;
    }
}
