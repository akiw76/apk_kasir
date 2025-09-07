<?php
include '../fungsi/autentikasi.php';
cekLogin();
include '../config/koneksi.php';

// Ambil data produk untuk dropdown
$query_produk = "SELECT ProdukID, NamaProduk, Harga, Stok FROM produk WHERE Stok > 0";
$result_produk = mysqli_query($koneksi, $query_produk);

// Ambil data pelanggan untuk dropdown
$query_pelanggan = "SELECT PelangganID, NamaPelanggan FROM pelanggan WHERE PelangganID != 1";
$result_pelanggan = mysqli_query($koneksi, $query_pelanggan);

include '../template/header.php';
?>

<div class="container my-4">
  <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
    <div class="card-header bg-gradient bg-primary text-white text-center py-3">
      <h3 class="mb-0 fw-bold">🛒 Transaksi Penjualan</h3>
    </div>
    <div class="card-body p-4">

      <!-- Form Transaksi -->
      <form action="../proses/proses_penjualan.php" method="POST" class="needs-validation" novalidate>

        <!-- Pilih Pelanggan -->
        <div class="mb-4">
          <label class="form-label fw-semibold">👤 Pelanggan</label>
          <select name="pelanggan_id" class="form-select shadow-sm rounded-3">
            <option value="1" selected>-- Pilih Pelanggan --</option>
            <?php while($row_pelanggan = mysqli_fetch_assoc($result_pelanggan)): ?>
              <option value="<?= $row_pelanggan['PelangganID']; ?>">
                <?= $row_pelanggan['NamaPelanggan']; ?>
              </option>
            <?php endwhile; ?>
          </select>
        </div>

        <!-- Pilih Barang -->
        <h5 class="fw-bold text-secondary mb-3">📦 Pilih Barang</h5>
        <div class="row g-3 mb-4">
          <div class="col-md-5">
            <label class="form-label">Produk</label>
            <select id="produk_input" class="form-select shadow-sm rounded-3">
              <option value="">-- Pilih Produk --</option>
              <?php mysqli_data_seek($result_produk, 0); ?>
              <?php while($row_produk = mysqli_fetch_assoc($result_produk)): ?>
                <option value="<?= $row_produk['ProdukID']; ?>"
                        data-harga="<?= $row_produk['Harga']; ?>"
                        data-nama="<?= $row_produk['NamaProduk']; ?>"
                        data-stok="<?= $row_produk['Stok']; ?>">
                  <?= $row_produk['NamaProduk']; ?> (Stok: <?= $row_produk['Stok']; ?>)
                </option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Jumlah</label>
            <input type="number" id="jumlah_input" class="form-control shadow-sm rounded-3" min="1" value="1">
          </div>
          <div class="col-md-4 d-flex align-items-end">
            <button type="button" class="btn btn-primary w-100 shadow-sm rounded-3" id="tambah-keranjang">
              ➕ Tambah ke Keranjang
            </button>
          </div>
        </div>

        <!-- Keranjang Belanja -->
        <h5 class="fw-bold text-secondary mb-3">🛍 Keranjang Belanja</h5>
        <div class="table-responsive mb-4">
          <table class="table table-bordered table-hover align-middle shadow-sm rounded-3 overflow-hidden">
            <thead class="table-primary text-center">
              <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody id="keranjang-body" class="text-center"></tbody>
            <tfoot class="fw-bold">
              <tr>
                <td colspan="3" class="text-end">Total Harga</td>
                <td colspan="2" class="text-success fs-5" id="total-harga-display">Rp 0</td>
              </tr>
            </tfoot>
          </table>
        </div>

        <!-- Input Hidden -->
        <div id="keranjang-inputs"></div>
        <input type="hidden" name="total_harga" id="total_harga">

        <!-- Simpan Transaksi -->
        <button type="submit" class="btn btn-success w-100 py-2 shadow-sm rounded-3 fw-bold" id="simpan-transaksi" disabled>
          💾 Simpan Transaksi
        </button>
      </form>
    </div>
  </div>
</div>

