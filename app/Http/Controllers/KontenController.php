<?php

namespace App\Http\Controllers;

use App\Models\Konten;
use Illuminate\Http\Request;
use App\Http\Requests\KontenRequest;
use Illuminate\Support\Facades\File as FileFacade;
use Illuminate\Support\Facades\Storage;

class KontenController extends Controller
{
    public function index(Request $request)
    {
        $dataQuery = Konten::with(['jeniskonten', 'user', 'komentar', 'likedislike', 'publikasi.user'])->orderBy('updated_at', 'desc');
        $dataQuery->where('user_id', 1);

        if ($request->filled('search')) {
            $dataQuery->where('judul', 'like', '%' . $request->search . '%')
                ->orWhere('slug', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('publikasi')) {
            $publikasiValue = $request->publikasi;
            if ($publikasiValue == 1) {
                $dataQuery->whereHas('publikasi', function ($q) {
                    $q->where('publikasis.is_publikasi', 1);
                });
            } elseif ($publikasiValue == 0) {
                $dataQuery->whereHas('publikasi', function ($q) {
                    $q->where('publikasis.is_publikasi', 0);
                });
            } elseif ($publikasiValue == 2) {
                $dataQuery->whereDoesntHave('publikasi');
            }
        }

        // $query = $dataQuery->toSql();
        // dd($query);

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
            $item->setAttribute('pembuka', ambilKata($item->isi, 15));

            $item->setAttribute('updated_at_format', dbDateTimeFormat($item->updated_at));
            return $item;
        });

        return response()->json($dataQuery);
    }

    public function store(KontenRequest $request)
    {
        $storagePath = 'kontens/' . date('Y') . '/' . date('m');
        $pathUpload = uploadFile($request, $storagePath);
        if ($pathUpload) {
            $request['thumbnail'] = $pathUpload;
        } else {
            return response()->json(['message' => 'Gagal mengunggah file'], 500);
        }

        $dataSave = Konten::create($request->all());
        $dataQuery = Konten::where('id', $dataSave->id)->first();
        $dataQuery->updated_at_format = dbDateTimeFormat($dataQuery->updated_at);
        return response()->json($dataQuery, 201);
    }

    public function show($id)
    {
        $dataQuery = Konten::with(['jeniskonten', 'user', 'komentar', 'likedislike', 'publikasi.user'])->find($id);
        if (!$dataQuery) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json($dataQuery);
    }

    public function update(KontenRequest $request, $id)
    {
        $dataQueryResponse = $this->show($id);
        if ($dataQueryResponse->getStatusCode() === 404) {
            return $dataQueryResponse;
        }
        $dataQuery = $dataQueryResponse->getOriginalContent(); // Ambil instance model dari respons


        if ($request->has('file')) {
            $storagePath = 'kontens/' . date('Y') . '/' . date('m');
            $pathUpload = uploadFile($request, $storagePath);
            if ($pathUpload) {
                $request['thumbnail'] = $pathUpload;
            } else {
                return response()->json(['message' => 'Gagal mengunggah file'], 500);
            }
        }

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

        if (!empty($dataQuery->thumbnail) && File::exists($dataQuery->thumbnail)) {
            File::delete($dataQuery->thumbnail);
        }
        $dataQuery->delete();


        return response()->json(null, 204);
    }
}
