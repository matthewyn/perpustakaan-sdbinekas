<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Buku</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        button { padding: 5px 10px; margin-right: 5px; }
        form { display: inline; }
    </style>
</head>
<body>
    <h1>Daftar Buku</h1>

    <!-- Tombol Tambah Buku -->
    <button onclick="document.getElementById('addForm').style.display='block'">Tambah Buku</button>

    <!-- Form Tambah Buku -->
    <div id="addForm" style="display:none; margin-top:20px;">
        <h3>Tambah Buku</h3>
        <form action="/buku/add" method="post" enctype="multipart/form-data">
            <label>Code: <input type="text" name="code" required></label><br>
            <label>Title: <input type="text" name="title" required></label><br>
            <label>Author: <input type="text" name="author"></label><br>
            <label>Genre: <input type="text" name="genre"></label><br>
            <label>Illustrator: <input type="text" name="illustrator"></label><br>
            <label>Publisher: <input type="text" name="publisher"></label><br>
            <label>Series: <input type="text" name="series"></label><br>
            <label>Quantity: <input type="number" name="quantity" min="1"></label><br>
            <label>Notes: <input type="text" name="notes"></label><br>
            <label>Shelf Position: <input type="text" name="shelfPosition"></label><br>
            <label>Synopsis: <textarea name="synopsis"></textarea></label><br>
            <label>Is In Class: <input type="checkbox" name="isInClass" value="1"></label><br>
            <label>Year: <input type="text" name="year"></label><br>
            <label>Image: <input type="file" name="image"></label><br>
            <button type="submit">Simpan</button>
            <button type="button" onclick="document.getElementById('addForm').style.display='none'">Batal</button>
        </form>

        <!-- Tombol Analisis Otomatis dari Python -->
            <form action="/python/analyze" method="post" style="display:inline;">
                <button type="submit">Analisis Gambar Buku (Python)</button>
            </form>
    </div>

    <div style="margin-top:20px;">
        <h3>Import Buku dari JSON</h3>
        <form action="/buku/importJson" method="post" enctype="multipart/form-data">
            <input type="file" name="json_file" accept=".json" required>
            <button type="submit">Import JSON</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Title</th>
                <th>Author</th>
                <th>Genre</th>
                <th>Quantity</th>
                <th>Year</th>
                <th>Buku 1 Hari</th>
                <th>Tersedia</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($books as $book): ?>
            <tr>
                <td><?= htmlspecialchars($book['code']) ?></td>
                <td><?= htmlspecialchars($book['title']) ?></td>
                <td><?= htmlspecialchars($book['author']) ?></td>
                <td><?= htmlspecialchars($book['genre']) ?></td>
                <td><?= htmlspecialchars($book['quantity']) ?></td>
                <td><?= htmlspecialchars($book['year']) ?></td>
                <td><?= !empty($book['isOneDayBook']) ? 'Ya' : 'Tidak' ?></td>
                <td><?= !empty($book['available']) ? 'Ya' : 'Tidak' ?></td>
                <td>
                    <!-- Edit -->
                    <button onclick="showEditForm(
                        '<?= $book['code'] ?>',
                        '<?= htmlspecialchars($book['title']) ?>',
                        '<?= htmlspecialchars($book['author']) ?>',
                        '<?= htmlspecialchars($book['genre']) ?>',
                        '<?= $book['illustrator'] ?>',
                        '<?= $book['publisher'] ?>',
                        '<?= $book['series'] ?>',
                        '<?= $book['quantity'] ?>',
                        '<?= htmlspecialchars($book['notes']) ?>',
                        '<?= htmlspecialchars($book['shelfPosition']) ?>',
                        '<?= htmlspecialchars($book['synopsis']) ?>',
                        '<?= $book['isInClass'] ?>',
                        '<?= $book['year'] ?>'
                    )">Edit</button>

                    <!-- Hapus -->
                    <form action="/buku/delete?code=<?= urlencode($book['code']) ?>" method="post" onsubmit="return confirm('Yakin ingin hapus buku ini?')">
                        <button type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Form Edit Buku -->
    <div id="editForm" style="display:none; margin-top:20px;">
        <h3>Edit Buku</h3>
        <form id="editBookForm" action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="originalCode" id="originalCode">
            <label>Code: <input type="text" name="code" id="editCode" required></label><br>
            <label>Title: <input type="text" name="title" id="editTitle" required></label><br>
            <label>Author: <input type="text" name="author" id="editAuthor"></label><br>
            <label>Genre: <input type="text" name="genre" id="editGenre"></label><br>
            <label>Illustrator: <input type="text" name="illustrator" id="editIllustrator"></label><br>
            <label>Publisher: <input type="text" name="publisher" id="editPublisher"></label><br>
            <label>Series: <input type="text" name="series" id="editSeries"></label><br>
            <label>Quantity: <input type="number" name="quantity" id="editQuantity" min="1"></label><br>
            <label>Notes: <input type="text" name="notes" id="editNotes"></label><br>
            <label>Shelf Position: <input type="text" name="shelfPosition" id="editShelfPosition"></label><br>
            <label>Synopsis: <textarea name="synopsis" id="editSynopsis"></textarea></label><br>
            <label>Is In Class: <input type="checkbox" name="isInClass" id="editIsInClass" value="1"></label><br>
            <label>Year: <input type="text" name="year" id="editYear"></label><br>
            <label>Image: <input type="file" name="image"></label><br>
            <button type="submit">Update</button>
            <button type="button" onclick="document.getElementById('editForm').style.display='none'">Batal</button>
        </form>
    </div>

    <script>
        function showEditForm(code, title, author, genre, illustrator, publisher, series, quantity, notes, shelfPosition, synopsis, isInClass, year) {
            document.getElementById('editForm').style.display = 'block';
            document.getElementById('editBookForm').action = '/buku/edit/' + code;
            document.getElementById('originalCode').value = code;
            document.getElementById('editCode').value = code;
            document.getElementById('editTitle').value = title;
            document.getElementById('editAuthor').value = author;
            document.getElementById('editGenre').value = genre;
            document.getElementById('editIllustrator').value = illustrator;
            document.getElementById('editPublisher').value = publisher;
            document.getElementById('editSeries').value = series;
            document.getElementById('editQuantity').value = quantity;
            document.getElementById('editNotes').value = notes;
            document.getElementById('editShelfPosition').value = shelfPosition;
            document.getElementById('editSynopsis').value = synopsis;
            document.getElementById('editIsInClass').checked = isInClass == 1;
            document.getElementById('editYear').value = year;
        }
    </script>
</body>
</html>