// STEP NAVIGATION
let currentStep = 0;
const steps = document.querySelectorAll(".step");
const dots = [
    document.getElementById("dot-1"),
    document.getElementById("dot-2"),
];

function updateSteps() {
    steps.forEach((step, index) => {
        step.classList.toggle("active", index === currentStep);
    });

    dots.forEach((dot, index) => {
        dot.classList.toggle("bg-[#0A1A3A]", index === currentStep);
        dot.classList.toggle("bg-gray-300", index !== currentStep);
    });
}

// VALIDATED NEXT STEP
function nextStep() {
    const inputs = steps[currentStep].querySelectorAll("input, select");
    let allFilled = true;

    inputs.forEach(input => {
        if (input.type === "file") {
            if (!input.files || input.files.length === 0) {
                allFilled = false;
                input.classList.add("border-red-500");
            } else {
                input.classList.remove("border-red-500");
            }
        } else if (input.tagName === "SELECT") {
            if (input.selectedIndex === 0) {
                allFilled = false;
                input.classList.add("border-red-500");
            } else {
                input.classList.remove("border-red-500");
            }
        } else {
            if (input.value.trim() === "") {
                allFilled = false;
                input.classList.add("border-red-500");
            } else {
                input.classList.remove("border-red-500");
            }
        }
    });

    if (!allFilled) {
        alert("Please fill all fields before continuing.");
        return;
    }

    if (currentStep < steps.length - 1) {
        currentStep++;
        updateSteps();
    }
}

function prevStep() {
    if (currentStep > 0) {
        currentStep--;
        updateSteps();
    }
}

// FINAL FORM VALIDATION & SUBMISSION
document.getElementById("registerForm").addEventListener("submit", async function (e) {
    e.preventDefault();

    const inputs = steps[currentStep].querySelectorAll("input, select");
    let allFilled = true;

    inputs.forEach(input => {
        if (input.value.trim() === "") {
            allFilled = false;
            input.classList.add("border-red-500");
        } else {
            input.classList.remove("border-red-500");
        }
    });

    if (!allFilled) {
        alert("Please fill all fields before submitting.");
        return;
    }

    // Submit form via AJAX
    try {
        const formData = new FormData(this);
        // Note: Ensure the backend endpoint ../../Backend/auth/individual/register.php exists or update this path
        const response = await fetch('../../Backend/auth/individual/register.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            alert(data.message || 'Account created successfully!');
            // Redirect to individual dashboard or login
            window.location.href = data.redirect || 'individual-login.html';
        } else {
            alert(data.message || 'Registration failed');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred during registration. Please try again.');
    }
});

updateSteps();
