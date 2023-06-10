<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $filename = "არა აქვს მიმაგრებული";

    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {

        $filename = uniqid()."_".$_FILES["file"]["name"];
        $uploadDir = "users_files/";
        $targetFile = $uploadDir . $filename;

        move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile);

        $content = "გადავხედე";
        $handle = fopen($targetFile, "a");

        fwrite($handle, $content);
        fclose($handle);
    }

    $userData = array(
        "flname" => $_POST["flname"],
        "applicant_type" => $_POST["applicant_type"],
        "position" => $_POST["position"],
        "email" => $_POST["email"],
        "country" => $_POST["country"],
        "city" => $_POST["city"],
        "address" => $_POST["address"],
        "phone" => $_POST["phone"],
        "product_type" => $_POST["product_type"],
        "comment" => $_POST["comment"],
        "filename" => $filename
    );

    $newComment = str_replace("თქვენი კომენტარი დაწერეთ აქ","ცარიელი",$userData["comment"]);

    $_SESSION['userData'] = $userData;
    setcookie('userData', serialize($userData), time() + 3600, '/');

    $data = "სახელი, გვარი: " . $userData["flname"] . "\n";
    $data .= "ინფორმაცია განმცხადებელზე: " . $userData["applicant_type"] . "\n";
    $data .= "პოზიცია: " . $userData["position"] . "\n";
    $data .= "ელ–ფოსტა: " . $userData["email"] . "\n";
    $data .= "ქვეყანა: " . $userData["country"] . "\n";
    $data .= "ქალაქი: " . $userData["city"] . "\n";
    $data .= "მისამართი: " . $userData["address"] . "\n";
    $data .= "ტელეფონი: " . $userData["phone"] . "\n";
    $data .= "პროდუქტი: " . $userData["product_type"] . "\n";
    $data .= "კომენტარი: " . $newComment . "\n";
    $data .= "მიმაგრებული ფაილის დასახელება: ".$userData["filename"] . "\n\n";

    $file = "orders.txt";

    file_put_contents($file, $data, FILE_APPEND);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo '<script>
            alert("ფორმა წარმატებით შეივსო!");
         </script>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href = "css/style.css">
    <title>RMP</title>
</head>
<body>
    <header>
        <div class = "menubar">
            <nav>
                <div class = "logo">
                    <img src = "images/logo.png" alt = "Logo">
                </div>
                <ul>
                    <li><a href = "index.html">მთავარი</a></li>
                    <li><a href = "about.html">კომპანიის შესახებ</a></li>
                    <li><a href = "products-and-services.html">პროდუქტები და სერვისები</a></li>
                    <li><a href = "quality-managment.html">ხარისხის მართვა</a></li>
                    <li><a href = "product-order.php">პროდუქციის შეკვეთა</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main class = "center">  
        <div class = "input">
            <img src = "images/product-order.jpg" alt = "Product order">
            <h2>პროდუქციის შეკვეთა</h2>
            <h3>ინფორმაცია დამკვეთზე</h3>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                <label for="flname">სახელი, გვარი</label>
                <input type = "text" name = "flname"><br>
                <label for = "applicant_type">ინფორმაცია განმცხადებელზე</label>
                <select name = "applicant_type">
                    <option value = "organization">ორგანიზაცია</option>
                    <option value = "person">კერძო პირი</option>
                </select><br>
                <label for="position">პოზიცია</label>
                <input type = "text" name = "position"><br>
                <label for="email">ელ–ფოსტა</label>
                <input type = "email" name = "email"><br>
                <label for="country">ქვეყანა</label>
                <input type = "text" name = "country"><br>
                <label for="city">ქალაქი</label>
                <input type = "text" name = "city"><br>
                <label for="address">მისამართი</label>
                <input type = "text" name = "address"><br>
                <label for="phone">ტელეფონი</label>
                <input type = "text" name = "phone"><br>

                 <h3>ინფორმაცია შეკვეთაზე</h3>

                <label for = "product_type">პროდუქტი</label>
                <select name = "product_type">
                    <option value = "rebar">არმატურა</option>
                    <option value = "billets">კვადრატული ნამზადი</option>
                    <option value = "pipes">უნაკერო მილები</option>
                    <option value = "tuji">თუჯის სხმულები</option>
                    <option value = "slag">კირქვა</option>
                    <option value = "mechanical_details">მექანიკური დეტალები</option>
                    <option value = "msxmuli">ფასონური სხმულები</option>
                    <option value = "litonkonstruqcia">ლითონკონსტრუქციები</option>
                    <option value = "granulated_slug">გრანულირებული წიდა</option>
                    <option value = "limestone">ფეროშენადნობები</option>
                </select><br>
                <label for = "comment">კომენტარი</label>
                <textarea name = comment>თქვენი კომენტარი დაწერეთ აქ</textarea><br>
                <label for="file">ატვირთეთ ფაილი:</label>
                <input type="file" name="file" accept="text/plain"><br>
                <input type="submit" value="Submit">
            </form>
        </div>
    </main>     
    <footer>
        <p>1948-2023 რუსთავის მეტალურგიული ქარხანა.</p>
        <div class = "contact">
            <h3>კონტაქტი:</h3>
            <p>მისამართი: გაგარინის ქ. 12, 3700 რუსთავი, საქართველო</p>
            <p>ტელეფონი: +995 32 260 66 99, +995 32 249 22 33</p>
            <p>ელ. ფოსტა: contacts@rustavisteel.ge</p>
        </div>
    </footer>
</body>
</html>