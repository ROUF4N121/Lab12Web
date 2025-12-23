<?php
include_once 'koneksi.php';

// 1. Logika Pencarian (Praktikum 14) 
$q = "";
$sql_where = "";
if (isset($_GET['submit']) && !empty($_GET['q'])) {
    $q = $_GET['q'];
    $sql_where = " WHERE nama LIKE '{$q}%'";
}

// 2. Logika Pagination (Praktikum 13) 
$sql_count = "SELECT COUNT(*) FROM data_barang" . $sql_where;
$result_count = mysqli_query($conn, $sql_count);
$r_data = mysqli_fetch_row($result_count);
$count = $r_data[0];

$per_page = 2; // Data per halaman
$num_page = ceil($count / $per_page);
$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
$offset = ($page - 1) * $per_page;

// Query Utama
$sql = "SELECT * FROM data_barang" . $sql_where . " LIMIT {$offset}, {$per_page}";
$result = mysqli_query($conn, $sql);

include_once 'header.php';
?>

<div class="main">
    <a href="#" class="btn btn-primary">Tambah Barang</a>

    <form action="" method="get" style="margin: 20px 0;">
        <label for="q">Cari data: </label>
        <input type="text" id="q" name="q" value="<?php echo $q; ?>" placeholder="Masukkan nama...">
        <input type="submit" name="submit" value="Cari" class="btn btn-primary">
    </form>

    <?php if ($result): ?>
    <table>
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Harga Jual</th>
                <th>Harga Beli</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_array($result)): ?>
            <tr>
                <td><?php echo $row['nama']; ?></td>
                <td><?php echo $row['kategori']; ?></td>
                <td><?php echo number_format($row['harga_jual'], 0, ',', '.'); ?></td>
                <td><?php echo number_format($row['harga_beli'], 0, ',', '.'); ?></td>
                <td><?php echo $row['stok']; ?></td>
                <td>
                    <a href="#" class="btn btn-edit">Edit</a>
                    <a href="#" class="btn btn-delete" onclick="return confirm('Hapus data?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <ul class="pagination">
        <li><a href="?page=<?php echo ($page > 1) ? $page - 1 : 1; ?>&q=<?php echo $q; ?>">&laquo;</a></li>
        
        <?php for ($i=1; $i <= $num_page; $i++): ?>
            <?php 
                $link = "?page={$i}";
                if (!empty($q)) $link .= "&q={$q}";
                $class = ($page == $i ? 'active' : '');
            ?>
            <li><a class="<?php echo $class; ?>" href="<?php echo $link; ?>"><?php echo $i; ?></a></li>
        <?php endfor; ?>
        
        <li><a href="?page=<?php echo ($page < $num_page) ? $page + 1 : $num_page; ?>&q=<?php echo $q; ?>">&raquo;</a></li>
    </ul>
    <?php endif; ?>
</div>

<?php include_once 'footer.php'; ?>