// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.2.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.2.0/firebase-messaging.js');

// Initialize the Firebase app in the service worker by passing the generated config
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: "AIzaSyDaHN2Zphz7o0Y3iI_iwDELKuBLJJosww0",
    authDomain: "fir-notificationstest-ae16b.firebaseapp.com",
    databaseURL: "https://test-e41c2-default-rtdb.firebaseio.com",
    projectId: "fir-notificationstest-ae16b",
    storageBucket: "fir-notificationstest-ae16b.appspot.com",
    messagingSenderId: "816212970982",
    appId: "1:816212970982:web:45820e9997343221225a27",
    measurementId: "G-N3FN8YZ33H"

});


// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    console.log("Message received.", payload);
    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/firebase-logo.png",
    };
    return self.registration.showNotification(
        title,
        options,
    );
});
