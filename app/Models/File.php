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
}
