                
 <?php
    include "koneksi.php";
    $idx = isset($_GET['id']) ? $_GET['id'] : "";
    $dml = "SELECT * FROM borrow JOIN member ON borrow.member_id = member.member_id WHERE 
            borrow_id = '$idx'";
    $qry = mysqli_query($db, $dml);
    $row = mysqli_fetch_array($qry);
?>
                <div id="label-page">
                    <h3>Transaksi Pengembalian Buku</h3>
                </div>
                <div id="content">
                    <div class="container">
                        <form method="post" action="action/borrow_save.php" enctype="multipart/form-data">
                            <table id="tabel-input">
                                <tr>
                                    <td class="label-formulir">Member: </td>
                                    <td class="isian-formulir">
                                        <select name="memberid" class="isian-formulir-select isian-formulir-border" required disabled>
                                        <?php 
                                            echo "<option value='".$row['member_id']."'>".$row['firstname']." ".$row['lastname']."</option>";
                                        ?>    
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="label-formulir">Jatuh Tempo: </td>
                                    <td class="isian-formulir">
                                        <input type="date" value="<?php echo $row['due_date'];?>" name="duedate" class="isian-formulir isian-formulir-border" required>
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
                                    <th>date Return</th>
                                    <th>Status</th>
                                    <th>action</th>
                                </tr>
                                <?php
                                    $dml = "SELECT * FROM borrowdetails JOIN book 
                                            ON borrowdetails.book_id = book.book_id 
                                            WHERE borrow_id = '$idx'";
                                    $qry = mysqli_query($db, $dml);
                                    $no = 1;

                                    while($row = mysqli_fetch_array($qry)){
                                        $id = $row['borrow_details_id'];
                                ?>
                                <tr>
                                    <td><center><?php echo $no."."; ?><center></td>
                                    <td><center><?php echo $row['book_title'] ?></center></td>
                                    <td><?php echo $row['category']; ?></td>
                                    <td><?php echo $row['author']; ?></td>
                                    <td><?php echo $row['book_copies']; ?></td>
                                    <td><?php echo $row['book_pub']; ?></td>
                                    <td><?php echo $row['publisher_name']; ?></td>
                                    <td><?php echo $row['date_return']; ?></td>
                                    <td><?php echo $row['borrow_status'] == 1 ? "Dipinjam" : "Dikembalikan"; ?></td>
                                    <td>
                                        <a href="action/returnbook.php?id=<?php echo $id;?>&idx=<?php echo $idx;?>" class="tombol">Kembalikan</a>
                                    </td>
                                </tr>
                                <?php $no++; }?>
                            </table>
                            <div class="control-group">
                                <div class="controls">
                                    <a href="index.php?p=listborrow" class="tombol">Back</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>