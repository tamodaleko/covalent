<?php

namespace App\Services;

use AWS;
use Aws\CommandPool;

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
        } catch (Aws\S3\Exception\S3Exception $e) {
            return false;
        }

        return $result;
    }

    /**
     * Copy file.
     *
     * @param string $sourcePath
     * @param string $targetPath
     * @return bool|array
     */
    public function copyFile($sourcePath, $targetPath)
    {
        try {
            $result = $this->client->copyObject([
                'Bucket' => $this->bucket,
                'Key' => $targetPath,
                'CopySource' => $this->bucket . '/' . $sourcePath,
                'ACL' => 'public-read'
            ]);
        } catch (Aws\S3\Exception\S3Exception $e) {
            return false;
        }

        return $result;
    }

    /**
     * Move file.
     *
     * @param string $sourcePath
     * @param string $targetPath
     * @return bool|array
     */
    public function moveFile($sourcePath, $targetPath)
    {
        try {
            $result = $this->client->copyObject([
                'Bucket' => $this->bucket,
                'Key' => $targetPath,
                'CopySource' => $this->bucket . '/' . $sourcePath,
                'ACL' => 'public-read'
            ]);
        } catch (Aws\S3\Exception\S3Exception $e) {
            return false;
        }

        $this->deleteFile($sourcePath);

        return $result;
    }

    /**
     * Delete file.
     *
     * @param string $path
     * @return bool|array
     */
    public function deleteFile($path)
    {
        try {
            $result = $this->client->deleteObject([
                'Bucket' => $this->bucket,
                'Key' => $path
            ]);
        } catch (Aws\S3\Exception\S3Exception $e) {
            return false;
        }

        return $result;
    }

    /**
     * Copy multiple files.
     *
     * @param $files
     * @return bool|array
     */
    public function copyFiles($files)
    {
        $batch = [];

        foreach ($files as $file) {
            $batch[] = $this->client->getCommand('CopyObject', [
                'Bucket' => $this->bucket,
                'Key' => $file['targetPath'],
                'CopySource' => $this->bucket . '/' . $file['sourcePath'],
                'ACL' => 'public-read'
            ]);
        }

        try {
            $result = CommandPool::batch($this->client, $batch);
        } catch (Aws\S3\Exception\S3Exception $e) {
            return false;
        }

        return $result;
    }

    /**
     * Move multiple files.
     *
     * @param $files
     * @return bool|array
     */
    public function moveFiles($files)
    {
        $batch = [];

        foreach ($files as $file) {
            $batch[] = $this->client->getCommand('CopyObject', [
                'Bucket' => $this->bucket,
                'Key' => $file['targetPath'],
                'CopySource' => $this->bucket . '/' . $file['sourcePath'],
                'ACL' => 'public-read'
            ]);
        }

        try {
            $result = CommandPool::batch($this->client, $batch);
        } catch (Aws\S3\Exception\S3Exception $e) {
            return false;
        }

        foreach ($files as $file) {
            $this->deleteFile($file['sourcePath']);
        }

        return $result;
    }

    /**
     * Delete folder.
     *
     * @param string $path
     * @return bool|array
     */
    public function deleteFolder($path)
    {
        try {
            $result = $this->client->deleteMatchingObjects($this->bucket, $path);
        } catch (Aws\S3\Exception\S3Exception $e) {
            return false;
        }

        return $result;
    }
}
