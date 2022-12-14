<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/connection/helpers.inc.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/views/auth/login/index.php';

if (!userIsLoggedIn()) {
    header('Location: ' . '/views/auth/login/login.html.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel=" stylesheet">
    <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css" />
    <meta charset="utf-8">
    <title><?php html($pageTitle); ?></title>
</head>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/components/nav.html.php'; ?>

<body>
    <section class="bg-gray-900">
        <div class="flex flex-row flex-wrap justify-center items-center p-6 py-6 mx-auto min-h-screen lg:py-0">
            <div class="<?php echo isMobileDevice() ? 'flex min-w-[70%]' : 'w-full' ?> rounded-lg shadow border md:mt-0 sm:max-w-md xl:p-0 bg-gray-800 border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8 w-full">
                    <h1 class="<?php echo isMobileDevice() ? 'text-5xl' : 'text-xl md:text-2xl' ?> font-bold leading-tight tracking-tight text-white">
                        <?php html($pageTitle); ?>
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="?<?php html($action); ?>" method="POST" enctype="multipart/form-data">
                        <div>
                            <label for="ideaText" class="block mb-2 <?php echo isMobileDevice() ? 'text-3xl' : 'text-sm' ?> font-medium text-white">Your idea here:</label>
                            <textarea name="text" rows="3" class="border border-gray-300 <?php echo isMobileDevice() ? 'text-3xl' : 'sm:text-sm' ?> rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" placeholder="Write your idea" required><?php html($text); ?></textarea>
                            <input type="hidden" name="Author" value="<?php html($_SESSION['aid']); ?>">
                        </div>

                        <fieldset class="rounded border border-gray-700 p-3">
                            <legend class="block mb-2 <?php echo isMobileDevice() ? 'text-3xl' : 'text-sm' ?> font-medium text-white">Categories:</legend>
                            <ul class="w-full <?php echo isMobileDevice() ? 'text-3xl' : 'text-sm' ?> font-medium rounded-lg border bg-gray-700 border-gray-600 text-white">
                                <li class="w-full rounded-t-lg ">
                                    <?php foreach ($categories as $Category) : ?>
                                        <div class="flex items-center pl-3">
                                            <input type="checkbox" name="categories[]" value="<?php html($Category['ID']); ?>" <?php if ($Category['selected']) echo ' checked' ?> class="<?php echo isMobileDevice() ? 'w-8 h-8' : 'w-4 h-4' ?> text-blue-600 rounded focus:ring-blue-600 ring-offset-gray-700 focus:ring-2 bg-gray-600 border-gray-500">
                                            <label for="Category<?php html($Category['ID']); ?>" class="py-3 ml-2 w-full <?php echo isMobileDevice() ? 'text-3xl' : 'text-sm' ?> font-medium text-gray-300"><?php html($Category['Name']); ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                </li>
                            </ul>
                        </fieldset>

                        <fieldset class="rounded border border-gray-700 p-3">
                            <legend class="block mb-2 <?php echo isMobileDevice() ? 'text-3xl' : 'text-sm' ?> font-medium text-white">Departments:</legend>
                            <ul class="w-full <?php echo isMobileDevice() ? 'text-3xl' : 'text-sm' ?> font-medium rounded-lg border bg-gray-700 border-gray-600 text-white">
                                <li class="w-full rounded-t-lg ">
                                    <?php foreach ($departments as $Department) : ?>
                                        <div class="flex items-center pl-3">
                                            <input type="checkbox" name="departments[]" value="<?php html($Department['ID']); ?>" <?php if ($Department['selected']) echo ' checked' ?> class="<?php echo isMobileDevice() ? 'w-8 h-8' : 'w-4 h-4' ?> text-blue-600 rounded focus:ring-blue-600 ring-offset-gray-700 focus:ring-2 bg-gray-600 border-gray-500">
                                            <label for="Department<?php html($Department['ID']); ?>" class="py-3 ml-2 w-full <?php echo isMobileDevice() ? 'text-3xl' : 'text-sm' ?> font-medium text-gray-300"><?php html($Department['Name']); ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                </li>
                            </ul>
                        </fieldset>

                        <div class="mb-1 border-b border-gray-700">
                            <ul class="flex flex-wrap <?php echo isMobileDevice() ? 'text-3xl' : 'text-sm' ?> font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                                <li class="mr-2" role="presentation">
                                    <button class="inline-block p-4 rounded-t-lg border-b-2" id="upload-tab" data-tabs-target="#upload" type="button" role="tab" aria-controls="upload" aria-selected="<?php echo str_contains($Image, 'https://') ? 'true' : 'false' ?>">Upload Image</button>
                                </li>
                                <li class="mr-2" role="presentation">
                                    <button class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:border-gray-300 hover:text-gray-300" id="link-tab" data-tabs-target="#link" type="button" role="tab" aria-controls="link" aria-selected="<?php echo str_contains($Image, 'https://') ? 'true' : 'false' ?>">Link Image</button>
                                </li>
                            </ul>
                        </div>
                        <div id="myTabContent">
                            <div class="hidden rounded-lg bg-gray-800" id="upload" role="tabpanel" aria-labelledby="upload-tab">
                                <input class="block w-full <?php echo isMobileDevice() ? 'text-3xl' : 'text-sm' ?> rounded-lg border cursor-pointer text-gray-400 focus:outline-none bg-gray-700 border-gray-600 placeholder-gray-400" aria-describedby="file_input_help" id="file_input" name="myfile" type="file">
                                <p class="mt-1 <?php echo isMobileDevice() ? 'text-3xl' : 'text-sm' ?> text-gray-300" id="file_input_help"><?php echo str_contains($Image, 'https://') ? 'PNG or JPG Image Only' : html($Image) ?></p>
                                <input type='hidden' name='fileInputName' value='<?php echo str_contains($Image, 'https://') ? '' : html($Image) ?>'>
                            </div>
                            <div class="hidden p-4 rounded-lg bg-gray-800" id="link" role="tabpanel" aria-labelledby="link-tab">
                                <input name="Image" value="" class="border <?php echo isMobileDevice() ? 'text-3xl' : 'sm:text-sm' ?> rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" placeholder="<?php echo str_contains($Image, 'https://') ? html($Image) : 'URL of image' ?>"></input>
                            </div>
                        </div>

                        <input type="hidden" name="ID" value="<?php html($ID); ?>">
                        <button type="submit" value="<?php html($button); ?>" class="modal-open w-full text-white focus:ring-4 focus:outline-none font-medium rounded-lg <?php echo isMobileDevice() ? 'text-3xl' : 'text-sm' ?> px-5 py-2.5 text-center bg-blue-600 hover:bg-blue-700 focus:ring-blue-800"><?php html($button); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </section>

</body>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/components/footer.html.php'; ?>

</html>