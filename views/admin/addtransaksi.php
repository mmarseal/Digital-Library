<?php
include "koneksi.php";

$members_query = mysqli_query($conn, "SELECT member_id, firstname, lastname FROM member ORDER BY firstname ASC");
$books_query = mysqli_query($conn, "SELECT book_id, book_title FROM book WHERE status = 1 ORDER BY book_title ASC");

$default_borrow_date = date('Y-m-d');
$default_due_date = date('Y-m-d', strtotime('+7 days'));
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1>Tambah Transaksi Peminjaman</h1></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="admin.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="admin.php?p=listtransaksi">Data Transaksi</a></li>
                    <li class="breadcrumb-item active">Tambah Transaksi</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header"><h3 class="card-title">Form Peminjaman Buku</h3></div>
                    <form method="post" action="action/transaksi_save.php">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="member_id">Pilih Anggota Peminjam</label>
                                <select class="form-control" id="member_id" name="member_id" required>
                                    <option value="">-- Pilih Anggota --</option>
                                    <?php while ($member = mysqli_fetch_assoc($members_query)): ?>
                                        <option value="<?= $member['member_id']; ?>">
                                            <?= htmlspecialchars($member['firstname'] . ' ' . $member['lastname']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="book_ids">Pilih Buku yang Dipinjam</label>
                                <p class="text-muted small">Tahan tombol Ctrl (atau Cmd di Mac) untuk memilih lebih dari satu buku.</p>
                                <select class="form-control" id="book_ids" name="book_ids[]" multiple required size="10">
                                    <?php while ($book = mysqli_fetch_assoc($books_query)): ?>
                                        <option value="<?= $book['book_id']; ?>">
                                            <?= htmlspecialchars($book['book_title']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date_borrow">Tanggal Pinjam</label>
                                        <input type="date" class="form-control" id="date_borrow" name="date_borrow" value="<?= $default_borrow_date; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="due_date">Tanggal Jatuh Tempo</label>
                                        <input type="date" class="form-control" id="due_date" name="due_date" value="<?= $default_due_date; ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" name="submit" class="btn btn-primary">Simpan Transaksi</button>
                            <a href="admin.php?p=listtransaksi" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
