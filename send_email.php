<?php
$to = "heanshedo.setiawan@gmail.com";
$from_name = $_POST['name'];
$from_email = $_POST['email'];
$subject = "File Upload dari $from_name";

// Periksa apakah file diunggah
if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_name = $_FILES['file']['name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];

    $content = chunk_split(base64_encode(file_get_contents($file_tmp)));
    $uid = md5(uniqid(time()));
    $name = basename($file_name);

    $header = "From: $from_name <$from_email>\r\n";
    $header .= "Reply-To: $from_email\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"$uid\"\r\n\r\n";
    $header .= "--$uid\r\n";
    $header .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $header .= "Nama: $from_name\nEmail: $from_email\n\nLihat file terlampir.\r\n\r\n";
    $header .= "--$uid\r\n";
    $header .= "Content-Type: $file_type; name=\"$name\"\r\n";
    $header .= "Content-Transfer-Encoding: base64\r\n";
    $header .= "Content-Disposition: attachment; filename=\"$name\"\r\n\r\n";
    $header .= $content . "\r\n\r\n";
    $header .= "--$uid--";

    if (mail($to, $subject, "", $header)) {
        echo "Email dengan file berhasil dikirim.";
    } else {
        echo "Gagal mengirim email.";
    }
} else {
    echo "Tidak ada file yang diunggah atau terjadi kesalahan.";
}
?>
