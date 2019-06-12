<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=PT+Sans|Roboto+Slab&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <Title>ASHIAV - Sistem Informasi Avengers!</Title>
    <link href="css/style.css" rel="stylesheet" type="text/css">
<style>

</style>
</head>
<body>
<div id="header">
    <img id="img-header" src="img/avengers.png"/>
    <span id="title-header"><b>ASHIAV</b></span>
    <span id="subtitle-header">Sistem Informasi Avengers</span>
</div>
<hr>

<h2>Masukkan nama Avengers!~~</h2>
    <p>Isi nama, posisi, email, dan nomor telepon dari Avengers. Kemudian tekan tombol <b><i>Submit</i></b> untuk menambahkan.</p>
    <form method="post" action="index.php" enctype="multipart/form-data" >
        
        <div class=form-group>
            <label for="name">Nama</label>  
            <td><input type="text" name="name" id="name" data-validation="length" data-validation-length="min8"/></br></br></td>
        </div>
        <tr>
            <td>Posisi</td> 
            <td><input type="text" name="position" id="position" data-validation="length" data-validation-length="min5"/></br></br></td>
        </tr>
        <tr>
            <td>E-mail</td> 
            <td><input type="text" name="email" id="email" data-validation="email"/></br></br></td>
        </tr>
        <tr>
            <td>Nomor Telepon</td> 
            <td><input type="text" name="phone" id="phone" data-validation="custom" data-validation-regexp="(\()?(\+62|62|0)(\d{2,3})?\)?[ .-]?\d{2,4}[ .-]?\d{2,4}[ .-]?\d{2,4}"/></br></br></td>
        </tr>

        <button type="submit" name="submit" value="Submit"><i class="fa fa-paper-plane"></i> Submit</button>
        
    </form>
    <hr>
    <form method="post" action="index.php" enctype="multipart/form-data" >
    <button type="submit" name="load_data" value="Load Data"><i class="fa fa-sync"></i> Load Data</button>
    </form>
    <?php
        include 'dbconn.php';
        $registrants = "";
        $isLoaded = false;
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
                    echo "<h2>Avengers yang telah terdaftar</h2>";
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
                        echo "<td>".date('Y-m-d', strtotime($registrant['date_joined']))."</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<h3>Belum ada nama yang terdaftar sebagai Avengers.</h3>";
                }
            } catch(Exception $e) {
                echo "Failed: " . $e;
            }
        } else if($isLoaded == false){
            echo "Data belum di-<i>load</i>. Silahkan tekan tombol <i>Load Data</i>";
        }
    ?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script>
  $.validate({
    lang: 'en'
  });
</script>
</body>
</html>