// Get all the percentage input fields
var percentageInputs = document.querySelectorAll(
    'input[type="text"][pattern="[0-9%]+"]'
);

// Add event listeners to all the percentage input fields
percentageInputs.forEach(function (input) {
    input.addEventListener("input", updateTotalPercentage);
});

// Function to calculate and update the total percentage
function updateTotalPercentage() {
    var totalPercentage = 0;
    percentageInputs.forEach(function (input) {
        var percentage = parseFloat(input.value);
        if (!isNaN(percentage)) {
            totalPercentage += percentage;
        }
    });
    document.getElementById("TOTAL").value = totalPercentage + "%";
}

function updateTotalPercentage() {
    var totalPercentage = 0;
    percentageInputs.forEach(function (input) {
        var percentage = parseFloat(input.value);
        if (!isNaN(percentage)) {
            // Add "%" to the input value
            input.value = percentage + "%";
            totalPercentage += percentage;
        }
    });
    document.getElementById("TOTAL").value = totalPercentage + "%";
}
