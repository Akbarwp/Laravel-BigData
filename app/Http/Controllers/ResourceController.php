<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use App\Imports\ResourceImport;
use App\Models\Preprocessing;
use App\Models\Sentiment;
use App\Models\Vectorizer;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ResourceController extends Controller
{
    public function index()
    {
        $judul = "Resource";
        $data = Resource::orderBy('created_at', 'desc')->get();

        return view('dashboard.resource.index', [
            "judul" => $judul,
            "data" => $data,
        ]);
    }

    public function simpan(Request $request)
    {
        $validated = $request->validate([
            'rating' => 'required|numeric',
            'waktu' => 'required|date',
            'text' => 'required|string',
            'label' => 'required|string',
        ]);

        $insert = Resource::create($validated);

        Preprocessing::insert([
            'case_folding' => strtolower($insert->text),
            'resource_id' => $insert->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return redirect('dashboard/resource')->with('berhasil', "Data berhasil disimpan!");
    }

    public function import(Request $request)
    {
        // validasi
        $validated = $request->validate([
            'import_data' => 'required|mimes:xls,xlsx'
        ]);

        // Truncate Data
        Vectorizer::truncate();
        Sentiment::truncate();
        Preprocessing::truncate();
        Resource::truncate();

        // menangkap file excel
        $file = $request->file('import_data');

        // import data
        Excel::import(new ResourceImport, $file);
        $resource = Resource::orderBy('id', 'asc')->get();
        foreach ($resource as $item) {
            Preprocessing::insert([
                'case_folding' => strtolower($item->text),
                'resource_id' => $item->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // alihkan halaman kembali
        return redirect('dashboard/resource')->with('berhasil', "Data berhasil di import!");
    }

    public function ubah(Request $request)
    {
        $data = Resource::where('id', $request->id)->first();
        return $data;
    }

    public function perbarui(Request $request)
    {
        $validated = $request->validate([
            'rating' => 'required|numeric',
            'waktu' => 'required|date',
            'text' => 'required|string',
            'label' => 'required|string',
        ]);

        Resource::where('id', $request->id)->update([
            'rating' => $validated['rating'],
            'waktu' => $validated['waktu'],
            'text' => $validated['text'],
            'label' => $validated['label'],
        ]);

        return redirect('dashboard/resource')->with('berhasil', "Data berhasil diperbarui!");
    }

    public function hapus(Request $request)
    {
        Sentiment::where('resource_id', $request->id)->delete();
        Preprocessing::where('resource_id', $request->id)->delete();
        Resource::where('id', $request->id)->delete();
        return redirect('dashboard/resource');
    }

    public function truncate()
    {
        Resource::truncate();
        Preprocessing::truncate();
        Sentiment::truncate();
        Vectorizer::truncate();
        return redirect('dashboard/resource');
    }
}
