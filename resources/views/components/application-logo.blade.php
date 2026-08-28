@props(['inverted' => false])

<span
    role="img"
    aria-label="HINO dan Armindo Perkasa"
    {{ $attributes->class(['brand-lockup', 'brand-lockup--inverted' => $inverted]) }}
>
    <img
        class="brand-lockup__hino"
        src="{{ asset('img/logo/logohinopth.png') }}"
        alt=""
        aria-hidden="true"
    >
    <span class="brand-lockup__divider" aria-hidden="true"></span>
    <img
        class="brand-lockup__armindo"
        src="{{ asset('img/logo/logoap1.png') }}"
        alt=""
        aria-hidden="true"
    >
</span>
