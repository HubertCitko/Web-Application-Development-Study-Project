<?php
require_once 'business.php';

function uploadImage(&$model){
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        $watermark = $_POST['watermark'] ?? '';
        $author = $_POST['author'] ?? '';
        $title = $_POST['title'] ?? '';
        $filename = uniqid();
        $visibility = isset($_SESSION['user_id']) ? ($_POST['visibility'] ?? 'public') : 'public';
        if (empty($watermark) || empty($author) || empty($title)){
            $model['error'] = 'Wszystkie pola są wymagane';
            return 'upload_view';
        }
        $file = $_FILES['photo'] ?? null;
        if (!$file || $file['error'] !== UPLOAD_ERR_OK ){
            $model['error'] = 'Bład podczas przesyłania pliku';
            return 'upload_view';
        }
        if ($file['size'] > 1024 * 1024){
            $model['error'] = 'Plik nie może przekraczać 1 MB';
            return 'upload_view';
        }
    
        $allowed_types = ['image/png', 'image/jpeg', 'image/jpg'];
        if(!in_array($file['type'], $allowed_types)){
            $model['error'] = 'Dozwolone pliki PNG i JPG';
            return 'upload_view';
        }
        $upload_dir = __DIR__ . '/web/images/';
        $file_path = $upload_dir . basename($filename);
        if (!move_uploaded_file($file['tmp_name'], ($file_path . '.jpg'))) {
            $model['error'] = "Nie udało się przesłać pliku.";

            return 'upload_view';
        }
        applyWatermark($file_path, $watermark);
        createThumbnail($file_path);

        $db = get_db();
        $db ->images->insertOne([
            'title' => $title,
            'author' => $author,
            'filename' => basename($filename),
            'watermarked' => basename($filename) . '_watermarked.jpg',
            'thumbnail' => basename($filename) . '_thumb.jpg',
            'visibility' => $visibility,

        ]);
        return 'redirect:/';
    }
    return 'upload_view';
}
function showGallery(&$model) { 
    
    $db = get_db();
    $images = $db -> images->find()->toArray();

    $model['images'] = $images;
    return 'gallery_view';
}
function registerUser(&$model) {
    if (isLoggedIn()) {
        return 'redirect:/';
    }
    
    $db = get_db();
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ??'';
        $repeat_password = $_POST['repeat_password'] ??'';
        $login = $_POST['login'] ??'';

        if(empty($email) || empty($password) || empty($repeat_password) || empty($login)){
            $model['error'] = 'Wszystkie pola są wymagane.';
            return 'register_view';
        }

        if ($password !== $repeat_password) {
            $model['error'] = 'Hasła muszą być takie same.';
            return 'register_view';
        }

        $existingUser = $db->users->findOne(['login' => $login]);
        if ($existingUser !== null) {
            $model['error'] = 'Podany login jest już zajęty.';
            return 'register_view';
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $db -> users -> insertOne(
            [
                'login' => $login,
                'email' => $email,
                'password' => $hashedPassword,
            ]);
        return 'redirect:/login';
    }
    return 'register_view';
}
function loginUser(&$model){
    if (isLoggedIn()) {
        return 'redirect:/';
    }
    
    $db = get_db();
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $login = $_POST['login'] ?? '';
        $password = $_POST['password'] ?? '';

        if(empty($login) || empty($password)){
            $model['error'] = 'Wszystkie pola są wymagane.';
            return 'login_view';
        }

        $user = $db->users->findOne(['login'=> $login]);
        if($user === null || !password_verify($password, $user->password)){
            $model['error'] = 'Nieprawidłowy login lub hasło.';
            return 'login_view';
        }
        session_regenerate_id();
        $_SESSION['user_id'] = (string)$user['_id'];
        $_SESSION['login'] = $login;
        return 'redirect:/';
    }
    return 'login_view';
}
function logoutUser(){
    $params = session_get_cookie_params();
    setcookie(session_name(),
    ''
    , time() - 42000,
    $params["path"], $params["domain"],
    $params["secure"], $params["httponly"]
    );
    session_unset();
    session_destroy();
    
    return 'redirect:/login';
}
function rememberImages(&$model){
    
    if ( $_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['remember'])) {
            $_SESSION['remembered'] = $_POST['remember'];
        } else {
            $_SESSION['remembered'] = [];
        }
        header('Location: /');
        exit;
    }
}
function showRemembered(&$model){
        if (!isLoggedIn()) {
            return 'redirect:/login';
        }
        $db = get_db();
        $rememberedIds = $_SESSION['remembered'] ?? [];
        $model['images'] = [];
    
        if (!empty($rememberedIds)) {
            $ids = [];
            foreach ($rememberedIds as $id) {
                $ids[] = new MongoDB\BSON\ObjectId($id);
            }
            $model['images'] = $db->images->find(['_id' => ['$in' => $ids]])->toArray();
        }

        return 'remembered_view';
}

function forgetImages(&$model) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $toForget = $_POST['forget'] ?? [];
        $_SESSION['remembered'] = array_diff($_SESSION['remembered'] ?? [], $toForget);
    }
    return 'redirect:/remembered';
}
function clearGallery(&$model) {
    $db = get_db();
    $db -> images ->deleteMany([]);
    $folderPath = __DIR__ . '/web/images/';
    if (is_dir($folderPath)) {
        $files = scandir($folderPath);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;
                if (is_file($filePath)) {
                    unlink($filePath);
                }
            }
        }
    }
    return 'redirect:/';
}
?>