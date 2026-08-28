@php($googleTagManagerId = config('services.google_tag_manager.id'))

@if (filled($googleTagManagerId))
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ rawurlencode($googleTagManagerId) }}"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
@endif
