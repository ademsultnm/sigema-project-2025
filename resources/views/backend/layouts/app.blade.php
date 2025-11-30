<!DOCTYPE html>
<html lang="en">
    

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('backend/assets/compiled/svg/favicon.svg') }}" type="image/x-icon">
    <link rel="shortcut icon"
        href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAiCAYAAADRcLDBAAAEs2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS41LjAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iCiAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIKICAgIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIKICAgIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIKICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgZXhpZjpQaXhlbFhEaW1lbnNpb249IjMzIgogICBleGlmOlBpeGVsWURpbWVuc2lvbj0iMzQiCiAgIGV4aWY6Q29sb3JTcGFjZT0iMSIKICAgdGlmZjpJbWFnZVdpZHRoPSIzMyIKICAgdGlmZjpJbWFnZUxlbmd0aD0iMzQiCiAgIHRpZmY6UmVzb2x1dGlvblVuaXQ9IjIiCiAgIHRpZmY6WFJlc29sdXRpb249Ijk2LjAiCiAgIHRpZmY6WVJlc29sdXRpb249Ijk2LjAiCiAgIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiCiAgIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSIKICAgeG1wOk1vZGlmeURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiCiAgIHhtcDpNZXRhZGF0YURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiPgogICA8eG1wTU06SGlzdG9yeT4KICAgIDxyZGY6U2VxPgogICAgIDxyZGY6bGkKICAgICAgc3RFdnQ6YWN0aW9uPSJwcm9kdWNlZCIKICAgICAgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWZmaW5pdHkgRGVzaWduZXIgMS4xMC4xIgogICAgICBzdEV2dDp3aGVuPSIyMDIyLTAzLTMxVDEwOjUwOjIzKzAyOjAwIi8+CiAgICA8L3JkZjpTZXE+CiAgIDwveG1wTU06SGlzdG9yeT4KICA8L3JkZjpEZXNjcmlwdGlvbj4KIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+Cjw/eHBhY2tldCBlbmQ9InIiPz5V57uAAAABgmlDQ1BzUkdCIElFQzYxOTY2LTIuMQAAKJF1kc8rRFEUxz9maORHo1hYKC9hISNGTWwsRn4VFmOUX5uZZ36oeTOv954kW2WrKLHxa8FfwFZZK0WkZClrYoOe87ypmWTO7dzzud97z+nec8ETzaiaWd4NWtYyIiNhZWZ2TvE946WZSjqoj6mmPjE1HKWkfdxR5sSbgFOr9Ll/rXoxYapQVik8oOqGJTwqPL5i6Q5vCzeo6dii8KlwpyEXFL519LjLLw6nXP5y2IhGBsFTJ6ykijhexGra0ITl5bRqmWU1fx/nJTWJ7PSUxBbxJkwijBBGYYwhBgnRQ7/MIQIE6ZIVJfK7f/MnyUmuKrPOKgZLpEhj0SnqslRPSEyKnpCRYdXp/9++msneoFu9JgwVT7b91ga+LfjetO3PQ9v+PgLvI1xkC/m5A+h7F32zoLXug38dzi4LWnwHzjeg8UGPGbFfySvuSSbh9QRqZ6H+Gqrm3Z7l9zm+h+iafNUV7O5Bu5z3L/wAdthn7QIme0YAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAJTSURBVFiF7Zi9axRBGIefEw2IdxFBRQsLWUTBaywSK4ubdSGVIY1Y6HZql8ZKCGIqwX/AYLmCgVQKfiDn7jZeEQMWfsSAHAiKqPiB5mIgELWYOW5vzc3O7niHhT/YZvY37/swM/vOzJbIqVq9uQ04CYwCI8AhYAlYAB4Dc7HnrOSJWcoJcBS4ARzQ2F4BZ2LPmTeNuykHwEWgkQGAet9QfiMZjUSt3hwD7psGTWgs9pwH1hC1enMYeA7sKwDxBqjGnvNdZzKZjqmCAKh+U1kmEwi3IEBbIsugnY5avTkEtIAtFhBrQCX2nLVehqyRqFoCAAwBh3WGLAhbgCRIYYinwLolwLqKUwwi9pxV4KUlxKKKUwxC6ZElRCPLYAJxGfhSEOCz6m8HEXvOB2CyIMSk6m8HoXQTmMkJcA2YNTHm3congOvATo3tE3A29pxbpnFzQSiQPcB55IFmFNgFfEQeahaAGZMpsIJIAZWAHcDX2HN+2cT6r39GxmvC9aPNwH5gO1BOPFuBVWAZue0vA9+A12EgjPadnhCuH1WAE8ivYAQ4ohKaagV4gvxi5oG7YSA2vApsCOH60WngKrA3R9IsvQUuhIGY00K4flQG7gHH/mLytB4C42EgfrQb0mV7us8AAMeBS8mGNMR4nwHamtBB7B4QRNdaS0M8GxDEog7iyoAguvJ0QYSBuAOcAt71Kfl7wA8DcTvZ2KtOlJEr+ByyQtqqhTyHTIeB+ONeqi3brh+VgIN0fohUgWGggizZFTplu12yW8iy/YLOGWMpDMTPXnl+Az9vj2HERYqPAAAAAElFTkSuQmCC"
        type="image/png">

    <title>@yield('title', 'Dashboard')</title>
    @include('backend.partials.styles')
