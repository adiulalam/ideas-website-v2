<?php
error_reporting(0);
include_once $_SERVER['DOCUMENT_ROOT'] . "/environment.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/path.php";
require_once $_SERVER['DOCUMENT_ROOT'] . '/views/auth/login/index.php';
require_once "$_PATH[isMobile]";

function currentDir($dir)
{
    $mobileDevice =  isMobileDevice() ? 'text-2xl' : 'text-sm';
    $reqDir = $_SERVER['REQUEST_URI'];
    if ($dir == $reqDir) {
        $css = "class='flex justify-center items-center bg-gray-900 mr-2 text-white px-3 py-2 rounded-md $mobileDevice font-medium' aria-current='page'";
        return $css;
    } else {
        $css = "class='flex justify-center items-center text-gray-300 mr-2 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md $mobileDevice font-medium'";
        return $css;
    }
}

function roleCheck($dir)
{
    if ($dir == "/views/auth/login/login.html.php") return false;

    require_once $_SERVER['DOCUMENT_ROOT'] . '/views/auth/login/index.php';
    if (!userIsLoggedIn() || !(in_array("Site Administrator", $_SESSION['authorRole'])
        || in_array("Account Administrator", $_SESSION['authorRole'])
        || in_array("Category Moderator", $_SESSION['authorRole']))) {
        // print_r($_SESSION['authorRole']);
        return false;
    } elseif (
        in_array("Site Administrator", $_SESSION['authorRole']) ||
        (in_array("Account Administrator", $_SESSION['authorRole']) &&
            in_array("Category Moderator", $_SESSION['authorRole']))
    ) {
        if (userHasRole("Site Administrator") || (userHasRole("Account Administrator") && userHasRole("Category Moderator"))) {
            // print_r($_SESSION['authorRole']);
            $roleContent = "                
            <li>
                <a href='/views/admin/author/' " . currentDir("/views/admin/author/") . " >Account Administrator</a>
            </li>
            <li>
                <a href='/views/admin/category/' " . currentDir("/views/admin/category/") . " >Category Moderator</a>
            </li>
            ";
            return $roleContent;
        } else {
            return false;
        }
    } elseif (in_array("Account Administrator", $_SESSION['authorRole'])) {

        if (userHasRole("Account Administrator")) {
            // print_r($_SESSION['authorRole']);
            $roleContent = "                
            <li>
                <a href='/views/admin/author/' " . currentDir("/views/admin/author/") . " >Account Administrator</a>
            </li>";
            return $roleContent;
        } else {
            return false;
        }
    } elseif (in_array("Category Moderator", $_SESSION['authorRole'])) {

        if (userHasRole("Category Moderator")) {
            // print_r($_SESSION['authorRole']);
            $roleContent = "                
            <li>
                <a href='/views/admin/category/' " . currentDir("/views/admin/category/") . " >Category Moderator</a>
            </li>";
            return $roleContent;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
$mobileDevice =  isMobileDevice() ? 'text-2xl' : 'text-sm';

$navBarAuth = "
<a href='?Author=$_SESSION[aid]&Category=&action=search&text=' " . currentDir("/?Author=$_SESSION[aid]&Category=&action=search&text=") . " >See My Ideas</a>
<form action='' method='post'> 
    <button type='submit' href='/' class='flex h-full justify-center items-center text-gray-300 mr-2 hover:bg-gray-500 hover:text-white px-3 py-2 rounded-md $mobileDevice font-medium'>Logout</button>
    <input type='hidden' name='action' value='logout'>
</form> 
";

$navBarNotAuth = "
<a href='/views/auth/register/' " . currentDir('/views/auth/register/') . " >Register</a>
<a href='/views/auth/login/login.html.php' " . currentDir('/views/auth/login/login.html.php') . " >Login</a>
";

$navBarButton = userIsLoggedIn() ? $navBarAuth : $navBarNotAuth;

?>

<nav class='border-gray-700 px-2 sm:px-4 py-1.5 bg-gray-800'>
    <div class='container flex flex-wrap justify-between items-center mx-auto'>
        <div class='flex <?php echo isDesktopDevice() ? 'md:order-2' : '' ?> '>
            <button data-collapse-toggle='navbar-cta' type='button' class='inline-flex items-center p-2 mr-2 <?php echo isMobileDevice() ? 'text-2xl' : 'text-sm' ?> rounded-lg <?php echo isDesktopDevice() ? 'md:hidden' : '' ?> focus:outline-none focus:ring-2 text-gray-400 hover:bg-gray-700 focus:ring-gray-600' aria-controls='navbar-cta' aria-expanded='false'>
                <span class='sr-only'>Open main menu</span>
                <svg class='w-10 h-10' aria-hidden='true' fill='currentColor' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'>
                    <path fill-rule='evenodd' d='M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z' clip-rule='evenodd'></path>
                </svg>
            </button>
            <?php echo $navBarButton ?>
        </div>
        <div class='hidden justify-between items-center w-full <?php echo isDesktopDevice() ? 'md:flex md:w-auto md:order-1' : '' ?>' id='navbar-cta'>
            <ul class='flex flex-col p-2 mt-4 rounded-lg <?php echo isDesktopDevice() ? 'md:flex-row md:mt-0 md:text-sm md:font-medium md:border-0' : '' ?>'>
                <li>
                    <a href='/' <?php echo currentDir('/') ?>>Home</a>
                </li>
                <li>
                    <a href='/views/contact/' <?php echo currentDir('/views/contact/') ?>>Contact Me</a>
                </li>
                <li>
                    <a href='https://adiulalamadil.me/' class='flex justify-center items-center text-gray-300 mr-2 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md <?php echo isMobileDevice() ? 'text-2xl' : 'text-sm' ?> font-medium'>About Me</a>
                </li>
                <?php echo roleCheck($_SERVER['REQUEST_URI']) ?>
            </ul>
        </div>
    </div>
</nav>