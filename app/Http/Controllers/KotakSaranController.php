<?php

namespace App\Http\Controllers;

use App\Models\KotakSaran;
use Illuminate\Http\Request;
use App\Http\Requests\KotakSaranRequest;

class KotakSaranController extends Controller
{
    public function index(Request $request)
    {
        $dataQuery = KotakSaran::orderBy('created_at', 'desc');

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
            $item->setAttribute('created_at_format', dbDateTimeFormat($item->created_at));
            $item->setAttribute('updated_at_format', dbDateTimeFormat($item->updated_at));
            return $item;
        });

        return response()->json($dataQuery);
    }

    public function store(KotakSaranRequest $request)
    {
        $dataQuery = KotakSaran::create($request->all());
        $dataQuery->updated_at_format = dbDateTimeFormat($dataQuery->updated_at);
        return response()->json($dataQuery, 201);
    }

    public function show($id)
    {
        $dataQuery = KotakSaran::find($id);
        if (!$dataQuery) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json($dataQuery);
    }

    public function update(KotakSaranRequest $request, $id)
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
