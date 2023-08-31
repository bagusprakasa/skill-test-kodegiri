<?php

namespace App\Http\Controllers;

use App\Models\DocumentManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DocumentManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Document Management';
        $data = [
            'list' => 'List Document Management',
            'data' => DocumentManagement::get(),
        ];
        return view('pages.document-management.index', compact('data', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Document Management';
        $data = array(
            'list' => 'Create Document Management',
            'menu' => 'Document Management',
            'type' => 'add',
            'data' => (object)array(
                'title' => '',
                'content' => '',
                'signing' => '',
                'choose' => '',
            ),
        );
        return view('pages.document-management.form', compact('title', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $arrValidate = [
            'title' => 'required',
            'content' => 'required',
            'choose' => 'required',
            'signing' => 'required',
        ];
        if ($request->choose == 'pad') {
            $arrValidate['signed'] = 'required';
        }
        if ($request->choose == 'upload') {
            $arrValidate['signing'] = 'required';
        }
        $request->validate($arrValidate);
        DB::beginTransaction();
        try {
            $model = new DocumentManagement();
            $model->title = $request->title;
            $model->content = $request->content;
            if ($request->choose == 'pad') {
                $folderPath = public_path('storage/document-management/');

                $image_parts = explode(";base64,", $request->signed);

                $image_type_aux = explode("image/", $image_parts[0]);

                $image_type = $image_type_aux[1];

                $image_base64 = base64_decode($image_parts[1]);

                $fileName = 'pad-' . uniqid() . '.' . $image_type;
                $file = $folderPath . $fileName;
                File::isDirectory($folderPath) or File::makeDirectory($folderPath, recursive: true);
                file_put_contents($file, $image_base64);
                $model->signing = 'storage/document-management/' . $fileName;
            } else {
                $document = $request->signing;
                $document->storeAs('public/document-management', $document->hashName());
                $model->signing = 'storage/document-management/' . $document->hashName();
            }
            $model->save();

            DB::commit();

            return redirect()->route('document-management.index')->with('success', 'Document management created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Something wrong. ');
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Something wrong on database ');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DocumentManagement $documentManagement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DocumentManagement $documentManagement)
    {
        $title = 'Document Management';
        $explodeSigning = explode('/', $documentManagement->signing);
        $data = array(
            'list' => 'Edit Document Management',
            'menu' => 'Document Management',
            'type' => 'edit',
            'data' => (object)array(
                'id' => $documentManagement->id,
                'title' => $documentManagement->title,
                'content' => $documentManagement->content,
                'signing' => $documentManagement->signing,
                'choose' => substr($explodeSigning[2], 0, 3) == 'pad' ? 'pad' : 'upload',
            ),
        );
        return view('pages.document-management.form', compact('title', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DocumentManagement $documentManagement)
    {
        $arrValidate = [
            'title' => 'required',
            'content' => 'required',
            'choose' => 'required',
            'signing' => 'required',
        ];
        if ($request->choose == 'pad') {
            $arrValidate['signed'] = 'required';
        }
        if ($request->choose == 'upload') {
            $arrValidate['signing'] = 'required';
        }
        $request->validate($arrValidate);
        DB::beginTransaction();
        try {
            $documentManagement->title = $request->title;
            $documentManagement->content = $request->content;
            if ($request->choose == 'pad') {
                File::delete($documentManagement->signing);
                $folderPath = public_path('storage/document-management/');

                $image_parts = explode(";base64,", $request->signed);

                $image_type_aux = explode("image/", $image_parts[0]);

                $image_type = $image_type_aux[1];

                $image_base64 = base64_decode($image_parts[1]);

                $fileName = uniqid() . '.' . $image_type;
                $file = $folderPath . $fileName;
                File::isDirectory($folderPath) or File::makeDirectory($folderPath, recursive: true);
                file_put_contents($file, $image_base64);
                $documentManagement->signing = 'storage/document-management/' . 'pad-' . $fileName;
            } else if ($request->choose == 'upload') {
                File::delete($documentManagement->signing);
                $document = $request->signing;
                $document->storeAs('public/document-management', $document->hashName());
                $documentManagement->signing = 'storage/document-management/' . $document->hashName();
            }
            $documentManagement->save();

            DB::commit();

            return redirect()->route('document-management.index')->with('success', 'Document management created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Something wrong. : ' . $e->getMessage());
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Something wrong on database : ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocumentManagement $documentManagement)
    {
        DB::beginTransaction();
        try {
            File::delete($documentManagement->signing);
            $documentManagement->delete();

            DB::commit();

            return redirect()->route('document-management.index')->with('success', 'Document management deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Something wrong. : ' . $e->getMessage());
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Something wrong on database : ' . $e->getMessage());
        }
    }
}
