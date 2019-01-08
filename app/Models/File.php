<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class File extends Model
{
    const IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
    const VIDEO_EXTENSIONS = ['mp4', 'avi', 'flv', 'wmv', 'mov'];
    const AUDIO_EXTENSIONS = ['mp3', 'wav', 'aac', 'flac', 'ogg', 'wma'];
    const TEXT_EXTENSIONS = ['txt'];
    const PDF_EXTENSIONS = ['pdf'];
    const EXCEL_EXTENSIONS = ['xls', 'xlsx'];
    const WORD_EXTENSIONS = ['doc', 'docx'];

    const S3_URL = 'httpS://s3-us-west-1.amazonaws.com/cybernext/';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['folder_id', 'name', 'extension', 'size'];

    /**
     * Get the folder associated with the file.
     */
    public function folder()
    {
        return $this->belongsTo('App\Models\Folder');
    }

    /**
     * Get the file full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->name . '.' . $this->extension;
    }

    /**
     * Get link.
     *
     * @param bool $encoded
     * @return string
     */
    public function getLink($encoded = false)
    {
        if ($encoded) {
            $path = rawurlencode($this->folder->getPath() . '/' . $this->fullName);
        } else {
            $path = $this->folder->getPath() . '/' . $this->fullName;
        }

        return self::S3_URL . $path;
    }

    /**
     * Format date.
     *
     * @param string $timezone
     * @return string
     */
    public function formatDate($timezone)
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at, 'UTC');
        $date->setTimezone($timezone);

        return $date->format('m/d/Y h:i:A');
    }

    /**
     * Format size.
     *
     * @return string
     */
    public function formatSize()
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $this->size > 1024; $i++) {
            $this->size /= 1024;
        }

        return round($this->size, 2) . ' ' . $units[$i];
    }

    /**
     * Get valid file name.
     *
     * @param int $folder_id
     * @param string $name
     * @param string $extension
     * @return string
     */
    public static function getValidName($folder_id, $name, $extension)
    {
        $file = static::where([
            'folder_id' => $folder_id,
            'name' => $name,
            'extension' => $extension
        ])->first();

        if ($file) {
            return $file->getCopyName($folder_id);
        }

        return $name;
    }

    /**
     * Get copy name.
     *
     * @param int $folder_id
     * @return string
     */
    public function getCopyName($folder_id)
    {
        $append = 0;

        do {
            $name = !$append ? $this->name : $this->name . '_' . $append;
            
            $file = self::where([
                'folder_id' => $folder_id,
                'name' => $name,
                'extension' => $this->extension
            ])->first();
            
            $append++;
        } while (!empty($file));

        return $name;
    }

    /**
     * Create copy.
     *
     * @param int $folder_id
     * @return self
     */
    public function createCopy($folder_id)
    {
        return self::create([
            'folder_id' => $folder_id,
            'name' => $this->getCopyName($folder_id),
            'extension' => $this->extension,
            'size' => $this->size
        ]);
    }

    /**
     * Get icon.
     *
     * @return string
     */
    public function getIcon()
    {
        if (in_array(strtolower($this->extension), static::IMAGE_EXTENSIONS)) {
            return 'fa-file-image-o';
        }

        if (in_array(strtolower($this->extension), static::VIDEO_EXTENSIONS)) {
            return 'fa-file-video-o';
        }

        if (in_array(strtolower($this->extension), static::AUDIO_EXTENSIONS)) {
            return 'fa-file-audio-o';
        }

        if (in_array(strtolower($this->extension), static::TEXT_EXTENSIONS)) {
            return 'fa-file-text-o';
        }

        if (in_array(strtolower($this->extension), static::PDF_EXTENSIONS)) {
            return 'fa-file-pdf-o';
        }

        if (in_array(strtolower($this->extension), static::EXCEL_EXTENSIONS)) {
            return 'fa-file-excel-o';
        }

        if (in_array(strtolower($this->extension), static::WORD_EXTENSIONS)) {
            return 'fa-file-word-o';
        }

        return 'fa-file-o';
    }

    /**
     * Check if the file is viewable.
     *
     * @return bool
     */
    public function isViewable()
    {
        return in_array(strtolower($this->extension), self::IMAGE_EXTENSIONS);
    }

    /**
     * File search.
     *
     * @param string $search
     * @param array $allowedFolders
     * @return array
     */
    public static function search($search, $allowedFolders)
    {
        return static::whereIn('folder_id', $allowedFolders)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('extension', 'like', '%' . $search . '%')
                    ->orWhere(DB::raw("CONCAT(name, '.', extension)"), 'like', '%' . $search . '%');
            })
            ->orderBy('folder_id')
            ->get();
    }
}
