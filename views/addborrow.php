                
 <?php
    include "koneksi.php";
    $dml = "SELECT * FROM member ORDER BY firstname ASC";
    $qry = mysqli_query($db, $dml);
?>
                <div id="label-page">
                    <h3>Transaksi Peminjaman</h3>
                </div>
                <div id="content">
                    <div class="container">
                        <form method="post" action="action/borrow_save.php" enctype="multipart/form-data">
                            <table id="tabel-input">
                                <tr>
                                    <td class="label-formulir">Member: </td>
                                    <td class="isian-formulir">
                                        <select name="memberid" class="isian-formulir-select isian-formulir-border" required>
                                        <?php 
                                            while($row = mysqli_fetch_array($qry)){
                                                $id = $row['member_id'];
                                                echo "<option value='$id'>".$row['firstname']." ".$row['lastname']."</option>";
                                            }
                                        ?>    
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="label-formulir">Jatuh Tempo: </td>
                                    <td class="isian-formulir">
                                        <input type="date" name="duedate" class="isian-formulir isian-formulir-border" required>
                                    </td>
                                </tr>
                            </table>
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
                                    <th>Select</th>
                                </tr>
                                <?php
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
                                    <td><input type="checkbox" name="selector[]" value="<?php echo $id;?>"></td>
                                </tr>
                                <?php $no++; }?>
                            </table>
                            <div class="control-group">
                                <div class="controls">
                                    <button class="tombol" name="submit" type="submit">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>