@extends('layouts.app')
@section('title','Transaksi Baru')
@section('page-icon','fa-cash-register')
@section('page-title','Transaksi Baru')

@section('content')
<form method="POST" action="{{ route('transaksi.store') }}" id="formTransaksi">
@csrf
<div style="display:grid; grid-template-columns:1fr 380px; gap:25px; align-items:start;">

{{-- Pilih Menu --}}
<div class="grid-card">
    <div class="grid-card-header">
        <div class="grid-card-title"><i class="fas fa-utensils" style="color:var(--gold-main)"></i><h3>Pilih Menu</h3></div>
    </div>
    @foreach($kategoris as $kat)
    @if($kat->menuAktif->count() > 0)
    <h4 style="color:var(--primary-dark); margin-bottom:15px; margin-top:10px;"><i class="fas fa-{{ $kat->icon ?? 'tag' }}"></i> {{ $kat->nama_kategori }}</h4>
    <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(160px,1fr)); gap:15px; margin-bottom:25px;">
        @foreach($kat->menuAktif as $menu)
        <div class="menu-card" onclick="addToCart({{ $menu->id_menu }},'{{ addslashes($menu->nama_menu) }}',{{ $menu->harga }},{{ $menu->stok }})"
             style="border:2px solid rgba(212,175,55,0.2); border-radius:12px; padding:15px; cursor:pointer; text-align:center; transition:all 0.2s; background:white;">
            <div style="font-size:28px; margin-bottom:8px; color:var(--gold-main);"><i class="fas fa-{{ $kat->icon ?? 'coffee' }}"></i></div>
            <div style="font-weight:700; font-size:13px; color:var(--primary-dark); margin-bottom:5px;">{{ $menu->nama_menu }}</div>
            <div style="color:var(--gold-main); font-weight:700; font-size:14px;">Rp {{ number_format($menu->harga,0,',','.') }}</div>
            <div style="font-size:11px; color:var(--neutral-light); margin-top:4px;">Stok: {{ $menu->stok }}</div>
        </div>
        @endforeach
    </div>
    @endif
    @endforeach
</div>

{{-- Keranjang --}}
<div style="position:sticky; top:20px;">
<div class="grid-card">
    <div class="grid-card-header">
        <div class="grid-card-title"><i class="fas fa-shopping-cart" style="color:var(--gold-main)"></i><h3>Keranjang</h3></div>
        <button type="button" onclick="clearCart()" class="action-btn action-btn-danger" style="padding:5px 12px; font-size:12px;">Kosongkan</button>
    </div>

    <div id="cartItems" style="min-height:100px; margin-bottom:20px;">
        <p id="emptyCart" style="text-align:center; color:var(--neutral-light); padding:20px;">Keranjang kosong</p>
    </div>

    <div style="border-top:1px solid rgba(212,175,55,0.1); padding-top:15px; margin-bottom:15px;">
        <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
            <span style="color:var(--neutral-light);">Subtotal</span>
            <span id="subtotalDisplay">Rp 0</span>
        </div>
        <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
            <span style="color:var(--neutral-light);">Pajak (3%)</span>
            <span id="pajakDisplay">Rp 0</span>
        </div>
        <div style="display:flex; justify-content:space-between; font-size:18px; font-weight:800; color:var(--gold-main);">
            <span>Total</span>
            <span id="totalDisplay">Rp 0</span>
        </div>
    </div>

    <div class="form-group">
        <label class="form-label">Nama Customer</label>
        <input type="text" name="nama_customer" class="form-control" placeholder="Kosongkan = Walk-in">
    </div>
    <div class="form-group">
        <label class="form-label">No. Meja</label>
        <input type="number" name="no_meja" class="form-control" placeholder="Kosongkan = Takeaway" min="1" max="99">
    </div>
    <div class="form-group">
        <label class="form-label">Catatan</label>
        <input type="text" name="catatan" class="form-control" placeholder="Less sugar, no ice, dll">
    </div>
    <div class="form-group" style="display:flex; align-items:center; gap:10px;">
        <input type="checkbox" name="eco_packaging" id="eco" value="1" style="width:18px; height:18px;">
        <label for="eco" style="color:var(--primary-dark); font-weight:600; cursor:pointer;">🌿 Eco Packaging (SDGS)</label>
    </div>

    <div id="itemsInput"></div>

    <button type="submit" id="btnCheckout" class="action-btn action-btn-primary" style="width:100%; justify-content:center; padding:15px; font-size:16px;" disabled>
        <i class="fas fa-check-circle"></i> Proses Transaksi
    </button>
