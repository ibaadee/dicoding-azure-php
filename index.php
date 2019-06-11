<html>
<head>
    <Title>ASHIAV - Sistem Informasi Avengers!</Title>
    <link href="css/index.css" rel="stylesheet" type="text/css" media="all">
</head>
<body>
    <h1>Masukkan nama Avengers!</h1>
    <p>Isi nama, posisi, email, dan nomor telepon dari Avengers. Kemudian tekan tombol <strong>Submit</strong> untuk menambahkan.</p>
    <form method="post" action="index.php" enctype="multipart/form-data" >
        Nama  <input type="text" name="name" id="name"/></br></br>
        Posisi <input type="text" name="position" id="position"/></br></br>
        E-mail <input type="text" name="email" id="email"/></br></br>
        Nomor Telepon <input type="text" name="phone" id="phone"/></br></br>
        <input type="submit" name="submit" value="Submit" />
        <input type="submit" name="load_data" value="Load Data" />
    </form>

    <?php
        include 'dbconn.php';
        $registrants = "";
        try {
            $sql_select = "SELECT * FROM [dbo].[Users]";
            $stmt = $conn->query($sql_select);
            $registrants = $stmt->fetchAll(); 
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }
        if (isset($_POST['submit'])) {
            try {
                $name = $_POST['name'];
                $position = $_POST['position'];
                $phone = $_POST['phone'];
                $email = $_POST['email'];
                // Insert data
                $sql_insert = "INSERT INTO ibaddb.dbo.users (date_joined, email, name, phone, position, id) 
                               VALUES(current_timestamp, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql_insert);
                $stmt->bindValue(1, $email);
                $stmt->bindValue(2, $name);
                $stmt->bindValue(3, $phone);
                $stmt->bindValue(4, $position);
                $stmt->bindValue(5, count($registrants) + 1);
                $stmt->execute();
            } catch(Exception $e) {
                echo "Failed: " . $e;
            }
            echo "<h3>Avengers telah dimasukkan!</h3>";
        } else if (isset($_POST['load_data'])) {
            try {
                if(count($registrants) > 0) {
                    echo "<h2>People who are registered:</h2>";
                    echo "<table>";
                    echo "<tr><th>Nama</th>";
                    echo "<th>Posisi</th>";
                    echo "<th>Telepon</th>";
                    echo "<th>Email</th>";
                    echo "<th>Tanggal Bergabung</th></tr>";
                    foreach($registrants as $registrant) {
                        echo "<tr><td>".$registrant['name']."</td>";
                        echo "<td>".$registrant['position']."</td>";
                        echo "<td>".$registrant['phone']."</td>";
                        echo "<td>".$registrant['email']."</td>";
                        echo "<td>".$registrant['date_joined']."</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<h3>Belum ada nama yang terdaftar sebagai Avengers.</h3>";
                }
            } catch(Exception $e) {
                echo "Failed: " . $e;
            }
        }
    ?>
</body>
</html>