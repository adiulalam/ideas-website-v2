<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/connection/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css" />
  <meta charset="utf-8">
  <title>Ideal Ideas</title>
</head>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/components/nav.html.php'; ?>

<body class="bg-gray-900">
  <section class="bg-gray-900">

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/components/filter.html.php'; ?>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/components/pagination.html.php'; ?>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/components/card.html.php'; ?>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/components/pagination.html.php'; ?>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/components/addContent.html.php'; ?>

  </section>

</body>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/components/footer.html.php'; ?>


</html>