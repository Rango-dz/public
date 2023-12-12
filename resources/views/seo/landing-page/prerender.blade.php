@extends('common::prerender.base')

@section('head')
    @include('seo.landing-page.seo-tags')
@endsection

@section('body')
    @if ($data = settings()->getJson('homepage.appearance'))
        <h1>{{ $data['headerTitle'] }}</h1>
        <p>{{ $data['headerSubtitle'] }}</p>

        @foreach ($data['actions'] as $action)
            @if (isset($action['action']))
                <a href="{{ $action['action'] }}">{{ $action['label'] }}</a>
            @endif
        @endforeach

        @if (isset($data['primaryFeatures']))
            <ul>
                @foreach ($data['primaryFeatures'] as $primaryFeature)
                    <li>
                        <h2>{{ $primaryFeature['title'] }}</h2>
                        <p>{{ $primaryFeature['subtitle'] }}</p>
                    </li>
                @endforeach
            </ul>
        @endif

        @if (isset($data['secondaryFeatures']))
            <ul>
                @foreach ($data['secondaryFeatures'] as $secondaryFeature)
                    <li>
                        <h3>{{ $secondaryFeature['title'] }}</h3>
                        @if (isset($secondaryFeature['subtitle']))
                            <small>{{ $secondaryFeature['subtitle'] }}</small>
                        @endif

                        <p>{{ $secondaryFeature['description'] }}</p>
                    </li>
                @endforeach
            </ul>
        @endif


<div>
    <h1>Watch Movies Online Free with iWatchOnline</h1>
    <p>Experience the thrill of cinema right at home with iWatchOnline - your ultimate hub for free online movie streaming in 2021. Without any registration or payment, immerse yourself in a vast collection of movies and TV shows in HD quality, all at your fingertips. With daily updates of new titles, the excitement never ends on iWatchOnline. Can't find what you're looking for? Simply make a request, and we'll ensure to provide your desired content.</p>
    <p>At iWatchOnline, enjoy exclusive premium features without spending a dime! Experience crystal clear HD quality, seamless streaming capabilities, secure and private source links, all in an ad-free environment!</p>
    
    <h2>iWatchOnline - Your Free Alternative to Netflix</h2>
    <p>iWatchOnline is a groundbreaking platform allowing users to watch and download movies and TV series in HD for free. Engineered to be a free alternative to Netflix, iWatchOnline ensures movie enthusiasts can relish the features offered by giant streaming services, without any costs. Our mission is to provide safe and seamless movie viewing to all, regardless of their financial situations.</p>
    
    <h3>iWatchOnline vs. 123Movies: Which is Better for Streaming Movies and Shows?</h3>
    <p>123Movies had been a popular free movie site, but it was shut down in 2018. Several sites have tried to emulate its success, but they often come with malicious ads and potential security risks. For your complete safety, choose iWatchOnline. Our platform is ad-free and doesn't require any registration, eliminating any chance for hackers to access your device or personal information.</p>
    
    <h4>Is It Legal to Use iWatchOnline?</h4>
    <p>iWatchOnline is currently accessible globally. While it's not technically a legal site, using iWatchOnline for free online movie streaming is not considered illegal. As per copyright attorneys, only sharing or downloading pirated content can lead to legal repercussions. If you still prefer to download videos for offline viewing, it's recommended to use a reliable VPN and proceed with caution. Enjoy endless entertainment with iWatchOnline - your safe haven for free movie streaming!</p>

</div>


        @if (isset($data['footerTitle']))
            <footer>
                <div>{{ $data['footerTitle'] }}</div>
                <p>{{ $data['footerSubtitle'] }}</p>
            </footer>
        @endif
    @endif
@endsection
