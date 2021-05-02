<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Http\UploadedFile;

class UploadService
{
    protected UploadedFile $file;
    protected array $options;

    public function __construct(UploadedFile $file, array $options = []) {
        $this->file = $file;
        $this->options = $options;
    }

    public function fileName(): string
    {
        $name = uniqid();
        $name .= '_' . $this->file->getClientOriginalName();

        return $name;
    }

    protected function structImage(): Image
    {
        return new Image([
            'label' => $this->options['label'] ?? null,
            'description' => $this->options['description'] ?? null,
            'user_id' => auth()->id(),
        ]);
    }

    public function storeFile(): Image
    {
        $image = $this->structImage();
        $image->url = $this->file->storeAs('images', $this->fileName(), 'public');

        if (isset($this->options['store']) && $this->options['store']) {
            $image->save();
        }

        return $image;
    }

    public function storeToDiskOnly(): string
    {
        return $this->file->storeAs('images', $this->fileName(), 'public');
    }
}
