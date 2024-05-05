<?php

namespace App\Http\Controllers;

use App\Http\Requests\GaleriRequest;
use App\Models\Galeri;
use App\Models\Publikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FileFacade;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index(Request $request)
    {
        $dataQuery = Galeri::with(['user', 'publikasi.user'])
            ->orderBy('waktu', 'desc')->orderBy('judul', 'asc');

        if (!$request->filled('is_web')) {
            if (!is_admin() && !is_editor())
                $dataQuery->where('user_id', auth()->id());
        }

        if ($request->filled('search')) {
            $dataQuery->where('judul', 'like', '%' . $request->search . '%');
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
            $item->setAttribute('updated_at_format', dbDateTimeFormat($item->updated_at));
            return $item;
        });

        return response()->json($dataQuery);
    }

    public function store(GaleriRequest $request)
    {
        try {
            $storagePath = 'galeris/' . date('Y') . '/' . date('m');
            $uploadFile = uploadFile($request, 'file', $storagePath);
            // dd($uploadFile);
            if ($uploadFile !== false) {
                $request['path'] = $uploadFile['path'];
                $request['ukuran'] = (float)$uploadFile['ukuran'];
                $request['jenis_file'] = $uploadFile['jenis'];
            } else {
                return response()->json(['message' => 'Gagal mengunggah file'], 500);
            }

            // Simpan file
            $dataSave = Galeri::create($request->all());

            // auto publish ketika admin
            if (is_admin() || is_editor()) {
                $data = [
                    'is_publikasi' => 1,
                    'galeri_id' => $dataSave->id,
                    'user_id' => auth()->id(),
                ];
                Publikasi::create($data);
            }

            // Ambil data yang baru saja disimpan
            $dataQuery = Galeri::where('id', $dataSave->id)->first();
            $dataQuery->updated_at_format = dbDateTimeFormat($dataQuery->updated_at);

            return response()->json($dataQuery, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $dataQuery = Galeri::with(['user', 'publikasi.user'])->find($id);
        if (!$dataQuery) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json($dataQuery);
    }

    public function update(GaleriRequest $request, $id)
    {
        $dataQueryResponse = $this->show($id);
        if ($dataQueryResponse->getStatusCode() === 404) {
            return $dataQueryResponse;
        }
        $dataQuery = $dataQueryResponse->getOriginalContent(); // Ambil instance model dari respons


        if ($request->hasFile('file')) {
            //hapus file lama
            if (!empty($dataQuery->path) && FileFacade::exists($dataQuery->path)) {
                FileFacade::delete($dataQuery->path);
            }

            $storagePath = 'galeris/' . date('Y') . '/' . date('m');

            $uploadFile = uploadFile($request, 'file', $storagePath);
            if ($uploadFile !== false) {
                $request['path'] = $uploadFile['path'];
                $request['ukuran'] = $uploadFile['ukuran'];
                $request['jenis_file'] = $uploadFile['jenis'];
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