<!-- Tombol Kembali -->
<div class="container my-3">
  <div class="p-3 bg-danger text-white rounded-3 d-flex align-items-center justify-content-center shadow-sm" 
       style="cursor:pointer; max-width:200px;" onclick="history.back()">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="me-2" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H3.707l3.147 
      3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 
      0-.708l4-4a.5.5 0 1 1 .708.708L3.707 
      7.5H14.5A.5.5 0 0 1 15 8z"/>
    </svg>
    <span class="fw-bold">Kembali</span>
  </div>
</div>

<?php include '../template/footer.php'; ?>

<script>
$(document).ready(function() {
  let keranjang = {};

  function hitungTotal() {
    let total = 0;
    for (const id in keranjang) {
      total += keranjang[id].subtotal;
    }
    $('#total-harga-display').text('Rp ' + total.toLocaleString('id-ID'));
    $('#total_harga').val(total);

    if (Object.keys(keranjang).length > 0) {
      $('#simpan-transaksi').removeAttr('disabled');
    } else {
      $('#simpan-transaksi').attr('disabled', 'disabled');
    }
  }

  function renderKeranjang() {
    $('#keranjang-body').empty();
    $('#keranjang-inputs').empty();

    for (const id in keranjang) {
      const item = keranjang[id];
      const row = `
        <tr>
          <td>${item.nama}</td>
          <td>Rp ${item.harga.toLocaleString('id-ID')}</td>
          <td>
            <input type="number" class="form-control form-control-sm shadow-sm rounded-3 jumlah-keranjang" 
                   data-id="${item.id}" value="${item.jumlah}" min="1" max="${item.stok}">
          </td>
          <td>Rp ${item.subtotal.toLocaleString('id-ID')}</td>
          <td>
            <button type="button" class="btn btn-danger btn-sm shadow-sm hapus-keranjang rounded-3" data-id="${item.id}">
              Hapus
            </button>
          </td>
        </tr>
      `;
      $('#keranjang-body').append(row);

      const inputHidden = `
        <input type="hidden" name="produk_id[]" value="${item.id}">
        <input type="hidden" name="jumlah[]" value="${item.jumlah}">
      `;
      $('#keranjang-inputs').append(inputHidden);
    }
    hitungTotal();
  }

  // Tambah ke keranjang
  $('#tambah-keranjang').click(function() {
    const produkInput = $('#produk_input');
    const jumlahInput = $('#jumlah_input');

    const produkID = produkInput.val();
    const jumlah = parseInt(jumlahInput.val());
    const harga = parseFloat(produkInput.find('option:selected').data('harga'));
    const nama = produkInput.find('option:selected').data('nama');
    const stok = parseInt(produkInput.find('option:selected').data('stok'));

    if (produkID && jumlah > 0 && jumlah <= stok) {
      if (keranjang[produkID]) {
        const newJumlah = keranjang[produkID].jumlah + jumlah;
        if (newJumlah > stok) {
          alert('Jumlah melebihi stok yang tersedia!');
          return;
        }
        keranjang[produkID].jumlah = newJumlah;
        keranjang[produkID].subtotal = newJumlah * harga;
      } else {
        keranjang[produkID] = {
          id: produkID,
          nama: nama,
          harga: harga,
          jumlah: jumlah,
          stok: stok,
          subtotal: harga * jumlah
        };
      }
      renderKeranjang();
    } else if (jumlah > stok) {
      alert('Jumlah melebihi stok yang tersedia!');
    } else {
      alert('Silakan pilih produk dan jumlah yang valid.');
    }
  });

  // Hapus item keranjang
  $(document).on('click', '.hapus-keranjang', function() {
    const produkID = $(this).data('id');
    delete keranjang[produkID];
    renderKeranjang();
  });

  // Update jumlah keranjang
  $(document).on('change', '.jumlah-keranjang', function() {
    const produkID = $(this).data('id');
    const newJumlah = parseInt($(this).val());
    const stok = keranjang[produkID].stok;

    if (newJumlah <= 0 || newJumlah > stok) {
      alert('Jumlah tidak valid atau melebihi stok!');
      $(this).val(keranjang[produkID].jumlah);
      return;
    }

    keranjang[produkID].jumlah = newJumlah;
    keranjang[produkID].subtotal = newJumlah * keranjang[produkID].harga;
    renderKeranjang();
  });
});
</script>
