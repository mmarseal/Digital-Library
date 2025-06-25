                <div id="label-page">
                    <h3>List Book</h3>
                </div>
                <div id="content">
                    <p id="tombol-tambah-container">
                        <a href="index.php?p=addbook" class="tombol">add Book</a>
                    </P>
                    <table id="tabel-tampil">
                        <tr>
                            <th id="label-tampil-no">No.</th>
                            <th>Book Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Books Copies</th>
                            <th>Publish Year</th>
                            <th>Publisher</th>
                            <th>isbn</th>
                            <th>copyright year</th>
                            <th id="label-opsi">Action</th>
                        </tr>
                        <?php
                            include "koneksi.php";
                            $dml = "SELECT * FROM book ORDER BY book_title ASC";
                            $qry = mysqli_query($db, $dml);
                            $no = 1;

                            while($row = mysqli_fetch_array($qry)){
                                $id = $row['book_id'];
                        ?>
                        <tr>
                            <td><center><?php echo $no."."; ?><center></td>
                            <td><center><?php echo $row['book_title'] ?></center></td>
                            <td><?php echo $row['category']; ?></td>
                            <td><?php echo $row['author']; ?></td>
                            <td><?php echo $row['book_copies']; ?></td>
                            <td><?php echo $row['book_pub']; ?></td>
                            <td><?php echo $row['publisher_name']; ?></td>
                            <td><?php echo $row['isbn']; ?></td>
                            <td><?php echo $row['copyright_year']; ?></td>
                            <td>
                                <div class="tombol-action-container">
                                    <a href="index.php?p=editbook&id=<?php echo $id;?>" class="tombol">edit</a>
                                </div>
                                <div class="tombol-action-container">
                                    <a href="action/book_delete.php?id=<?php echo $id;?>" class="tombol" 
                                        onclick="return confirm('Yakin pengen di Hapus?')">Hapus</a>
                                </div>
                            </td>
                        </tr>
                        <?php $no++; }?>
                    </table>
                </div>