<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use App\Imports\ResourceImport;
use App\Models\Preprocessing;
use App\Models\Sentiment;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ResourceController extends Controller
{
    public function index()
    {
        $judul = "Resource";
        $data = Resource::orderBy('id', 'asc')->get();

        return view('dashboard.resource.index', [
            "judul" => $judul,
            "data" => $data,
        ]);
    }

    public function simpan(Request $request)
    {
        $validated = $request->validate([
            'acara_tv' => 'required|string',
            'jumlah_retweet' => 'required|numeric',
            'text' => 'required|string',
        ]);

        Resource::create($validated);

        return redirect('dashboard/resource')->with('berhasil', "Data berhasil disimpan!");
    }

    public function import(Request $request)
    {
        // validasi
        $validated = $request->validate([
            'import_data' => 'required|mimes:csv,xls,xlsx'
        ]);

        // Truncate Data
        Resource::truncate();
        Preprocessing::truncate();
        Sentiment::truncate();

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
            'acara_tv' => 'required|string',
            'jumlah_retweet' => 'required|numeric',
            'text' => 'required|string',
        ]);

        Resource::where('id', $request->id)->update([
            'acara_tv' => $validated['acara_tv'],
            'jumlah_retweet' => $validated['jumlah_retweet'],
            'text' => $validated['text'],
        ]);

        return redirect('dashboard/resource')->with('berhasil', "Data berhasil diperbarui!");
    }

    public function hapus(Request $request)
    {
        Resource::where('id', $request->id)->delete();
        return redirect('dashboard/resource');
    }

    public function truncate()
    {
        Resource::truncate();
        return redirect('dashboard/resource');
    }
}
