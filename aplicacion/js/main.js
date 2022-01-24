let contacto = document.querySelector('.menu4');
let aplicacion = document.querySelector('.menu3');
let nav = document.querySelector('nav');
let widthVentana = window.innerWidth;
var messLat;
var messLong;
var messCalidad;
var heatmap_json;
var prom;
let contactON = 0;
var firebaseConfig = {
    apiKey: "AIzaSyAbKxlvdi2DICwE7aTspnXZtX3lrJ3W5lA",
    authDomain: "smartbikes-24822.firebaseapp.com",
    databaseURL: "https://smartbikes-24822.firebaseio.com",
    projectId: "smartbikes-24822",
    storageBucket: "smartbikes-24822.appspot.com",
    messagingSenderId: "497748861893",
    appId: "1:497748861893:web:f760e201f6cc32f8e8e1ac",
    measurementId: "G-KC8F1FJTSG
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);
firebase.analytics();
const dbRef = firebase.database().ref();
const dataRef = dbRef.child('data');
getDataBase();
window.addEventListener("scroll", function ligth() {
    if (window.scrollY > 2017) {
        contacto.style.color = "#fff";
        aplicacion.style.color = "#A29C9C";
        contactON = 1;
    } else {
        contacto.style.color = "#A29C9C";
        aplicacion.style.color = "#fff";
        contactON = 0;
    }
})

contacto.addEventListener("mouseover", function ligth() {
    contacto.style.color = "#fff";
})

contacto.addEventListener("mouseout", function ligth() {
    if (contactON === 0) {
        contacto.style.color = "#A29C9C";
        aplicacion.style.color = "#fff";
    }
})

aplicacion.addEventListener("mouseover", function ligth() {
    if (window.scrollY > 1010) {
        aplicacion.style.color = "#fff";
    }
})

aplicacion.addEventListener("mouseout", function ligth() {
    if (window.scrollY > 1010) {
        aplicacion.style.color = "#A29C9C";
    }
})

window.addEventListener("resize", function resizefun() {
    widthVentana = window.innerWidth;
    nav.style = 'width: ' + widthVentana + 'px';
})



/////////////////////////////////////////////////////////////////////////////////////////////////////

usuario = 'nodo1';
contrasena = '12345678';

function OnOff(dato) {
    message = new Paho.MQTT.Message(dato);
    message.destinationName = '/' + usuario + '/salidaDigital'
    client.send(message);
};

// called when the client connects
function onConnect() {
    // Once a connection has been made, make a subscription and send a message.
    console.log("onConnect");
    client.subscribe("#");
}

// called when the client loses its connection
function onConnectionLost(responseObject) {
    if (responseObject.errorCode !== 0) {
        console.log("onConnectionLost:", responseObject.errorMessage);
        setTimeout(function() { client.connect() }, 5000);
    }
}

// called when a message arrives
function onMessageArrived(message) {
    if (message.destinationName == '/' + usuario + '/' + 'aire') { //acá coloco el topic
        document.getElementById("aire").textContent = message.payloadString + " ppm";
        messCalidad = message.payloadString;
    }
    if (message.destinationName == '/' + usuario + '/' + 'latitud') { //acá coloco el topic
        document.getElementById("latitud").textContent = message.payloadString;
        messLat = message.payloadString;
    }
    if (message.destinationName == '/' + usuario + '/' + 'longitud') { //acá coloco el topic
        document.getElementById("longitud").textContent = message.payloadString;
        messLong = message.payloadString;
    }
    if (message.destinationName == '/' + usuario + '/' + 'salidaDigital') { //acá coloco el topic
        document.getElementById("salidaDigital").textContent = message.payloadString;
    }
}

function onFailure(invocationContext, errorCode, errorMessage) {
    var errDiv = document.getElementById("error");
    errDiv.textContent = "Could not connect to WebSocket server, most likely you're behind a firewall that doesn't allow outgoing connections to port 39627";
    errDiv.style.display = "block";
}

var clientId = "ws" + Math.random();
// Create a client instance
var client = new Paho.MQTT.Client("tailor.cloudmqtt.com", 33597, clientId);

// set callback handlers
client.onConnectionLost = onConnectionLost;
client.onMessageArrived = onMessageArrived;

// connect the client
client.connect({
    useSSL: true,
    userName: usuario,
    password: contrasena,
    onSuccess: onConnect,
    onFailure: onFailure
});
/*
window.setInterval(function() {
    addMessage();
}, 60000);


function addMessage() {
    var message = {
        messCalidad,
        messLong,
        messLat
    }
    dataRef.push().set(message)
}*/


function addRandMessage(cal, long, lat) {
    messCalidad = cal;
    messLong = long;
    messLat = lat;
    var message = {
        messCalidad,
        messLong,
        messLat
    }
    dataRef.push().set(message)
}

function getDataBase() {
    dataRef.on("value", function(snapshoot) {
        var jsontxt = '';
        var data = snapshoot.val();
        var keys = Object.keys(data);
        console.log(snapshoot.val());
        console.log("Llega");
        jsontxt = '{"type":"FeatureCollection","features":[';
        for (var i = 0; i < keys.length; i++) {
            var k = keys[i];
            var calidad = 200;
            var latitud = 0;
            var longitud = 0;
            jsontxt += '{"type":"Feature",' +
                '"properties":{"dbh":' + calidad + '},' +
                '"geometry":{"type":"Point",' +
                '"coordinates":[' + longitud + ', ' + latitud + ']}}';
            if (i != keys.length - 1) {
                jsontxt += ',';
            }
            console.log(calidad, latitud, longitud);
        }
        jsontxt += ']}';
        heatmap_json = JSON.parse(jsontxt);
        console.log(jsontxt);
    })
}

function calcularProm() {
    prom = 0;
    var delta = 100;
    var iter = 0;
    var a = { latitude: 0, longitude: 0 };
    var latMaker = parseFloat(longLat.lat);
    var longMarker = parseFloat(longLat.lng);
    b = { latitude: latMaker, longitude: longMarker };
    var d = 0;
    dataRef.on("value", function(snapshoot) {
        var data = snapshoot.val();
        var keys = Object.keys(data);
        for (var i = 0; i < keys.length; i++) {
            var k = keys[i];
            var calidad = parseFloat(data[k].messCalidad);
            var latitud = parseFloat(data[k].messLat);
            var longitud = parseFloat(data[k].messLong);
            a = { latitude: latitud, longitude: longitud };
            d = haversine(a, b, { unit: 'meter' });
            if (d <= delta) {
                iter++;
                console.log(d.toFixed(3), calidad);
                prom += calidad;
            }
        }
        prom = prom / iter;
        prom = prom.toFixed(3);
        if (iter == 0) {
            prom = 0;
        }
    })
}