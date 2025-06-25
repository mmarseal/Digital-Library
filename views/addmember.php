                <div id="label-page">
                    <h3>Add member</h3>
                </div>
                <div id="content">
                    <div class="container">
                        <form method="post" action="action/member_save.php" enctype="multipart/form-data">
                            <table id="tabel-input">
                                <tr>
                                    <td class="label-formulir">Firstname: </td>
                                    <td class="isian-formulir">
                                        <input type="text" name="firstname" class="isian-formulir isian-formulir-border" required>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="label-formulir">Lastname: </td>
                                    <td class="isian-formulir">
                                        <input type="text" name="lastname" class="isian-formulir isian-formulir-border" required>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="label-formulir">Email: </td>
                                    <td class="isian-formulir">
                                        <input type="email" name="email" class="isian-formulir isian-formulir-border" required>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="label-formulir">Gender: </td>
                                    <td class="isian-formulir">
                                        <input type="radio" name="gender" value="Male" class="isian-radio">Male
                                        <input type="radio" name="gender" value="Female" class="isian-radio">Female
                                       
                                    </td>
                                </tr>

                                <tr>
                                    <td class="label-formulir">Address: </td>
                                    <td class="isian-formulir">
                                        <input type="text" name="address" class="isian-formulir isian-formulir-border" required>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="label-formulir">Contact: </td>
                                    <td class="isian-formulir">
                                        <input type="text" name="contact" class="isian-formulir isian-formulir-border" required>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="label-formulir">Type: </td>
                                    <td class="isian-formulir">
                                        <select name="type" class="isian-formulir-select isian-formulir-border" required>
                                            <option>Student</option>
                                            <option>Teacher</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <div class="control-group">
                                <div class="controls">
                                    <button class="tombol" name="submit" type="submit">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>