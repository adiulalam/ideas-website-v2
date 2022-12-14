<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/connection/helpers.inc.php';

function commentMutationCheck($CommentID, $totalComments)
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/views/auth/login/index.php';

    $authorID = $_SESSION['aid'];

    if (!userIsLoggedIn() || !$authorID || !$totalComments || !$CommentID) {
        return false;
    }

    if (in_array($CommentID, $totalComments)) {
        $checkTextSize = isMobileDevice() ? 'p-3 text-3xl' : 'mx-1 p-2 text-sm';
        $buttonTextSize = isMobileDevice() ? 'text-3xl' : 'text-sm';
        $promptTextSize = isMobileDevice() ? 'text-3xl' : 'text-lg';

        $mutationForm = "
        <form action='' method='post' class=' float-right inline-flex items-center '>
            <input type='hidden' name='ID' value='$CommentID'>
            <Button type='button' data-modal-toggle='$CommentID' class=' float-right inline-flex items-center $checkTextSize font-medium text-center text-white rounded-lg focus:ring-4 focus:outline-none bg-red-600 hover:bg-red-700 focus:ring-red-800'>Delete</Button>
        </form>

        <div id='$CommentID' tabindex='-1' class='hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full'>
            <div class='relative p-4 w-full max-w-2xl h-full md:h-auto'>
                <div class='relative rounded-lg shadow bg-gray-700'>
                    <button type='button' class='absolute top-3 right-2.5 text-gray-400 bg-transparent rounded-lg $buttonTextSize p-1.5 ml-auto inline-flex items-center hover:bg-gray-800 hover:text-white' data-modal-toggle='$CommentID'>
                        <svg aria-hidden='true' class='w-5 h-5' fill='currentColor' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z' clip-rule='evenodd'></path></svg>
                        <span class='sr-only'>Close modal</span>
                    </button>
                    <div class='p-6 text-center'>
                        <svg aria-hidden='true' class='mx-auto mb-4 w-14 h-14 text-gray-200' fill='none' stroke='currentColor' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'></path></svg>
                        <h3 class='mb-5 $promptTextSize font-normal text-gray-400'>Are you sure you want to delete this Comment?</h3>
                        <form action='' method='post'>
                            <input type='hidden' name='ID' value='$CommentID'>
                            <button data-modal-toggle='$CommentID' type='submit' name='action' value='deleteComment' class='text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-800 font-medium rounded-lg $buttonTextSize inline-flex items-center px-5 py-2.5 text-center mr-2'>
                                Yes, I'm sure
                            </button>
                        <button data-modal-toggle='$CommentID' type='button' class='focus:ring-4 focus:outline-none rounded-lg border $buttonTextSize font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 bg-gray-700 text-gray-300 border-gray-500 hover:text-white hover:bg-gray-600 focus:ring-gray-600'>No, cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        ";

        echo $mutationForm;
    } else {
        return false;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css" />
    <meta charset="utf-8">
    <title> <?php html("$pageTitle - Idea") ?> </title>
</head>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/components/nav.html.php'; ?>

<body>

    <section class="bg-gray-900 mx-auto min-h-screen lg:py-0">

        <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/components/card.html.php'; ?>

        <form method="post" action="" class='<?php echo isMobileDevice() ? 'flex min-w-[70%]' : 'w-96' ?>'>
            <div class="my-4 rounded-lg border bg-gray-700 border-gray-600 w-full">
                <div class="py-2 px-4 rounded-t-lg bg-gray-800">
                    <label for="comment" class="sr-only">Your comment</label>
                    <textarea id="comment" name="comment" rows="4" class="px-0 w-full <?php echo isMobileDevice() ? 'text-3xl p-4' : 'text-sm' ?> border-0 bg-gray-800 focus:ring-0 text-white placeholder-gray-400" placeholder="Write a comment..." required></textarea>
                </div>
                <div class="flex justify-end items-center py-2 px-3 border-t border-gray-600">
                    <button name="postComment" type="submit" class="inline-flex items-center py-2.5 px-4 <?php echo isMobileDevice() ? 'text-3xl p-4' : 'text-xs' ?> font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-900 hover:bg-blue-800">
                        Post comment
                    </button>
                </div>
            </div>
        </form>

        <?php if (isset($comments)) :
            foreach ($comments as $Comment) : ?>
                <div class='flex <?php echo isMobileDevice() ? 'min-w-[70%] py-2' : 'w-96' ?>'>
                    <div class="block p-2 m-1 w-full rounded-lg border shadow-md bg-gray-800 border-gray-700 hover:bg-gray-700">
                        <p class="p-2 <?php echo isMobileDevice() ? 'text-3xl p-4' : 'text-sm' ?> text-gray-200"><?php html($Comment['Comment']); ?></p>
                        <p class="py-1 px-2 <?php echo isMobileDevice() ? 'text-3xl p-4' : 'text-sm' ?> float-left text-gray-400"><?php html(time_elapsed_string($Comment['Time'])); ?></p>
                        <?php commentMutationCheck($Comment['CommentID'], $totalComments) ?>
                        <p class="py-1 px-2 <?php echo isMobileDevice() ? 'text-3xl p-4' : 'text-sm' ?> float-right text-gray-400">By <?php html($Comment['Name']); ?></p>
                    </div>
                </div>
        <?php endforeach;
        endif; ?>

    </section>

</body>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/components/footer.html.php'; ?>

</html>