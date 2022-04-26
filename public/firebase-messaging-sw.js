
// Scripts for firebase and firebase messaging
importScripts('https://www.gstatic.com/firebasejs/8.2.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.2.0/firebase-messaging.js');

// Initialize the Firebase app in the service worker by passing the generated config
var firebaseConfig = {
    apiKey: "AIzaSyAcN6Sq0bUj978W8nnftdDG6Ei64pUPr3Y",
    authDomain: "testing-2bd06.firebaseapp.com",
    projectId: "testing-2bd06",
    storageBucket: "testing-2bd06.appspot.com",
    messagingSenderId: "958134735322",
    appId: "1:958134735322:web:45365ca1f8c6276573b0e3",
    measurementId: "G-VJE6JKV58L"
};


firebase.initializeApp(firebaseConfig);

// Retrieve firebase messaging
const messaging = firebase.messaging();

messaging.onBackgroundMessage(function(payload) {
    console.log('Received background message ', payload);

    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
    };

    self.registration.showNotification(notificationTitle,
        notificationOptions);
});
