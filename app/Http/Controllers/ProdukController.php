<?php

namespace App\Http\Controllers;

// Kumpulan 'use' statement yang benar-benar kita butuhkan
use App\Models\JenisProduk;
use App\Models\Produk;
use App\Models\Toko;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProdukController extends Controller
{
    /**
     * Menampilkan halaman utama untuk Manajemen Produk (Dashboard Kategori).
     */
    public function index()
    {
        $kategoris = Kategori::with(['jenisProduks' => function ($query) {
            $query->whereHas('produks')->withCount('produks')->orderBy('name', 'asc');
        }])->oldest()->get();

        session(['produk_return_url' => request()->fullUrl()]);

        return view('produk.index', [
            'title' => 'MANAJEMEN PRODUK',
            'kategoris' => $kategoris,
        ]);
    }

    /**
     * Menampilkan halaman form untuk menambah produk baru.
     */
    public function create()
    {
        return view('produk.create', [
            'title'        => 'TAMBAH PRODUK BARU',
            'tokos'        => Toko::orderBy('name')->get(),
            'jenisProduks' => JenisProduk::with('kategoris')->orderBy('name')->get(),
        ]);
    }

    /**
     * Menyimpan produk baru ke dalam database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama'              => ['required', 'string', 'max:255', Rule::unique('produks')->where(fn ($query) => $query->where('jenis_produk_id', $request->input('jenis_produk_id')))],
            'jenis_produk_id'   => 'required|exists:jenis_produks,id',
            'toko_id'           => 'required|exists:tokos,id',
            'stok'              => 'required|integer|min:0',
            'minimal_stok'      => 'required|integer|min:0',
            'satuan'            => ['required',Rule::in(['pouch', 'gram', 'kg', 'pcs', 'roll', 'pack'])],
            'foto'              => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $extension = $request->file('foto')->getClientOriginalExtension();
            $newFileName = now()->format('Ymd_His') . '_' . uniqid() . '.' . $extension;
            $request->file('foto')->storeAs('foto_produk', $newFileName, 'public');
            $validatedData['foto'] = $newFileName;
        }

        Produk::create($validatedData);

        return redirect()->back()->with('success', 'Produk baru berhasil ditambahkan!')->withInput($request->only(['toko_id', 'jenis_produk_id', 'satuan']));
    }

    /**
     * Menampilkan form untuk mengedit produk.
     */
    public function edit(Produk $produk)
    {
        return view('produk.edit', [
            'title'        => 'EDIT PRODUK',
            'produk'       => $produk,
            'tokos'        => Toko::orderBy('name')->get(),
            'jenisProduks' => JenisProduk::with('kategoris')->orderBy('name')->get(),
        ]);
    }

    /**
     * Memperbarui produk di database.
     */
    public function update(Request $request, Produk $produk)
    {
        $validatedData = $request->validate([
            'nama' => ['required', 'string', 'max:255', Rule::unique('produks')->where(fn ($query) => $query->where('jenis_produk_id', $request->input('jenis_produk_id')))->ignore($produk->id)],
            'jenis_produk_id'   => 'required|exists:jenis_produks,id',
            'toko_id'           => 'required|exists:tokos,id',
            'stok'              => 'required|integer|min:0',
            'minimal_stok'      => 'required|integer|min:0',
            'satuan'            => ['required', Rule::in(['pouch', 'gram', 'kg', 'pcs', 'roll', 'pack'])],
            'foto'              => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($produk->foto) {
                Storage::disk('public')->delete('foto_produk/' . $produk->foto);
            }
            $extension = $request->file('foto')->getClientOriginalExtension();
            $newFileName = now()->format('Ymd_His') . '_' . uniqid() . '.' . $extension;
            $request->file('foto')->storeAs('foto_produk', $newFileName, 'public');
            $validatedData['foto'] = $newFileName;
        }

        $produk->update($validatedData);

        return redirect(session('produk_return_url', route('superadmin.produk.index')))
                   ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Menghapus produk dari database.
     */
    public function destroy(Produk $produk)
    {
        if ($produk->foto) {
            Storage::disk('public')->delete('foto_produk/' . $produk->foto);
        }
        $produk->delete();
        return redirect()->back()->with('success', 'Produk berhasil dihapus!');
    }

    
    /**
     * Menampilkan daftar produk berdasarkan Jenis Produk yang dipilih.
     */
    public function showByJenis(Request $request, JenisProduk $jenisProduk)
    {
        $sortField = $request->query('sort', 'nama');
        $sortOrder = $request->query('order', 'asc');
        $allowedSorts = ['nama', 'stok'];
        if (!in_array($sortField, $allowedSorts)) {
            $sortField = 'nama';
        }
        $perPage = $request->query('per_page', 15);

        $produks = $jenisProduk->produks()
                            ->with('toko') 
                            ->orderBy($sortField, $sortOrder)
                            ->paginate($perPage); 

        session(['produk_return_url' => request()->fullUrl()]);

        return view('stok.show', [
            'title' => 'STOK: ' . $jenisProduk->name,
            'jenisProduk' => $jenisProduk,
            'produks' => $produks,
            'sortField' => $sortField,
            'sortOrder' => $sortOrder,
        ]);
    }

    /**
     * Memproses permintaan koreksi stok dari modal.
     */
    public function koreksiStok(Request $request, Produk $produk)
    {
        $validated = $request->validate(['stok' => 'required|integer|min:0']);

        $stokLama = $produk->stok;
        $stokBaru = $validated['stok'];

        $perubahan = $stokBaru - $stokLama;

        if ($perubahan == 0) {
            return redirect()->back()->with('info', 'Tidak ada perubahan pada stok.');
        }
        
        $produk->recordStockChange($perubahan, 'koreksi manual');
        
        $produk->update(['stok' => $stokBaru]);

        return redirect()->back()->with('success', 'Stok untuk produk "'. $produk->nama .'" berhasil dikoreksi!');
    }
}
