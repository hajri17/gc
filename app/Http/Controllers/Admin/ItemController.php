<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ItemsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ItemEditRequest;
use App\Http\Requests\ItemRequest;
use App\Models\Category;
use App\Models\Item;
use App\Services\UploadService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ItemController extends Controller
{
    public function index(ItemsDataTable $dataTable)
    {
        return $dataTable->render('admin.items.index');
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.items.create', compact('categories'));
    }

    public function store(ItemRequest $request)
    {
        DB::beginTransaction();
        try {
            $item = new Item($request->except('main_image', 'images'));

            if ($request->hasFile('main_image') && $request->file('main_image')->isValid()) {
                $mainImage = (new UploadService($request->file('main_image'), [
                        'label' => 'Main image',
                        'store' => true,
                    ]))
                    ->storeFile();
                $item->main_image()->associate($mainImage);
            }

            $item->save();

            if ($request->file('images')) {
                $files = $request->file('images');
                $images = [];

                foreach ($files as $index => $file) {
                    $image = (new UploadService($file))->storeFile();
                    $images[$index] = $image;
                }

                $item->images()->saveMany($images);
            }
        } catch (\Exception $exception) {
            DB::rollBack();

            Log::error('Failed to create item: ' . $exception->getMessage());

            return redirect()
                ->back()
                ->with([
                    'failed' => 'Failed to create item: ' . $exception->getMessage(),
                    'error' => $exception->getMessage(),
                ]);
        }
        DB::commit();

        return redirect()
            ->route('admin.items.index')
            ->with([
                'success' => 'Item added successfully',
                'id' => $item->id,
            ]);
    }

    public function show(Item $item)
    {
        //
    }

    public function edit(Item $item)
    {
        $categories = Category::all();

        return view('admin.items.edit', compact('item', 'categories'));
    }

    public function update(ItemEditRequest $request, Item $item)
    {
        DB::beginTransaction();
        try {
            $item->update($request->except('main_image', 'images'));

            if ($request->hasFile('main_image') && $request->file('main_image')->isValid()) {
                $mainImage = (new UploadService($request->file('main_image'), [
                        'label' => 'Main image',
                        'store' => true,
                    ]))
                    ->storeFile();
                $item->main_image()->associate($mainImage);
            }

            $item->save();

            if ($request->file('images')) {
                $files = $request->file('images');
                $images = [];

                foreach ($files as $index => $file) {
                    $image = (new UploadService($file))->storeFile();
                    $images[$index] = $image;
                }

                $item->images()->saveMany($images);
            }
        } catch (\Exception $exception) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with([
                    'failed' => 'Failed to update item: ' . $exception->getMessage(),
                    'error' => $exception->getMessage(),
                ]);
        }
        DB::commit();

        return redirect()
            ->route('admin.items.index')
            ->with([
                'success' => 'Item updated successfully',
                'id' => $item->id,
            ]);
    }

    public function destroy(Item $item)
    {
        try {
            unlink(storage_path('app/public/' . $item->main_image->url));

            foreach ($item->images as $image) {
                unlink(storage_path('app/public/' . $image->url));
            }

            $item->delete();
        } catch (\Exception $exception) {
            return redirect()
                ->back()
                ->with([
                    'failed' => 'Failed to delete item with id: ' . $item->id . '. ' . $exception->getMessage(),
                    'error' => $exception->getMessage(),
                ]);
        }

        return redirect()
            ->route('admin.items.index')
            ->with([
                'success' => 'Item deleted successfully.',
                'id' => $item->id,
            ]);
    }
}
