<?php

namespace App\Http\Controllers;

use App\Models\HtmlCode;
use Illuminate\Http\Request;
use App\Http\Requests\HtmlCodeRequest;

class HtmlCodeController extends Controller
{
    public function index(Request $request)
    {
        $dataQuery = HtmlCode::with(['user']);

        if (!$request->filled('is_web')) {
            if (!is_admin(auth()->id()))
                $dataQuery->where('user_id', auth()->id());
        }

        if ($request->filled('search')) {
            $dataQuery->where('judul', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('slug')) {
            $dataQuery->where('slug', $request->slug);
        }

        $startingNumber = 1;
        if ($request->filled('showall')) {
            $dataQuery = $dataQuery->get();
        } else {
            if ($request->filled('limit')) {
                $limit = $request->limit;
                $dataQuery = $dataQuery->limit($limit)->get();
            } else {
                $paging = 25;
                if ($request->filled('paging')) {
                    $paging = $request->paging;
                }
                $dataQuery = $dataQuery->paginate($paging);
                $startingNumber = ($dataQuery->currentPage() - 1) * $dataQuery->perPage() + 1;
            }
        }

        $dataQuery->transform(function ($item) use (&$startingNumber) {
            $item->setAttribute('nomor', $startingNumber++);
            $item->setAttribute('code_text', htmlspecialchars($item->code));
            $item->setAttribute('updated_at_format', dbDateTimeFormat($item->updated_at));
            return $item;
        });

        return response()->json($dataQuery);
    }

    public function store(HtmlCodeRequest $request)
    {
        $dataQuery = HtmlCode::create($request->all());
        $dataQuery->updated_at_format = dbDateTimeFormat($dataQuery->updated_at);
        return response()->json($dataQuery, 201);
    }

    public function show($id)
    {
        $dataQuery = HtmlCode::with(['user'])->find($id);
        if (!$dataQuery) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json($dataQuery);
    }

    public function update(HtmlCodeRequest $request, $id)
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
