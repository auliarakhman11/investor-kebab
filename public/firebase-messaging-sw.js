// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: 'AIzaSyDfJZenxqaiz1yjIEx7_OEhjh_BYNIOH9E',
    authDomain: 'push-notification-96a8f.firebaseapp.com',
    databaseURL: 'https://project-id.firebaseio.com',
    projectId: 'push-notification-96a8f',
    storageBucket: 'push-notification-96a8f.appspot.com',
    messagingSenderId: '179871800285',
    appId: '1:179871800285:web:1ecd5308100043cfbeb434',
    measurementId: 'G-measurement-id',
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