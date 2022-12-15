<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>E-mail</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:wght@300;900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Barlow:wght@400&family=Questrial&family=Quicksand&display=swap');

        body {
            background: #f2f2f2;
        }

        .container {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            height: 300px;
            width: 600px;
            background: #f2f2f2;
            overflow: hidden;
            border-radius: 20px;
            cursor: pointer;
            box-shadow: 0 0 20px 8px #d0d0d0;
        }
        .content h1 {
            margin-top: 30px;
            text-align: center;
            font-weight: 900;
            font-family: 'Quicksand', sans-serif;
        }

        .content h3 {
            margin-top: 30px;
            text-align: center;
            font-weight: 500;
            font-family: 'Barlow', sans-serif;
        }

        .flap {
            width: 100%;
            height: 100%;
        }

    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="container">
            <div class="content"
                style="position:absolute;top:50%;transform:translatey(-50%);text-align:center;">
                {{-- Greeting --}}
                @if (!empty($greeting))
                    {{ $greeting }}
                @else
                    @if ($level === 'error')
                        @lang('Whoops!')
                    @else
                        <h1>@lang('Notificación | SmartCityStation')</h1>
                    @endif
                @endif
                {{-- Intro Lines --}}
                @foreach ($introLines as $line)
                    <h3>{{ $line }}</h3>
                @endforeach

                {{-- Action Button --}}
                @isset($actionText)
                    <?php
                    switch ($level) {
                        case 'success':
                        case 'error':
                            $color = $level;
                            break;
                        default:
                            $color = 'primary';
                    }
                    ?>

                    @component('mail::button', ['url' => $actionUrl, 'color' => $color])
                        {{ $actionText }}
                    @endcomponent
                @endisset
                {{-- Outro Lines --}}
                @foreach ($outroLines as $line)
                    <h3>{{ $line }}</h3>
                @endforeach

                {{-- Salutation --}}
                @if (!empty($salutation))
                    <h3>{{ $salutation }}</h3>
                @else
                    <h3>@lang('Regards'), {{ config('app.name') }}</h3>
                @endif

                {{-- Subcopy --}}
                @isset($actionText)
                    @slot('subcopy')
                        <h3>@lang("If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\n" . 'into your web browser:', [
                            'actionText' => $actionText,
                        ]) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
                        </h3>
                    @endslot
                @endisset

            </div>
            <div class="flap">
            </div>
        </div>
    </div>


</body>

</html>
