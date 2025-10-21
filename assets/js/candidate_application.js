document.addEventListener("DOMContentLoaded", () => {
  const yearSelect = document.getElementById("candidate-year");
  const monthSelect = document.getElementById("candidate-month");
  const daySelect = document.getElementById("candidate-day");
  const form = document.getElementById("candidate-application-form");

  // Stop execution if key elements missing (safety check)
  if (!yearSelect || !monthSelect || !daySelect || !form) {
    console.error("❌ Candidate form elements not found in DOM.");
    return;
  }

  const currentYear = new Date().getFullYear();

  // ✅ Populate Year
  for (let y = currentYear - 60; y <= currentYear - 18; y++) {
    const opt = document.createElement("option");
    opt.value = y;
    opt.textContent = y;
    yearSelect.appendChild(opt);
  }

  // ✅ Populate Month
  const months = [
    "January","February","March","April","May","June",
    "July","August","September","October","November","December"
  ];
  months.forEach((m, i) => {
    const opt = document.createElement("option");
    opt.value = i + 1;
    opt.textContent = m;
    monthSelect.appendChild(opt);
  });

  // ✅ Populate Days dynamically
  function updateDays() {
    daySelect.innerHTML = "<option value=''>Day</option>";
    const y = parseInt(yearSelect.value);
    const m = parseInt(monthSelect.value);
    if (!y || !m) return;
    const daysInMonth = new Date(y, m, 0).getDate();
    for (let d = 1; d <= daysInMonth; d++) {
      const opt = document.createElement("option");
      opt.value = d;
      opt.textContent = d;
      daySelect.appendChild(opt);
    }
  }

  yearSelect.addEventListener("change", updateDays);
  monthSelect.addEventListener("change", updateDays);

  // ✅ Form validation
  form.addEventListener("submit", (e) => {
    e.preventDefault();

    const name = document.getElementById("candidate-name")?.value.trim();
    const email = document.getElementById("candidate-email")?.value.trim();
    const phone = document.getElementById("candidate-phone")?.value.trim();
    const address = document.getElementById("candidate-address")?.value.trim();
    const job = document.getElementById("candidate-job")?.value.trim();
    const exp = parseInt(document.getElementById("candidate-experience")?.value);
    const resume = document.getElementById("candidate-resume")?.files[0];
    const terms = document.getElementById("candidate-terms")?.checked;
    const year = parseInt(yearSelect.value);
    const month = parseInt(monthSelect.value);
    const day = parseInt(daySelect.value);

    // ✅ Validation rules
    if (!/^[a-zA-Z\s]+$/.test(name)) return alert("Name must contain only letters!");
    if (!/^\+?\d{8,15}$/.test(phone)) return alert("Invalid phone number!");
    if (!/^[^@]+@[^@]+\.[^@]+$/.test(email)) return alert("Invalid email address!");
    if (!year || !month || !day) return alert("Please select your complete date of birth!");
    if (address.length < 5) return alert("Address is too short!");
    if (job === "") return alert("Please select a job role!");
    if (isNaN(exp) || exp < 0) return alert("Invalid experience!");
    if (!resume) return alert("Please upload your resume!");

    const allowed = /\.(pdf|doc|docx)$/i;
    if (!allowed.test(resume.name)) return alert("Resume must be a PDF, DOC, or DOCX file!");
    if (resume.size > 5 * 1024 * 1024) return alert("Resume size must be ≤ 5MB!");
    if (!terms) return alert("Please accept the Terms & Conditions!");

    const age = currentYear - year;

    alert(`✅ Form successfully validated!\n
Name: ${name}\nEmail: ${email}\nPhone: ${phone}\nDOB: ${day}-${month}-${year} (Age: ${age})\nAddress: ${address}\nJob Role: ${job}\nExperience: ${exp} years\nResume: ${resume.name}`);
  });
});
