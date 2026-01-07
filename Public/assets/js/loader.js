const params = new URLSearchParams(window.location.search);
const destination = params.get("to");

setTimeout(() => {
    if (destination) {
        window.location.href = destination;
    } else {
        window.location.href = "../index.html";
    }
}, 3000);