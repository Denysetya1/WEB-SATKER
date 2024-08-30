// import {Html5QrcodeScanner} from "html5-qrcode";
function onScanSuccess(decodedText, decodedResult) {
    // handle the scanned code as you like, for example:
    // console.log(`Code matched = ${decodedText}`, decodedResult);
    html5QrcodeScanner.clear()
    Livewire.dispatch('scanQr', decodedText);
}

function onScanFailure(error) {
}

let qrboxFunction = function(viewfinderWidth, viewfinderHeight) {
    let minEdgePercentage = 0.7; // 70%
    let minEdgeSize = Math.min(viewfinderWidth, viewfinderHeight);
    let qrboxSize = Math.floor(minEdgeSize * minEdgePercentage);
    return {
        width: qrboxSize,
        height: qrboxSize
    };
}

let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader", {
        fps: 10,
        qrbox: qrboxFunction
    }, false
);

Livewire.on('scanQR', data => {
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
});
// html5QrcodeScanner.render(onScanSuccess, onScanFailure);

document.addEventListener('DOMContentLoaded', function() {
    $('#scanqr').on('click', function(e) {
        // let html5QrcodeScanner = new Html5QrcodeScanner(
        // "reader",
        // { fps: 10, qrbox: {width: 125, height: 125} }, /* verbose= */ false);
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    });
    $('#tutupscan').on('click', function(e) {
        // let html5QrcodeScanner = new Html5QrcodeScanner(
        // "reader",
        // { fps: 10, qrbox: {width: 125, height: 125} }, /* verbose= */ false);
        html5QrcodeScanner.clear()
    });
});
