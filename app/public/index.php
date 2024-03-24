<?php

declare(strict_types=1);

require(__DIR__ . '/../common/autoload.php');
require(__DIR__ . '/../common/auth.php');

use App\Helper\UploadHelper;

$title = 'Files';
$styles = '<link rel="stylesheet" href="/assets/fileicon.css">';

$userFilesDirectory = UploadHelper::UPLOAD_LOCATION . $_SESSION['user'];
$userFiles = [];
if (true === file_exists($userFilesDirectory)) {
    $userFiles = array_filter(scandir($userFilesDirectory), function (string $item): bool {
        if ($item === '.' || $item === '..') {
            return false;
        }
        return true;
    });
}

?>

<?php require(__DIR__ . '/../src/template/header.php'); ?>

<div class="files wrapper">
    <div class="paper">
        <h1>Your files</h1>

        <div class="account">
            <a href="/logout/">Logout</a>
        </div>

        <?php if (isset($_SESSION['flash'])): ?>
            <div class="message natural-width <?php echo $_SESSION['flash']['type']; ?>">
                <span><?php echo $_SESSION['flash']['message']; ?></span>
            </div>
        <?php endif; unset($_SESSION['flash']) ?>

        <div class="files-list">
            <?php foreach ($userFiles as $file): ?>
                <?php

                $pieces = explode('.', $file);
                $type = strtolower(end($pieces));

                ?>

                <div class="file">
                    <div class="file-icon file-icon-lg" data-type="<?php echo $type; ?>"></div>
                    <div class="name">
                        <a title="<?php echo $file; ?>"><?php echo $file; ?></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <h2>Upload new file</h2>

        <form action="/upload/" method="post" enctype="multipart/form-data">
                <label for="upload">Select a file to upload</label>
                <input type="file" id="upload" name="uploadedFile">

                <input type="submit" name="submit" value="Upload">
        </form>
    </div>
</div>

<?php require(__DIR__ . '/../src/template/footer.php'); ?>