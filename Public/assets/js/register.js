const fileInput = document.getElementById("companyLogo");
const preview = document.getElementById("logoPreview");
const dropArea = document.getElementById("logoDrop");

fileInput.addEventListener("change", handleFile);

dropArea.addEventListener("dragover", (e) => {
  e.preventDefault();
  dropArea.classList.add("border-[#0A1A3A]");
});

dropArea.addEventListener("dragleave", () => {
  dropArea.classList.remove("border-[#0A1A3A]");
});

dropArea.addEventListener("drop", (e) => {
  e.preventDefault();
  dropArea.classList.remove("border-[#0A1A3A]");
  fileInput.files = e.dataTransfer.files;
  handleFile();
});

function handleFile() {
  const file = fileInput.files[0];
  if (!file) return;

  const reader = new FileReader();
  reader.onload = () => {
    preview.innerHTML = `
      <img src="${reader.result}" class="h-20 object-contain rounded-md" />
      <p class="text-sm text-gray-500">Logo uploaded</p>
    `;
  };
  reader.readAsDataURL(file);
}

// STEP NAVIGATION
let currentStep = 0;
const steps = document.querySelectorAll(".step");
const dots = [
  document.getElementById("dot-1"),
  document.getElementById("dot-2"),
  document.getElementById("dot-3"),
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
document.getElementById("registerForm").addEventListener("submit", async function(e) {
  e.preventDefault();

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
    alert("Please fill all fields before submitting.");
    return;
  }

  // Submit form via AJAX
  try {
    const formData = new FormData(this);
    const response = await fetch('../../Backend/auth/company/register.php', {
      method: 'POST',
      body: formData
    });

    const data = await response.json();

    if (data.success) {
      alert(data.message);
      // Redirect to dashboard
      window.location.href = data.redirect;
    } else {
      alert(data.message || 'Registration failed');
    }
  } catch (error) {
    console.error('Error:', error);
    alert('An error occurred during registration. Please try again.');
  }
});

updateSteps();