</head>

<body>

    <!-- menu -->
    @include('backend.partials.menu')
    <!-- Main-->
    {{-- <div id="main"> --}}
    <!--Header-->
    {{-- @include('backend.partials.header') --}}
    @yield('content')
    <!--footer-->
    @include('backend.partials.footer')
    {{-- </div> --}}
    <!--scripts-->
    @include('backend.partials.scripts')
  @if (auth()->check() && strtolower(auth()->user()->role) === 'murid')
<script>
    window.CHATSPOT = {
        user_id: @json(auth()->user()->id),
        role: @json(auth()->user()->role),
        name: @json(auth()->user()->name),
        csrf: '{{ csrf_token() }}'
    };
</script>

<style>
    /* Floating button */
    #chatspot-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 62px;
        height: 62px;
        background-image: url('/images/logo2.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        border-radius: 50%;
        box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 28px;
        z-index: 9999;
        transition: transform .3s ease;
    }
    #chatspot-btn:hover {
        transform: scale(1.1);
    }

    /* Chat box with smooth animation */
    #chatspot-box {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 320px;
        height: 420px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.2);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transform: translateY(20px);
        opacity: 0;
        pointer-events: none;
        transition: opacity .3s ease, transform .3s ease;
        z-index: 9999;
    }
    #chatspot-box.show {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
    }

    /* Chat bubbles */
    .bubble-user {
        background: #dcf2ff;
        padding: 8px 12px;
        border-radius: 12px;
        display: inline-block;
        margin: 6px 0;
        max-width: 75%;
    }

    .bubble-bot {
        background: #f2f2f2;
        padding: 8px 12px;
        border-radius: 12px;
        display: inline-block;
        margin: 6px 0;
        max-width: 75%;
    }

    /* Chat body spacing */
    #chat-body {
        flex: 1;
        padding: 12px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
</style>

<script>
    const btn = document.createElement('div');
    btn.id = "chatspot-btn";
    btn.innerHTML = '<i class="fa fa-comment"></i>';
    document.body.appendChild(btn);

    document.addEventListener('click', (e) => {
        if (e.target.id === 'chatspot-close') {
            box.classList.remove('show');
        }
    });


    const box = document.createElement('div');
    box.id = "chatspot-box";
    box.innerHTML = `
        <div style="padding:10px; background:#435ebe; color:white; font-weight:bold; 
                    display:flex; align-items:center;">
            <span>Gema Ai</span>
            <button id="chatspot-close" 
                style="
                    margin-left:auto;
                    background:none; 
                    border:none; 
                    color:white; 
                    font-size:22px; 
                    cursor:pointer;
                    padding:0 8px;
                ">
                ×
            </button>
        </div>
        <div id="chat-body"></div>
        <div style="padding:10px; display:flex; gap:6px;">
            <input id="chat-input" type="text" style="flex:1; padding:8px; border-radius:8px; border:1px solid #ccc;" placeholder="Tulis pesan...">
            <button id="chat-send" class="btn btn-primary btn-sm">Kirim</button>
        </div>
    `;
    document.body.appendChild(box);

    /* Smooth toggle animation */
    btn.onclick = () => {
        box.classList.toggle('show');
    };

    async function sendMsg() {
        const input = document.getElementById('chat-input');
        const body = document.getElementById('chat-body');
        const msg = input.value.trim();
        if (!msg) return;

        // User bubble
        body.innerHTML += `
            <div style="text-align:right;">
                <span class="bubble-user">${msg}</span>
            </div>
        `;
        body.scrollTop = body.scrollHeight;
        input.value = '';

        // Loading bubble
        const loadingId = 'loading-' + Math.random().toString(36).substring(7);
        body.innerHTML += `
            <div id="${loadingId}" style="text-align:left;">
                <span class="bubble-bot" style="color:#666;">...</span>
            </div>
        `;
        body.scrollTop = body.scrollHeight;

        // Send to server
        const res = await fetch('/chatspot', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.CHATSPOT.csrf
            },
            body: JSON.stringify({ message: msg })
        });

        const data = await res.json();
        document.getElementById(loadingId).remove();

        // Bot bubble
        body.innerHTML += `
            <div style="text-align:left;">
                <span class="bubble-bot">${data.reply}</span>
            </div>
        `;
        body.scrollTop = body.scrollHeight;
    }

    /* Button click -> send */
    document.getElementById('chat-send').onclick = sendMsg;

    /* Press Enter -> send */
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            const visible = box.classList.contains('show');
            if (visible) sendMsg();
        }
    });
</script>
@endif


</body>

</html>
