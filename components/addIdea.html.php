<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/views/auth/login/index.php';

$buttonPage = userIsLoggedIn() ? '/views/add' : '/views/auth/login/login.html.php';

$addButton = "
<div class='fixed right-3 bottom-3 z-50 px-5 py-3 bg-transparent flex flex-col space-y-3'>
    <a href='$buttonPage' title='Add new idea'>
        <svg xmlns='http://www.w3.org/2000/svg' class='dark:fill-gray-400 text-white' width='60' height='60' viewBox='0 0 24 24'>
            <path d='M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm6 13h-5v5h-2v-5h-5v-2h5v-5h2v5h5v2z' />
        </svg>
    </a>
</div>
";

echo $addButton;
