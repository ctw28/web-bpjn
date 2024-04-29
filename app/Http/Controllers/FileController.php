<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Publikasi;
use Illuminate\Http\Request;
use App\Http\Requests\FileRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File as FileFacade;

class FileController extends Controller
{
    public function index(Request $request)
    {
        $dataQuery = File::with(['user', 'jeniskonten', 'publikasi.user'])
            ->withCount([
                'komentar' => function ($query) {
                    $query->where('is_publikasi', 1);
                },
                'likedislike'
            ])->orderBy('waktu', 'desc')->orderBy('judul', 'asc');

        if (!$request->filled('is_web')) {
            if (!is_admin() && !is_editor())
                $dataQuery->where('user_id', auth()->id());
        }

        if ($request->filled('search')) {
            $dataQuery->where('judul', 'like', '%' . $request->search . '%')
                ->orWhere('slug', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('jenis')) {
            $jenis = $request->jenis;
            $dataQuery->whereHas('jeniskonten', function ($q) use ($jenis) {
                $q->where('slug', $jenis);
            });
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
            $item->setAttribute('updated_at_format', dbDateTimeFormat($item->updated_at));
            return $item;
        });

        return response()->json($dataQuery);
    }

    public function store(FileRequest $request)
    {
        try {
            $storagePath = 'files/' . date('Y') . '/' . date('m');
            $pathUpload = uploadFile($request, 'file', $storagePath);

            if ($pathUpload) {
                $request['path'] = $pathUpload;
            } else {
                return response()->json(['message' => 'Gagal mengunggah file'], 500);
            }

            // Simpan file
            $dataSave = File::create($request->all());

            // auto publish ketika admin
            if (is_admin() || is_editor()) {
                $data = [
                    'is_publikasi' => 1,
                    'file_id' => $dataSave->id,
                    'user_id' => auth()->id(),
                ];
                Publikasi::create($data);
            }

            // Ambil data yang baru saja disimpan
            $dataQuery = File::where('id', $dataSave->id)->first();
            $dataQuery->updated_at_format = dbDateTimeFormat($dataQuery->updated_at);

            return response()->json($dataQuery, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function show($id)
    {
        $dataQuery = File::with(['user', 'komentar', 'likedislike', 'jeniskonten', 'publikasi.user'])->find($id);
        if (!$dataQuery) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        return response()->json($dataQuery);
    }

    public function update(FileRequest $request, $id)
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

            $storagePath = 'files/' . date('Y') . '/' . date('m');
            $pathUpload = uploadFile($request, 'file',  $storagePath);
            if ($pathUpload) {
                $request['path'] = $pathUpload;
            } else {
                return response()->json(['message' => 'Gagal mengunggah file'], 500);
            }
        }

        $dataQuery->update($request->all());
        return response()->json($dataQuery, 200);
    }

    public function updateJumlahAkses($id)
    {
        $dataQueryResponse = $this->show($id);
        if ($dataQueryResponse->getStatusCode() === 404) {
            return $dataQueryResponse;
        }
        $dataQuery = $dataQueryResponse->getOriginalContent(); // Ambil instance model dari respons
        $dataUpdate = [
            'jumlah_akses' => $dataQuery->jumlah_akses + 1,
        ];
        $dataQuery->update($dataUpdate);
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
