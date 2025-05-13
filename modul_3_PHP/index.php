<?php
session_start();
require_once 'library.php';

$login = GET('login','');

echo '<h1>Manajemen File</h1>';

// Jika belum login, tampilkan daftar file dan form login
if($login == '')
{
    FileList();
    Login();
}
else
{
    // Proses logout jika diminta
    if(GET('logout',''))
    {
        SetSession('login','');
        SetSession('rank','');
        header('Location: ?');
    }

    // Tampilkan info login dan opsi logout
    echo 'Login Sebagai: '.$login.' (<a href="?logout=1">Logout</a>)';

    // Tampilkan daftar file dan form untuk menambah file
    FileList();
    AddFile();
}
?>
