<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use Illuminate\Http\Request;
use App\Http\Requests\KomentarRequest;

class KomentarController extends Controller
{
    public function index(Request $request)
    {
        $dataQuery = Komentar::with(['konten', 'file', 'user',])->orderBy('created_at', 'desc');

        if ($request->filled('konten_id')) {
            $dataQuery->where('konten_id', $request->konten_id);
        } else if ($request->filled('file_id')) {
            $dataQuery->where('file_id', $request->file_id);
        }

        if ($request->filled('publikasi')) {
            $publikasiValue = $request->publikasi;
            if ($publikasiValue == 1) {
                $dataQuery->where('is_publikasi', 1);
            } elseif ($publikasiValue == 0) {
                $dataQuery->where('is_publikasi', 0);
            } elseif ($publikasiValue == 2) {
                $dataQuery->whereNull('is_publikasi');
            }
        }

        $startingNumber = 1;
        if ($request->filled('showall')) {
            $dataQuery = $dataQuery->get();
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
            $item->setAttribute('komentar', htmlspecialchars($item->komentar));
            $item->setAttribute('updated_at_format', dbDateTimeFormat($item->updated_at));
            return $item;
        });

        return response()->json($dataQuery);
    }

    public function store(KomentarRequest $request)
    {
        $dataSave = Komentar::create($request->all());
        $dataQuery = Komentar::where('id', $dataSave->id)->first();
        $dataQuery->updated_at_format = dbDateTimeFormat($dataQuery->updated_at);
        return response()->json($dataQuery, 201);
    }

    public function show($id)
    {
        $dataQuery = Komentar::with(['konten', 'user', 'file'])->find($id);
        if (!$dataQuery) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json($dataQuery);
    }

    public function update(KomentarRequest $request, $id)
    {
        $dataQueryResponse = $this->show($id);
        if ($dataQueryResponse->getStatusCode() === 404) {
            return $dataQueryResponse;
        }
        $dataQuery = $dataQueryResponse->getOriginalContent(); // Ambil instance model dari respons

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
