
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">


        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false" v-pre>
            {{ Auth::user()->name }}
        </a>


    </nav>

    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Dashboard') }}</div>
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false" v-pre>
                            {{Auth::user()->email}}
                        </a>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            {{ __('You are logged in!') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- The core Firebase JS SDK is always required and must be listed first -->
{{--<script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-app.js"></script>--}}
{{--<script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-messaging.js"></script>--}}


<!-- TODO: Add SDKs for Firebase products that you want to use
    https://firebase.google.com/docs/web/setup#available-libraries -->

{{--<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>--}}
{{--<script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-app.js"></script>--}}
{{--<script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-messaging.js"></script>--}}

{{--<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js"></script>--}}

{{--<script>--}}
{{--    // importScripts('https://www.gstatic.com/firebasejs/9.6.10/firebase-app.js');--}}
{{--    // importScripts('https://www.gstatic.com/firebasejs/9.6.10/firebase-messaging.js');--}}
{{--    // importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');--}}
{{--    var firebaseConfig = {--}}
{{--        apiKey: "AIzaSyDaHN2Zphz7o0Y3iI_iwDELKuBLJJosww0",--}}
{{--        authDomain: "fir-notificationstest-ae16b.firebaseapp.com",--}}
{{--        projectId: "fir-notificationstest-ae16b",--}}
{{--        storageBucket: "fir-notificationstest-ae16b.appspot.com",--}}
{{--        messagingSenderId: "816212970982",--}}
{{--        appId: "1:816212970982:web:45820e9997343221225a27",--}}
{{--        measurementId: "G-N3FN8YZ33H"--}}
{{--    };--}}
{{--    // Initialize Firebase--}}
{{--   // const firebase= initializeApp(firebaseConfig);--}}
<script src="https://www.gstatic.com/firebasejs/8.2.0/firebase-app.js"></script>

<script src="https://www.gstatic.com/firebasejs/8.2.0/firebase-messaging.js"></script>

{{--<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>--}}

<script>
    var firebaseConfig = {
        apiKey: 'api-AIzaSyDaHN2Zphz7o0Y3iI_iwDELKuBLJJosww0',
        authDomain: "fir-notificationstest-ae16b.firebaseapp.com",
        projectId: "fir-notificationstest-ae16b",
        storageBucket: "fir-notificationstest-ae16b.appspot.com",
        messagingSenderId: "816212970982",
        appId: "1:816212970982:web:45820e9997343221225a27",
        measurementId: "G-N3FN8YZ33H"
    };
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
    function startFCM() {
        console.log('here');

        messaging
            .requestPermission()
            .then(function () {
                return messaging.getToken()
            })
            .then(function (response) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route("fcmToken") }}',
                    type: 'POST',
                    data: {
                        token: response
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        alert('Token stored.');
                    },
                    error: function (error) {
                        alert(error);
                    },
                });
            }).catch(function (error) {
            alert(error);
        });
    }
    startFCM()
    messaging.onMessage(function (payload) {
        const title = payload.notification.title;
        const options = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(title, options);
    });
</script>
