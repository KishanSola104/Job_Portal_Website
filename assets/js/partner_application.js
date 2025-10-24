document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("partner-form");
  const submitBtn = document.getElementById("partner-submit");
  let msgTimeout;

  // Function to show dynamic messages
  function showMessage(text, type) {
    let msgDiv = document.getElementById("partner-form-message");
    if (!msgDiv) {
      msgDiv = document.createElement("div");
      msgDiv.id = "partner-form-message";
      msgDiv.style.marginTop = "10px";
      msgDiv.style.padding = "10px";
      msgDiv.style.borderRadius = "5px";
      msgDiv.style.fontWeight = "500";
      form.appendChild(msgDiv);
    }
    msgDiv.textContent = text;
    msgDiv.style.backgroundColor = type === "success" ? "#d4edda" : "#f8d7da";
    msgDiv.style.color = type === "success" ? "#155724" : "#721c24";
    msgDiv.style.border = type === "success" ? "1px solid #c3e6cb" : "1px solid #f5c6cb";

    if (msgTimeout) clearTimeout(msgTimeout);
    msgTimeout = setTimeout(() => { msgDiv.remove(); }, 5000);
  }

  // Form submission
  form.addEventListener("submit", (e) => {
    e.preventDefault();

    const companyName = document.getElementById("partner-company-name").value.trim();
    const contactPerson = document.getElementById("partner-contact-person").value.trim();
    const email = document.getElementById("partner-email").value.trim();
    const phone = document.getElementById("partner-phone").value.trim();
    const website = document.getElementById("partner-website").value.trim();
    const address = document.getElementById("partner-address").value.trim();
    const serviceType = document.getElementById("partner-service-type").value.trim();
    const notes = document.getElementById("partner-notes").value.trim();
    const terms = document.getElementById("partner-terms").checked;

    // Frontend validation
    if (companyName === "" || contactPerson === "" || email === "" || phone === "" || address === "" || serviceType === "") {
      showMessage("Please fill all required fields!", "error");
      return;
    }
    if (!/^[a-zA-Z\s]+$/.test(contactPerson)) {
      showMessage("Contact Person should contain only letters!", "error");
      return;
    }
    if (!/^[^@]+@[^@]+\.[^@]+$/.test(email)) {
      showMessage("Invalid email address!", "error");
      return;
    }
    if (!/^\+?\d{8,15}$/.test(phone)) {
      showMessage("Invalid phone number! Must be 8–15 digits, optional +", "error");
      return;
    }
    if (!terms) {
      showMessage("Please accept Terms & Conditions!", "error");
      return;
    }

    submitBtn.disabled = true;
    submitBtn.textContent = "Submitting...";

    const formData = new FormData();
    formData.append("company_name", companyName);
    formData.append("contact_person", contactPerson);
    formData.append("email", email);
    formData.append("phone", phone);
    formData.append("website", website);
    formData.append("address", address);
    formData.append("service_type", serviceType);
    formData.append("notes", notes);

    fetch("partner_submit.php", { method: "POST", body: formData })
      .then(res => res.json())
      .then(data => {
        if (data.status === "success") {
          showMessage(data.message + " Admin has been notified via email.", "success");
          form.reset();
        } else {
          showMessage(data.message, "error");
        }
        submitBtn.disabled = false;
        submitBtn.textContent = "Submit";
      })
      .catch(err => {
        showMessage("Network error. Try again later.", "error");
        console.error(err);
        submitBtn.disabled = false;
        submitBtn.textContent = "Submit";
      });
  });
});
