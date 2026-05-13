@extends('layouts.app')
@section('title','Laporan')
@section('page-icon','fa-chart-pie')
@section('page-title','Laporan & Sustainability')

@section('content')
{{-- Filter --}}
<div class="grid-card" style="margin-bottom:25px;">
    <form method="GET" style="display:flex; gap:15px; align-items:end;">
        <div class="form-group" style="margin:0;">
            <label class="form-label">Dari Tanggal</label>
            <input type="date" name="dari" class="form-control" value="{{ $dari }}">
        </div>
        <div class="form-group" style="margin:0;">
            <label class="form-label">Sampai Tanggal</label>
            <input type="date" name="sampai" class="form-control" value="{{ $sampai }}">
        </div>
        <button type="submit" class="action-btn action-btn-primary"><i class="fas fa-filter"></i> Filter</button>
    </form>
</div>

{{-- Overview Stats --}}
<div class="stats-grid" style="margin-bottom:25px;">
    <div class="stat-card">
        <div class="stat-icon gold"><i class="fas fa-receipt"></i></div>
        <div class="stat-info">
            <h3>{{ $overview->total_transaksi }}</h3>
            <p>Total Transaksi</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-money-bill-wave"></i></div>
        <div class="stat-info">
            <h3>Rp {{ number_format($overview->total_pendapatan,0,',','.') }}</h3>
            <p>Total Pendapatan</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-leaf"></i></div>
        <div class="stat-info">
            <h3>{{ $ecoCount }} ({{ $ecoPercent }}%)</h3>
            <p>Eco Packaging</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-recycle"></i></div>
        <div class="stat-info">
            <h3>{{ $plastikKg }} kg</h3>
            <p>Plastik Dikurangi</p>
        </div>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:25px;">
{{-- Best Selling --}}
<div class="grid-card">
    <div class="grid-card-header">
        <div class="grid-card-title"><i class="fas fa-star" style="color:var(--gold-main)"></i><h3>Menu Terlaris</h3></div>
    </div>
    <table class="table">
        <thead><tr><th>#</th><th>Menu</th><th>Terjual</th><th>Revenue</th></tr></thead>
        <tbody>
        @forelse($bestSelling as $i => $item)
        <tr>
            <td><span class="badge badge-primary">{{ $i+1 }}</span></td>
            <td>{{ $item->nama_menu }}</td>
            <td><strong>{{ $item->total_terjual }}</strong></td>
            <td>Rp {{ number_format($item->total_revenue,0,',','.') }}</td>
        </tr>
        @empty
        <tr><td colspan="4" style="text-align:center; color:var(--neutral-light);">Belum ada data</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

{{-- Laporan Harian --}}
<div class="grid-card">
    <div class="grid-card-header">
        <div class="grid-card-title"><i class="fas fa-calendar-alt" style="color:var(--gold-main)"></i><h3>Pendapatan Harian</h3></div>
    </div>
    <table class="table">
        <thead><tr><th>Tanggal</th><th>Transaksi</th><th>Pendapatan</th><th>Eco</th></tr></thead>
        <tbody>
        @forelse($harian as $h)
        <tr>
            <td>{{ \Carbon\Carbon::parse($h->tanggal)->format('d/m/Y') }}</td>
            <td>{{ $h->total_transaksi }}</td>
            <td>Rp {{ number_format($h->total_pendapatan,0,',','.') }}</td>
            <td>{{ $h->eco_count ?? 0 }}</td>
        </tr>
        @empty
        <tr><td colspan="4" style="text-align:center; color:var(--neutral-light);">Belum ada data</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
</div>

{{-- SDGS Section --}}
<div class="grid-card" style="margin-top:25px; border:2px solid rgba(46,125,50,0.2);">
    <div class="grid-card-header">
        <div class="grid-card-title">
            <i class="fas fa-leaf" style="color:var(--success)"></i>
            <h3 style="color:var(--success);">Sustainability Report — SDGS</h3>
        </div>
    </div>
    <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:20px;">
        <div style="background:rgba(46,125,50,0.05); border-radius:12px; padding:20px; text-align:center; border:1px solid rgba(46,125,50,0.15);">
            <div style="font-size:32px; margin-bottom:10px;">♻️</div>
            <h4 style="color:var(--success); margin-bottom:5px;">SDG 12</h4>
            <p style="font-size:13px; color:var(--neutral-light);">Responsible Consumption</p>
            <div style="font-size:22px; font-weight:800; color:var(--success); margin-top:10px;">{{ $ecoPercent }}%</div>
            <p style="font-size:12px; color:var(--neutral-light);">Transaksi pakai eco-packaging</p>
        </div>
        <div style="background:rgba(25,118,210,0.05); border-radius:12px; padding:20px; text-align:center; border:1px solid rgba(25,118,210,0.15);">
            <div style="font-size:32px; margin-bottom:10px;">🌍</div>
            <h4 style="color:#1976D2; margin-bottom:5px;">SDG 13</h4>
            <p style="font-size:13px; color:var(--neutral-light);">Climate Action</p>
            <div style="font-size:22px; font-weight:800; color:#1976D2; margin-top:10px;">{{ $plastikKg }} kg</div>
            <p style="font-size:12px; color:var(--neutral-light);">Plastik tidak jadi sampah</p>
        </div>
        <div style="background:rgba(212,175,55,0.05); border-radius:12px; padding:20px; text-align:center; border:1px solid rgba(212,175,55,0.2);">
            <div style="font-size:32px; margin-bottom:10px;">💰</div>
            <h4 style="color:var(--gold-main); margin-bottom:5px;">SDG 8</h4>
            <p style="font-size:13px; color:var(--neutral-light);">Economic Growth</p>
            <div style="font-size:18px; font-weight:800; color:var(--gold-main); margin-top:10px;">Rp {{ number_format($overview->total_pendapatan,0,',','.') }}</div>
            <p style="font-size:12px; color:var(--neutral-light);">Revenue periode ini</p>
        </div>
    </div>
</div>
@endsection