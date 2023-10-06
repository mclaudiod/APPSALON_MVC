let step = 1;
const startingStep = 1;
const finalStep = 3;

const appointment = {
    id: "",
    name: "",
    date: "",
    time: "",
    services: []
}

document.addEventListener("DOMContentLoaded", function() {
    startApp();
});

function startApp() {
    showSection(); // Shows and hides the sections
    tabs(); // Changes the section when the tabs are clicked
    paginationButtons(); // Adds or removes the pagination buttons
    previousPage();
    nextPage();

    queryAPI(); // Query the API in the backend of PHP

    clientId(); // Adds the id of the client to the appointment
    clientName(); // Adds the name of the client to the appointment object
    chooseDate(); // Adds the date of the appointment to the object
    chooseTime(); // Adds the time of the appointment to the object

    showSummary(); // Shows the summary of the appointment
};

function showSection() {

    // Hide the section that has the class of show

    const previousSection = document.querySelector(".show");

    if(previousSection) {
        previousSection.classList.remove("show");
    }
    
    // Select the section with the step

    const stepSelector = `#step-${step}`;
    const section = document.querySelector(stepSelector);
    section.classList.add("show");

    // Remove the class of current to the previous tab

    const previousTab = document.querySelector(".current");

    if(previousTab) {
        previousTab.classList.remove("current");
    }

    // Highlight the current tab

    const tab = document.querySelector(`[data-step="${step}"]`);
    tab.classList.add("current");
};

function tabs() {
    const buttons = document.querySelectorAll(".tabs button");

    buttons.forEach(button => {
        button.addEventListener("click", function(e) {
            step = parseInt(e.target.dataset.step);
            showSection();
            paginationButtons();
        });
    });
};

function paginationButtons() {
    const previousPage = document.querySelector("#previous");
    const nextPage = document.querySelector("#next");

    if(step === 1) {
        previousPage.classList.add("conceal");
        nextPage.classList.remove("conceal");
    } else if(step === 3) {
        previousPage.classList.remove("conceal");
        nextPage.classList.add("conceal");
        showSummary();
    } else {
        previousPage.classList.remove("conceal");
        nextPage.classList.remove("conceal");
    }

    showSection();
};

function previousPage() {
    const previousPage = document.querySelector("#previous");
    
    previousPage.addEventListener("click", function() {
        if(step <= startingStep) return;
        step--;
        paginationButtons();
    });
};

function nextPage() {
    const nextPage = document.querySelector("#next");

    nextPage.addEventListener("click", function() {
        if(step >= finalStep) return;
        step++;
        paginationButtons();
    });
};

async function queryAPI() {

    // Async implies that this function in done in an asynchronous manner, that meaning that it's executed at the same time the other functions independently of the order they are put in, await means that before continuing with the next line of code it waits until that one finishes, without an async the await doesn't work and without an await the asyn doesn't do anything

    // .json is used because inside the information from the URL that is where the information is stored, more precisely in prototype and then json

    try {
        const url = "https://appsalonphp.000webhostapp.com/api/services";
        const result = await fetch(url);
        const services = await result.json();
        showServices(services);
    } catch (error) {
        console.log(error);
    };
};

function showServices(services) {
    services.forEach(service => {
        const {id, name, price} = service;

        const serviceName = document.createElement("P");
        serviceName.classList.add("service-name");
        serviceName.textContent = name;

        const servicePrice = document.createElement("P");
        servicePrice.classList.add("service-price");
        servicePrice.textContent = `$${price}`;

        const serviceDiv = document.createElement("DIV");
        serviceDiv.classList.add("service");
        serviceDiv.dataset.serviceId = id;
        serviceDiv.onclick = function() {
            selectService(service);
        };

        serviceDiv.appendChild(serviceName);
        serviceDiv.appendChild(servicePrice);

        document.querySelector("#services").appendChild(serviceDiv);
    });
};

function selectService(service) {

    // {services} = appointment means we are deconstructing, meaning taking, a part of an already existant array and assigning it a variable, in this case services, which is the same as te variable inside appointments... Then we are referencing the services array inside appointment and saying that it should put in there whatever there was before, using the variable services that we made before, and the new service we were giving to this function

    const {id} = service;
    const {services} = appointment;

    // Identify the clicked element

    const serviceDiv = document.querySelector(`[data-service-id="${id}"]`);

    // Check if service has already been added

    if(services.some(added => added.id === id)) {

        // Delete it

        appointment.services = services.filter(added => added.id !== id);
        serviceDiv.classList.remove("selected");
    } else {

        // Add it

        appointment.services = [...services, service];
        serviceDiv.classList.add("selected");
    };
};

function clientId() {
    appointment.id = document.querySelector("#id").value;
};

