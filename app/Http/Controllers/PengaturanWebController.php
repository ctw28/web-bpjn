<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengaturanWeb;
use App\Http\Requests\PengaturanWebRequest;

class PengaturanWebController extends Controller
{
    public function index(Request $request)
    {
        $dataQuery = PengaturanWeb::with('user')->orderBy('id', 'asc');

        if ($request->filled('showall')) {
            $dataQuery = $dataQuery->get();
            $startingNumber = 1;
        } else {
            $paging = 25;
            if ($request->filled('paging')) {
                $paging = $request->paging;
            }
            $dataQuery = $dataQuery->paginate($paging);
            $startingNumber = ($dataQuery->currentPage() - 1) * $dataQuery->perPage() + 1;
        }

        $dataQuery->transform(function ($item) use (&$startingNumber) {
            $item->setAttribute('nomor', $startingNumber++);
            $item->setAttribute('updated_at_format', dbDateTimeFormat($item->updated_at));
            return $item;
        });

        return response()->json($dataQuery);
    }

    public function store(PengaturanWebRequest $request)
    {
        if ($request->hasFile('file')) {
            $iconPath = uploadFile($request, null, 'favicon');
            if ($iconPath) {
                $request['icon'] = $iconPath;
            } else {
                return response()->json(['message' => 'Gagal mengunggah ikon'], 500);
            }
        }
        $dataSave = PengaturanWeb::create($request->all());
        $dataQuery = PengaturanWeb::with('user')
            ->where('id', $dataSave->id)
            ->first();
        $dataQuery->updated_at_format = dbDateTimeFormat($dataQuery->updated_at);
        return response()->json($dataQuery, 201);
    }

    public function show($id)
    {
        $dataQuery = PengaturanWeb::find($id);
        if (!$dataQuery) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json($dataQuery);
    }


    public function update(PengaturanWebRequest $request, $id)
    {
        // dd($request->all());
        $dataQueryResponse = $this->show($id);
        if ($dataQueryResponse->getStatusCode() === 404) {
            return $dataQueryResponse;
        }
        $dataQuery = $dataQueryResponse->getOriginalContent(); // Ambil instance model dari respons

        if ($request->hasFile('file')) {
            $iconPath = uploadFile($request, 'favicon');
            if ($iconPath) {
                $request['icon'] = $iconPath;
            } else {
                return response()->json(['message' => 'Gagal mengunggah ikon'], 500);
            }
        }
        // dd($request->all());
        $dataQuery->update($request->all());
        return response()->json($dataQuery, 200);
    }

    public function destroy($id)
    {
        $dataQueryResponse = $this->show($id);
        if ($dataQueryResponse->getStatusCode() === 404) {
            return $dataQueryResponse;
        }
        $dataQuery = $dataQueryResponse->getOriginalContent(); // Ambil instance model dari respons
        $dataQuery->delete();
        return response()->json(null, 204);
    }
}
