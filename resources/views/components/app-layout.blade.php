<!DOCTYPE html>
<html lang="en">

<head>
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Equipment Inventory</title>
</head>

<body class="w-screen h-screen overflow-hidden">
    {{ $slot }}
    <x-bladewind::notification />
    <livewire:change-logged-user-password />
    <script>
        document.addEventListener('refresh-alpine', () => {
            Alpine.initTree(document.body);
        });

        window.addEventListener('showNotification', function (event) {
            showNotification(event.detail.title,
                event.detail.message,
                event.detail.type,
                2,
                'regular');
        });

        window.addEventListener('openModal', function (event) {
            document.getElementsByName(`custom-${event.detail.name}-modal`)[0].classList.remove('hidden');
            document.getElementsByName(`custom-${event.detail.name}-modal`)[0].classList.add('block');
        });

        window.addEventListener('closeModal', function (event) {
            document.getElementsByName(`custom-${event.detail.name}-modal`)[0].classList.add('hidden');
            document.getElementsByName(`custom-${event.detail.name}-modal`)[0].classList.remove('block');
        });

        window.addEventListener('scrollToTop', () => {
            document.querySelector('.table-container').scrollTo({ top: 0, behavior: 'auto' });
        });

    </script>
    @livewireScripts
</body>

</html>