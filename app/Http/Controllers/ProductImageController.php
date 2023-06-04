<?php

namespace App\Http\Controllers;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductImageController extends Controller
{
    public function deleteImage(Media $media_item)
    {
        $media_item->delete();

        back()
            ->with('success', 'Imagem deletada com sucesso');
    }
}