</div>
</div>

</div>
</form>

<style>
.menu-card:hover { border-color:var(--gold-main)!important; transform:translateY(-3px); box-shadow:0 8px 20px rgba(212,175,55,0.2); }
</style>

@push('scripts')
<script>
let cart = {};
const stokMap = {};

function formatRp(n) {
    return 'Rp ' + n.toLocaleString('id-ID');
}

function addToCart(id, nama, harga, stok) {
    stokMap[id] = stok;
    if (!cart[id]) cart[id] = { nama, harga, qty: 0 };
    if (cart[id].qty >= stok) {
        alert('Stok ' + nama + ' tidak cukup!');
        return;
    }
    cart[id].qty++;
    renderCart();
}

function changeQty(id, delta) {
    if (!cart[id]) return;
    cart[id].qty += delta;
    if (cart[id].qty <= 0) delete cart[id];
    renderCart();
}

function clearCart() {
    cart = {};
    renderCart();
}

function renderCart() {
    const container = document.getElementById('cartItems');
    const empty     = document.getElementById('emptyCart');
    const itemsInput= document.getElementById('itemsInput');
    const btn       = document.getElementById('btnCheckout');

    const keys = Object.keys(cart);
    if (keys.length === 0) {
        container.innerHTML = '<p id="emptyCart" style="text-align:center;color:var(--neutral-light);padding:20px;">Keranjang kosong</p>';
        itemsInput.innerHTML = '';
        btn.disabled = true;
        document.getElementById('subtotalDisplay').textContent = 'Rp 0';
        document.getElementById('pajakDisplay').textContent = 'Rp 0';
        document.getElementById('totalDisplay').textContent = 'Rp 0';
        return;
    }

    let html = '';
    let inputs = '';
    let subtotal = 0;
    let i = 0;

    keys.forEach(id => {
        const item = cart[id];
        const sub  = item.harga * item.qty;
        subtotal  += sub;
        html += `<div style="display:flex;align-items:center;gap:10px;padding:10px 0;border-bottom:1px solid rgba(212,175,55,0.08);">
            <div style="flex:1;">
                <div style="font-weight:600;font-size:13px;">${item.nama}</div>
                <div style="color:var(--gold-main);font-size:12px;">${formatRp(sub)}</div>
            </div>
            <div style="display:flex;align-items:center;gap:8px;">
                <button type="button" onclick="changeQty(${id},-1)" style="width:28px;height:28px;border-radius:50%;border:1px solid rgba(212,175,55,0.3);background:white;cursor:pointer;font-weight:700;">-</button>
                <span style="font-weight:700;min-width:20px;text-align:center;">${item.qty}</span>
                <button type="button" onclick="changeQty(${id},1)" style="width:28px;height:28px;border-radius:50%;border:1px solid rgba(212,175,55,0.3);background:white;cursor:pointer;font-weight:700;">+</button>
            </div>
        </div>`;
        inputs += `<input type="hidden" name="items[${i}][id_menu]" value="${id}">`;
        inputs += `<input type="hidden" name="items[${i}][qty]" value="${item.qty}">`;
        i++;
    });

    const pajak = Math.round(subtotal * 0.03);
    const total = subtotal + pajak;

    container.innerHTML = html;
    itemsInput.innerHTML = inputs;
    btn.disabled = false;
    document.getElementById('subtotalDisplay').textContent = formatRp(subtotal);
    document.getElementById('pajakDisplay').textContent = formatRp(pajak);
    document.getElementById('totalDisplay').textContent = formatRp(total);
}
</script>
@endpush
@endsection