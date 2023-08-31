<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\DocumentManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class DocumentManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        try {
            $model = DocumentManagement::get();
            return Helpers::succesResponse($model, 'Get Data successfully.');
        } catch (\Exception $e) {
            return Helpers::errorResponse(null, 'Something wrong. : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Illuminate\Database\QueryException $e) {
            return Helpers::errorResponse(null, 'Something wrong on database. : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $req = $request->all();
            $arrValidate = [
                'title' => 'required',
                'content' => 'required',
                'signing' => 'required|mimes:png',
            ];
            $fields = Validator::make(
                $req,
                $arrValidate
            );
            if ($fields->fails()) {
                return Helpers::errorResponse(null, $fields->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            } else {
                $model = new DocumentManagement();
                $model->title = $request->title;
                $model->content = $request->content;
                $document = $request->signing;
                $document->storeAs('public/document-management', $document->hashName());
                $model->signing = 'storage/document-management/' . $document->hashName();
                $model->save();
                DB::commit();
                return Helpers::succesResponse($model, 'Store document management successfully.');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return Helpers::errorResponse(null, 'Something wrong. : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return Helpers::errorResponse(null, 'Something wrong on database. : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $model = DocumentManagement::find($id);
            DB::commit();
            return Helpers::succesResponse($model, 'Get document management successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return Helpers::errorResponse(null, 'Something wrong. : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return Helpers::errorResponse(null, 'Something wrong on database. : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
            $req = $request->all();
            $arrValidate = [
                'title' => 'required',
                'content' => 'required',
            ];
            $fields = Validator::make(
                $req,
                $arrValidate
            );
            if ($fields->fails()) {
                return Helpers::errorResponse(null, $fields->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            } else {
                $model = DocumentManagement::find($id);
                $model->title = $request->title;
                $model->content = $request->content;
                if ($request->signing) {
                    File::delete($model->signing);
                    $document = $request->signing;
                    $document->storeAs('public/document-management', $document->hashName());
                    $model->signing = 'storage/document-management/' . $document->hashName();
                }
                $model->save();
                DB::commit();
                return Helpers::succesResponse($model, 'Update document management successfully.');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return Helpers::errorResponse(null, 'Something wrong. : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return Helpers::errorResponse(null, 'Something wrong on database. : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            $model = DocumentManagement::find($id);
            File::delete($model->signing);
            $model->delete();
            DB::commit();
            return Helpers::succesResponse(null, 'Deleted document management successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return Helpers::errorResponse(null, 'Something wrong. : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return Helpers::errorResponse(null, 'Something wrong on database. : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
