@extends('layouts.app')
@section('title','Kelola Menu')
@section('page-icon','fa-utensils')
@section('page-title','Kelola Menu')
@section('header-actions')
    <a href="{{ route('menu.create') }}" class="action-btn action-btn-primary">
        <i class="fas fa-plus"></i> Tambah Menu
    </a>
@endsection

@section('content')
<div class="grid-card">
    {{-- Search --}}
    <form method="GET" style="display:flex; gap:10px; margin-bottom:20px;">
        <input type="text" name="search" class="form-control" placeholder="Cari menu..." value="{{ request('search') }}" style="max-width:300px;">
        <select name="status" class="form-control" style="max-width:150px;">
            <option value="">Semua Status</option>
            <option value="aktif" {{ request('status')=='aktif'?'selected':'' }}>Aktif</option>
            <option value="nonaktif" {{ request('status')=='nonaktif'?'selected':'' }}>Nonaktif</option>
        </select>
        <button type="submit" class="action-btn action-btn-primary"><i class="fas fa-search"></i></button>
    </form>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr><th>Nama Menu</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
            @forelse($menus as $menu)
            <tr>
                <td><strong>{{ $menu->nama_menu }}</strong></td>
                <td>{{ $menu->kategori->nama_kategori ?? '-' }}</td>
                <td>Rp {{ number_format($menu->harga,0,',','.') }}</td>
                <td>
                    @if($menu->stok == 0)
                        <span class="badge badge-danger">Habis</span>
                    @elseif($menu->stok <= 5)
                        <span class="badge badge-warning">{{ $menu->stok }} (Menipis)</span>
                    @else
                        <span class="badge badge-success">{{ $menu->stok }}</span>
                    @endif
                </td>
                <td>
                    <span class="badge {{ $menu->status_menu=='aktif' ? 'badge-success' : 'badge-danger' }}">
                        {{ ucfirst($menu->status_menu) }}
                    </span>
                </td>
                <td style="display:flex; gap:8px;">
                    <a href="{{ route('menu.edit',$menu->id_menu) }}" class="action-btn action-btn-secondary" style="padding:6px 12px; font-size:12px;">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form method="POST" action="{{ route('menu.destroy',$menu->id_menu) }}" onsubmit="return confirm('Hapus menu ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="action-btn action-btn-danger" style="padding:6px 12px; font-size:12px;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center; padding:40px; color:var(--neutral-light);">Belum ada menu</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:20px;">{{ $menus->links() }}</div>
</div>
@endsection