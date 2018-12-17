<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
     * @return string
     */
    public function getLink()
    {
        return self::S3_URL . $this->folder->getPath() . '/' . $this->fullName;
    }

    /**
     * Get copy name.
     *
     * @return string
     */
    public function getCopyName()
    {
        $append = 1;

        do {
            $name = $this->name . '_' . $append;
            $file = self::where('name', $name)->where('folder_id', $this->folder_id)->first();
            $append++;
        } while (!empty($file));

        return $name;
    }

    /**
     * Get copy.
     *
     * @return static
     */
    public function createCopy()
    {
        return static::create([
            'folder_id' => $this->folder_id,
            'name' => $this->getCopyName(),
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
        if (in_array($this->extension, static::IMAGE_EXTENSIONS)) {
            return 'fa-file-image-o';
        }

        if (in_array($this->extension, static::VIDEO_EXTENSIONS)) {
            return 'fa-file-video-o';
        }

        if (in_array($this->extension, static::AUDIO_EXTENSIONS)) {
            return 'fa-file-audio-o';
        }

        if (in_array($this->extension, static::TEXT_EXTENSIONS)) {
            return 'fa-file-text-o';
        }

        if (in_array($this->extension, static::PDF_EXTENSIONS)) {
            return 'fa-file-pdf-o';
        }

        if (in_array($this->extension, static::EXCEL_EXTENSIONS)) {
            return 'fa-file-excel-o';
        }

        if (in_array($this->extension, static::WORD_EXTENSIONS)) {
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
        return in_array($this->extension, self::IMAGE_EXTENSIONS);
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
                    ->orWhere('extension', 'like', '%' . $search . '%');
            })
            ->orderBy('folder_id')
            ->get();
    }
}
