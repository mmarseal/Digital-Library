<?php
include'koneksi.php';
     $idx = isset($_GET['id']) ? $_GET['id'] : "";
     $dml = "SELECT * FROM member WHERE member_id = '$idx'";
     $qry = mysqli_query($db, $dml);
     $row = mysqli_fetch_array($qry);
?>                
                <div id="label-page">
                    <h3>Edit member</h3>
                </div>
                <div id="content">
                    <div class="container">
                        <form method="post" action="action/member_save.php" enctype="multipart/form-data">
                            <table id="tabel-input">
                                <tr>
                                    <td class="label-formulir">Firstname: </td>
                                    <td class="isian-formulir">
                                        <input type="text" value="<?php echo $row['firstname'];?>" name="firstname" class="isian-formulir isian-formulir-border" required>
                                        <input type="hidden" name="id" value="<?php echo $idx ?>">
                                    </td>
                                </tr>

                                <tr>
                                    <td class="label-formulir">Lastname: </td>
                                    <td class="isian-formulir">
                                        <input type="text" value="<?php echo $row['lastname'];?>" name="lastname" class="isian-formulir isian-formulir-border" required>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="label-formulir">Email: </td>
                                    <td class="isian-formulir">
                                        <input type="email" value="<?php echo $row['email'];?>" name="email" class="isian-formulir isian-formulir-border" required>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="label-formulir">Gender: </td>
                                    <td class="isian-formulir">
                                        <select name="gender" class="isian-formulir-select isian-formulir-border" required>
                                        <?php if($row['gender'] = "Male"){
                                            echo "<option selected>Male</option>
                                                <option>Female</option>";
                                        }else{
                                            echo "<option>Male</option>
                                                <option selected>Female</option>";
                                        }
                                        ?>        
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="label-formulir">Address: </td>
                                    <td class="isian-formulir">
                                        <input type="text" value="<?php echo $row['address'];?>" name="address" class="isian-formulir isian-formulir-border" required>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="label-formulir">Contact: </td>
                                    <td class="isian-formulir">
                                        <input type="text" value="<?php echo $row['contact'];?>" name="contact" class="isian-formulir isian-formulir-border" required>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="label-formulir">Type: </td>
                                    <td class="isian-formulir">
                                        <select name="type" class="isian-formulir-select isian-formulir-border" required>
                                        <?php if($row['type'] = "Student"){
                                            echo "<option selected>Student</option>
                                                <option>Teacher</option>";
                                        }else{
                                            echo "<option>Student</option>
                                                <option selected>Teacher</option>";
                                        }
                                        ?>        
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <div class="control-group">
                                <div class="controls">
                                    <button class="tombol" name="submit" type="submit">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>