<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Task Manager</title>
        <!-- Include Tailwind CSS -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">

        <!-- Include Font Awesome for icons -->
        <link href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" >

        <link href="     https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/brands.min.css" >
        <link href="    https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/fontawesome.min.css" >
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.0/dist/alpine.min.js" defer></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-3NDgm8En5yDN9qF8x6cSwpKXoJd/U1kK6Ma4McYAcj3PP5U5cF8NyM4NlbKQ3n8U9sGFAZR/w/lD1fxT8J2N2w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-3NDgm8En5yDN9qF8x6cSwpKXoJd/U1kK6Ma4McYAcj3PP5U5cF8NyM4NlbKQ3n8U9sGFAZR/w/lD1fxT8J2N2w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>

    <body class="bg-gray-100 text-gray-900 flex">



    @include('components.navbar')
        @yield('content')



    </body>
</html>
