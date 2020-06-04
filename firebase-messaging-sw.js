importScripts('https://www.gstatic.com/firebasejs/6.0.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/6.0.2/firebase-messaging.js');

var firebaseConfig = {
    apiKey: "AIzaSyBr3R7w9wlq05ZxBtdOVmrQztB5fVa3-xQ",
    authDomain: "account-657f6.firebaseapp.com",
    databaseURL: "https://account-657f6.firebaseio.com",
    projectId: "account-657f6",
    storageBucket: "account-657f6.appspot.com",
    messagingSenderId: "722396636779",
//                appId: "1:722396636779:web:17cb8ad1e2a2bef6"
};
firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();