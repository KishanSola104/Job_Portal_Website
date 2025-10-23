document.addEventListener("DOMContentLoaded", () => {
  const yearSelect = document.getElementById("candidate-year");
  const monthSelect = document.getElementById("candidate-month");
  const daySelect = document.getElementById("candidate-day");
  const form = document.getElementById("candidate-application-form");
  const submitBtn = document.getElementById("candidate-submit");
  const currentYear = new Date().getFullYear();
  let msgTimeout;

  // Populate Year
  for (let y = currentYear - 60; y <= currentYear - 18; y++) {
    const opt = document.createElement("option");
    opt.value = y; opt.textContent = y; yearSelect.appendChild(opt);
  }

  // Populate Month
  const months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
  months.forEach((m,i) => {
    const opt = document.createElement("option");
    opt.value = i+1; opt.textContent = m; monthSelect.appendChild(opt);
  });

  // Populate Days dynamically
  function updateDays() {
    daySelect.innerHTML = "<option value=''>Day</option>";
    const y = parseInt(yearSelect.value);
    const m = parseInt(monthSelect.value);
    if (!y || !m) return;
    const daysInMonth = new Date(y, m, 0).getDate();
    for (let d=1; d<=daysInMonth; d++){
      const opt = document.createElement("option");
      opt.value = d; opt.textContent = d;
      daySelect.appendChild(opt);
    }
  }

  yearSelect.addEventListener("change", updateDays);
  monthSelect.addEventListener("change", updateDays);

  // Show dynamic message
  function showMessage(text, type){
    let msgDiv = document.getElementById("candidate-form-message");
    if(!msgDiv){
      msgDiv = document.createElement("div");
      msgDiv.id = "candidate-form-message";
      msgDiv.style.marginTop = "10px";
      msgDiv.style.padding = "10px";
      msgDiv.style.borderRadius = "5px";
      msgDiv.style.fontWeight = "500";
      form.appendChild(msgDiv);
    }
    msgDiv.textContent = text;
    msgDiv.style.backgroundColor = (type==="success")?"#d4edda":"#f8d7da";
    msgDiv.style.color = (type==="success")?"#155724":"#721c24";
    msgDiv.style.border = (type==="success")?"1px solid #c3e6cb":"1px solid #f5c6cb";

    if(msgTimeout) clearTimeout(msgTimeout);
    msgTimeout = setTimeout(()=>{msgDiv.remove();},5000);
  }

  // Form submission
  form.addEventListener("submit", (e) => {
    e.preventDefault();

    const name = document.getElementById("candidate-name").value.trim();
    const email = document.getElementById("candidate-email").value.trim();
    const phone = document.getElementById("candidate-phone").value.trim();
    const address = document.getElementById("candidate-address").value.trim();
    const job = document.getElementById("candidate-job").value.trim();
    const exp = parseInt(document.getElementById("candidate-experience").value);
    const resume = document.getElementById("candidate-resume").files[0];
    const terms = document.getElementById("candidate-terms").checked;
    const year = parseInt(yearSelect.value);
    const month = parseInt(monthSelect.value);
    const day = parseInt(daySelect.value);

    // Frontend validation
    if(!/^[a-zA-Z\s]+$/.test(name)){showMessage("Name must contain only letters!","error"); return;}
    if(!/^\+?\d{8,15}$/.test(phone)){showMessage("Invalid phone number!","error"); return;}
    if(!/^[^@]+@[^@]+\.[^@]+$/.test(email)){showMessage("Invalid email address!","error"); return;}
    if(!year || !month || !day){showMessage("Please select complete date of birth!","error"); return;}
    if(address.length<5){showMessage("Address too short!","error"); return;}
    if(job===""){showMessage("Please select a job role!","error"); return;}
    if(isNaN(exp) || exp<0){showMessage("Invalid experience!","error"); return;}
    if(!resume){showMessage("Please upload your resume!","error"); return;}
    if(!/\.(pdf|doc|docx)$/i.test(resume.name)){showMessage("Resume must be PDF/DOC/DOCX!","error"); return;}
    if(resume.size > 5*1024*1024){showMessage("Resume must be ≤5MB!","error"); return;}
    if(!terms){showMessage("Please accept Terms & Conditions!","error"); return;}

    // Disable submit button
    submitBtn.disabled = true;
    submitBtn.textContent = "Submitting...";

    // Send data via AJAX
    const formData = new FormData();
    formData.append("name", name);
    formData.append("email", email);
    formData.append("phone", phone);
    formData.append("address", address);
    formData.append("job_role", job);
    formData.append("experience", exp);
    formData.append("resume", resume);
    formData.append("dob_year", year);
    formData.append("dob_month", month);
    formData.append("dob_day", day);

    fetch("candidate_submit.php", {method:"POST", body: formData})
      .then(res => res.json())
      .then(data => {
        if(data.status === "success"){
          showMessage(data.message,"success"); 
          form.reset();
          daySelect.innerHTML = "<option value=''>Day</option>"; // Reset day select
        } else {
          showMessage(data.message,"error");
        }
        submitBtn.disabled = false;
        submitBtn.textContent = "Submit";
      })
      .catch(err => {
        showMessage("Network error. Try again later.","error");
        console.error(err);
        submitBtn.disabled = false;
        submitBtn.textContent = "Submit";
      });
  });
});
