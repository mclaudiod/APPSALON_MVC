document.addEventListener("DOMContentLoaded", function () {
    startApp();
});

function startApp() {
    searchByDate();
};

function searchByDate() {
    const dateInput = document.querySelector("#date");
    dateInput.addEventListener("input", function(e) {
        const selectedDate = e.target.value;
        window.location = `?date=${selectedDate}`;
    });
};