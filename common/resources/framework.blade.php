@php
    use Illuminate\Support\Js;
    use Sentry\Laravel\Integration;
@endphp

<!DOCTYPE html>
<html
    lang="{{ $bootstrapData->get('language') }}"
    style="{{ $bootstrapData->getSelectedTheme()->getColorsForCss() }}"
    @class(['dark' => $bootstrapData->getSelectedTheme('is_dark')])
>
    <head>
        <base href="{{ $htmlBaseUri }}" />

        @if (isset($seoTagsView))
            @include($seoTagsView, $pageData)
        @elseif (isset($meta))
            @include('common::prerender.meta-tags')
        @else
            <title>{{ settings('branding.site_name') }}</title>
        @endif

        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, maximum-scale=5"
            data-keep="true"
        />
        <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
        <link rel="manifest" href="/favicon/site.webmanifest">
        <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <link rel="shortcut icon" href="/favicon/favicon.ico">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="msapplication-config" content="/favicon/browserconfig.xml">

        <meta
            name="theme-color"
            content="rgb({{ $bootstrapData->getSelectedTheme()->getHtmlThemeColor() }})"
            data-keep="true"
        />

        <script>
            window.bootstrapData = {!! json_encode($bootstrapData->get()) !!};
        </script>

        @if (isset($devCssPath))
            <link rel="stylesheet" href="{{ $devCssPath }}" />
        @endif

        @viteReactRefresh
        @vite('resources/client/main.tsx')

        @if (file_exists($customCssPath))
            @if ($content = file_get_contents($customCssPath))
                <style>
                    {!! $content !!}
                </style>
            @endif
        @endif

        @if (file_exists($customHtmlPath))
            @if ($content = file_get_contents($customHtmlPath))
                {!! $content !!}
            @endif
        @endif

        @if ($code = settings('analytics.tracking_code'))
            <!-- Google tag (gtag.js) -->
            <script
                async
                src="https://www.googletagmanager.com/gtag/js?id={{ settings('analytics.tracking_code') }}"
            />
            <script>
                window.dataLayer = window.dataLayer || [];

                function gtag() {
                    dataLayer.push(arguments);
                }

                gtag('js', new Date());
                gtag('config', '{{ settings('analytics.tracking_code') }}');
            </script>
        @endif

        @yield('head-end')
    </head>

    <body>
        <div id="root">{!! $ssrContent ?? '' !!}</div>

        @if (! isset($ssrContent))
            <noscript>
                You need to have javascript enabled in order to use
                <strong>{{ config('app.name') }}</strong>
                .
            </noscript>
        @endif

        @yield('body-end')
    </body>
</html>