function clientName() {
    appointment.name = document.querySelector("#name").value;
};

function chooseDate() {
    const dateInput = document.querySelector("#date");
    dateInput.addEventListener("input", function(e) {
        const day = new Date(e.target.value).getUTCDay();

        if([6, 0].includes(day)) {
            e.target.value = "";
            showAlert("Weekends not permited", "error", ".form");
        } else {
            appointment.date = e.target.value;
        };
    });
};

function chooseTime() {
    const timeInput = document.querySelector("#time");
    timeInput.addEventListener("input", function(e) {
        const appointmentTime = e.target.value;
        const time = appointmentTime.split(":")[0];

        if(time < 10 || time > 18) {
            e.target.value = "";
            showAlert("Time not permited", "error", ".form");
        } else {
            appointment.time = e.target.value;
        };
    });
};

function showAlert(message, type, element, disappears = true) {

    // Prevents that more than one alert is generated

    const previousAlert = document.querySelector(".alert");
    if(previousAlert) {
        previousAlert.remove();
    };

    // Scripting for creating the alert

    const alert = document.createElement("DIV");
    alert.textContent = message;
    alert.classList.add("alert");
    alert.classList.add(type);

    const reference = document.querySelector(element);
    reference.appendChild(alert);

    // Delete the alert
    
    if(disappears) {
        setTimeout(() => {
            alert.remove();
        }, 3000);
    }
};

function showSummary() {
    const summary = document.querySelector(".summary-content");

    // Clean the content of Summary

    while(summary.firstChild) {
        summary.removeChild(summary.firstChild);
    };

    if (Object.values(appointment).includes("") || appointment.services.length === 0) {
        showAlert("You have to select services, a date and a time", "error", ".summary-content", false);

        return;
    };

    // Summary div formatting

    const {name, date, time, services} = appointment;

    // Heading for services in Summary

    const servicesHeading = document.createElement("H3");
    servicesHeading.textContent = "Services Summary";
    summary.appendChild(servicesHeading);

    // Iterating and showing services

    services.forEach(service => {
        const {name, price} = service;

        const serviceContainer = document.createElement("DIV");
        serviceContainer.classList.add("service-container");
        
        const serviceText = document.createElement("P");
        serviceText.textContent = name;

        const servicePrice = document.createElement("P");
        servicePrice.innerHTML = `<span>Price:</span> ${price}`;

        serviceContainer.appendChild(serviceText);
        serviceContainer.appendChild(servicePrice);

        summary.appendChild(serviceContainer);
    });

    // Heading for appointment in Summary

    const appointmentHeading = document.createElement("H3");
    appointmentHeading.textContent = "Appointment Summary";
    summary.appendChild(appointmentHeading);

    const clientName = document.createElement("P");
    clientName.innerHTML = `<span>Name:</span> ${name}`;

    // Formatting the date

    const dateObj = new Date(date);
    const month = dateObj.getMonth();
    const day = dateObj.getDate() + 2;
    const year = dateObj.getFullYear();

    const dateUTC = new Date (Date.UTC(year, month, day));

    const options = {weekday: "long", year: "numeric", month: "long", day: "numeric"};
    const formattedDate = dateUTC.toLocaleDateString("en-GB", options);

    const appointmentDate = document.createElement("P");
    appointmentDate.innerHTML = `<span>Date:</span> ${formattedDate}`;

    const appointmentTime = document.createElement("P");
    appointmentTime.innerHTML = `<span>Time:</span> ${time}`;

    // Button to create an appointment

    const reserveButton = document.createElement("BUTTON");
    reserveButton.classList.add("button");
    reserveButton.textContent = "Reserve Appointment";
    reserveButton.onclick = reserveAppointment;

    summary.appendChild(clientName);
    summary.appendChild(appointmentDate);
    summary.appendChild(appointmentTime);
    summary.appendChild(reserveButton);
};

async function reserveAppointment() {

    const {id, date, time, services} = appointment;

    const servicesId = services.map(service => service.id);

    const data = new FormData();
    data.append("userId", id);
    data.append("date", date);
    data.append("time", time);
    data.append("services", servicesId);

    try {
        // Petition to the API

        const url = "https://appsalonphp.000webhostapp.com/api/appointments";

        const answer = await fetch(url, {
            method: "POST",
            body: data
        });

        const result = await answer.json();

        if(result.result) {
            Swal.fire({
                icon: 'success',
                title: 'Appointment Created',
                text: 'Your appointmen has been created successfully',
                button: "OK"
            }).then(() => {
                setTimeout(() => {
                    window.location.reload();
                }, 3000);
            });
        };
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'There was an error when creating the appointment'
          })
    };

    

    // console.log([...data]);
};