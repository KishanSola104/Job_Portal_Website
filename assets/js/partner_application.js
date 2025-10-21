document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("partner-form");

  form.addEventListener("submit", (e) => {
    e.preventDefault();

    const companyName = document.getElementById("partner-company-name").value.trim();
    const contactPerson = document.getElementById("partner-contact-person").value.trim();
    const email = document.getElementById("partner-email").value.trim();
    const phone = document.getElementById("partner-phone").value.trim();
    const address = document.getElementById("partner-address").value.trim();
    const serviceType = document.getElementById("partner-service-type").value.trim();

    // Validation
    if (!/^[a-zA-Z\s]+$/.test(contactPerson)) return alert("Contact Person should contain only letters!");
    if (!/^[^@]+@[^@]+\.[^@]+$/.test(email)) return alert("Invalid email address!");
    if (!/^\+?\d{8,15}$/.test(phone)) return alert("Invalid phone number! Must be 8–15 digits, optional +");
    if (companyName === "" || address === "" || serviceType === "") return alert("Please fill all required fields!");

    alert("✅ Partner form validated successfully!\n\n" +
      `Company: ${companyName}\nContact: ${contactPerson}\nEmail: ${email}\nPhone: ${phone}\nAddress: ${address}\nService Type: ${serviceType}`
    );

    // TODO: Send to PHP for DB insert later
  });
});
