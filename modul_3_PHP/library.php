<?php
// Fungsi login user
function login()
{
    include 'variable.php';
    echo '<fieldset><legend>Login</legend>';
    
    $unam = GET('unam', '');
    $pswd = GET('pswd', '');

    // Cek username dan password
    if($unam != '' && $pswd != '')
    {
        for($i = 0; $i < sizeof($user); $i++)
        {
            $dat1 = $user[$i][0]; // username
            $dat2 = $user[$i][1]; // password
            $dat3 = $user[$i][2]; // rank

            if($unam == $dat1 && $pswd == $dat2)
            {
                // Set session dan redirect
                SetSession('login', $dat1);
                SetSession('rank', $dat3);
                header('Location: ?');
            }
        }
    }

    // Form login
    echo '<form name="forml" method="post">';
    echo '<table>';
    echo '<tr><th>Username</th><td><input type="text" name="unam"></td></tr>';
    echo '<tr><th>Password</th><td><input type="password" name="pswd"></td></tr>';
    echo '<tr><th></th><td><input type="submit" value="login"></td></tr>';
    echo '</table>';
    echo '</form>';
    echo '</fieldset>';
}

// Fungsi untuk mendapatkan nilai dari SESSION, POST, atau GET
function GET($key, $value)
{
    $res = isset($_SESSION[$key]) && $_SESSION[$key] != '' ? $_SESSION[$key] : $value;
    $res = isset($_POST[$key]) && $_POST[$key] != '' ? $_POST[$key] : $res;
    $res = isset($_GET[$key]) && $_GET[$key] != '' ? $_GET[$key] : $res;
    return $res;
}

// Fungsi set session
function SetSession($key, $value)
{
    $_SESSION[$key] = $value;
}

// Fungsi tambah file baru
function AddFile()
{
    include 'variable.php';
    echo '<fieldset><legend>Tambah File</legend>';

    $fnam = GET('fnam', '');
    $cntn = GET('cntn', '');

    if ($fnam != '' && $cntn != '')
    {
        // Cek dan buat folder jika belum ada
        if (!is_dir($folder)) {
            if (!mkdir($folder, 0755)) {
                echo "Gagal membuat folder.";
                return;
            }
        }

        // Coba buka file untuk ditulis
        $filePath = $folder . '/' . $fnam;
        $file = fopen($filePath, 'w');

        if ($file) {
            fwrite($file, $cntn);
            fclose($file);

            // Pastikan file berhasil dibuat
            if (file_exists($filePath)) {
                header('Location: ?');
                exit;
            } else {
                echo "File gagal ditulis.";
            }
        } else {
            echo "Gagal membuka file untuk ditulis.";
        }
    }

    // Form tambah file
    echo '<form name="form1" method="post">';
    echo '<table>';
    echo '<tr><th>Nama File</th><td><input type="text" name="fnam"></td></tr>';
    echo '<tr><th>Konten</th><td><textarea name="cntn"></textarea></td></tr>';
    echo '<tr><th></th><td><input type="submit" value="tambah"></td></tr>';
    echo '</table>';
    echo '</form>';
    echo '</fieldset>';
}
// Fungsi menampilkan daftar file
function FileList()
{
    include 'variable.php';
    echo '<fieldset><legend>Daftar File</legend>';
    echo '<ol>';

    $file = glob($folder.'/*');

    // Tampilkan semua file dalam folder
    for($i = 0; $i < sizeof($file); $i++)
    {
        $item = basename($file[$i]);
        echo '<li>'.$item.' &bullet; <a href="'.$file[$i].'" target="_blank">Lihat</a></li>';
    }

    echo '</ol>';
    echo '</fieldset>';
}
?>
