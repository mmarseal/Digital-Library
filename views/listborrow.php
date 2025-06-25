                <div id="label-page">
                    <h3>List Data Peminjaman</h3>
                </div>
                <div id="content">
                    <p id="tombol-tambah-container">
                        <a href="index.php?p=addborrow" class="tombol">Tambah Peminjaman</a>
                    </P>
                    <table id="tabel-tampil">
                        <tr>
                            <th id="label-tampil-no">No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Tipe</th>
                            <th>Tanggal Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                            <th id="label-opsi">Action</th>
                        </tr>
                        <?php
                            include "koneksi.php";
                            $dml = "SELECT a.member_id, a.firstname, a.lastname, a.email,
                            a.type, b.borrow_id, b.date_borrow, b.due_date, b.status 
                            FROM member as a
                            INNER JOIN borrow as b ON b.member_id = a.member_id";
                            $qry = mysqli_query($db, $dml);
                            $no = 1;

                            while($row = mysqli_fetch_array($qry)){
                                $id = $row['borrow_id'];
                        ?>
                        <tr>
                            <td><center><?php echo $no."."; ?><center></td>
                            <td><center><?php echo $row['firstname']." ".$row['lastname'] ?></center></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['type']; ?></td>
                            <td><?php echo $row['date_borrow']; ?></td>
                            <td><?php echo $row['due_date']; ?></td>
                            <td><?php echo $row['status'] == 1 ? "pinjam" : "selesai"; ?></td>
                            <td>
                                <div class="tombol-action-container">
                                    <a href="index.php?p=editborrow&id=<?php echo $id;?>" class="tombol">View Details</a>
                                </div>
                            </td>
                        </tr>
                        <?php $no++; }?>
                    </table>
                </div>