                <div id="label-page">
                    <h3>List Data Member</h3>
                </div>
                <div id="content">
                    <p id="tombol-tambah-container">
                        <a href="index.php?p=addmember" class="tombol">add Member</a>
                    </P>
                    <table id="tabel-tampil">
                        <tr>
                            <th id="label-tampil-no">No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Contact</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th id="label-opsi">Action</th>
                        </tr>
                        <?php
                            include "koneksi.php";
                            $dml = "SELECT * FROM member ORDER BY firstname ASC";
                            $qry = mysqli_query($db, $dml);
                            $no = 1;

                            while($row = mysqli_fetch_array($qry)){
                                $id = $row['member_id'];
                        ?>
                        <tr>
                            <td><center><?php echo $no."."; ?><center></td>
                            <td><center><?php echo $row['firstname']." ".$row['lastname'] ?></center></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['gender']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td><?php echo $row['contact']; ?></td>
                            <td><?php echo $row['type']; ?></td>
                            <td><?php echo $row['status'] == 1 ? "Active" : "Inactive"; ?></td>
                            <td>
                                <div class="tombol-action-container">
                                    <a href="index.php?p=editmember&id=<?php echo $id;?>" class="tombol">edit</a>
                                </div>
                                <div class="tombol-action-container">
                                    <a href="action/member_delete.php?id=<?php echo $id;?>" class="tombol" 
                                        onclick="return confirm('Yakin pengen di Hapus?')">Hapus</a>
                                </div>
                            </td>
                        </tr>
                        <?php $no++; }?>
                    </table>
                </div>