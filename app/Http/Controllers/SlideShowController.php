<?php

namespace App\Http\Controllers;

use App\Models\SlideShow;
use Illuminate\Http\Request;
use App\Http\Requests\SlideShowRequest;
use Illuminate\Support\Facades\File as FileFacade;


class SlideShowController extends Controller
{
    public function index(Request $request)
    {
        $dataQuery = SlideShow::with(['user'])->orderBy('updated_at', 'desc')->orderBy('judul', 'asc');
        if (!$request->filled('is_web')) {
            if (!is_admin(auth()->id()))
                $dataQuery->where('user_id', auth()->id());
        }

        if ($request->filled('search')) {
            $dataQuery->where('judul', 'like', '%' . $request->search . '%')
                ->orWhere('deskripsi', 'like', '%' . $request->search . '%'); //slug pada SlideShow
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
            $item->setAttribute('pembuka', ambilKata($item->isi, 15));
            $item->setAttribute('updated_at_format', dbDateTimeFormat($item->updated_at));
            return $item;
        });

        return response()->json($dataQuery);
    }

    public function store(SlideShowRequest $request)
    {
        $storagePath = 'slideshows/' . date('Y') . '/' . date('m');
        $pathUpload = uploadFile($request, 'file', $storagePath);
        if ($pathUpload) {
            $request['path'] = $pathUpload;
        } else {
            return response()->json(['message' => 'Gagal mengunggah file'], 500);
        }

        $dataQuery = SlideShow::create($request->all());
        $dataQuery->updated_at_format = dbDateTimeFormat($dataQuery->updated_at);
        return response()->json($dataQuery, 201);
    }

    public function show($id)
    {
        $dataQuery = SlideShow::with(['user'])->find($id);
        if (!$dataQuery) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json($dataQuery);
    }

    public function update(SlideShowRequest $request, $id)
    {
        $dataQueryResponse = $this->show($id);
        if ($dataQueryResponse->getStatusCode() === 404) {
            return $dataQueryResponse;
        }
        $dataQuery = $dataQueryResponse->getOriginalContent(); // Ambil instance model dari respons


        if ($request->has('file')) {
            if (!empty($dataQuery->path) && FileFacade::exists($dataQuery->path)) {
                FileFacade::delete($dataQuery->path);
            }

            $storagePath = 'slideshows/' . date('Y') . '/' . date('m');
            $pathUpload = uploadFile($request, 'file', $storagePath);
            if ($pathUpload) {
                $request['path'] = $pathUpload;
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

        if (!empty($dataQuery->path) && FileFacade::exists($dataQuery->path)) {
            FileFacade::delete($dataQuery->path);
        }
        $dataQuery->delete();


        return response()->json(null, 204);
    }
}
