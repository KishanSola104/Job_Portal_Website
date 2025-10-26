document.addEventListener("DOMContentLoaded", () => {
  const yearSelect = document.getElementById("candidate-year");
  const monthSelect = document.getElementById("candidate-month");
  const daySelect = document.getElementById("candidate-day");
  const form = document.getElementById("candidate-application-form");
  const submitBtn = document.getElementById("candidate-submit");
  const currentYear = new Date().getFullYear();
  let msgTimeout;

  // Populate year
  for (let y=currentYear-60; y<=currentYear-18; y++){
    let opt = document.createElement("option");
    opt.value = y; opt.textContent = y;
    yearSelect.appendChild(opt);
  }

  // Populate months
  const months=["January","February","March","April","May","June","July","August","September","October","November","December"];
  months.forEach((m,i)=>{
    let opt = document.createElement("option");
    opt.value = i+1; opt.textContent = m;
    monthSelect.appendChild(opt);
  });

  // Update days
  function updateDays(){
    daySelect.innerHTML="<option value=''>Day</option>";
    const y=parseInt(yearSelect.value), m=parseInt(monthSelect.value);
    if(!y || !m) return;
    const daysInMonth=new Date(y,m,0).getDate();
    for(let d=1;d<=daysInMonth;d++){
      const opt=document.createElement("option");
      opt.value=d; opt.textContent=d;
      daySelect.appendChild(opt);
    }
  }
  yearSelect.addEventListener("change", updateDays);
  monthSelect.addEventListener("change", updateDays);

  // Show message
  function showMessage(text,type="error",field=null){
    let msgDiv=document.getElementById("candidate-form-message");
    if(!msgDiv){
      msgDiv=document.createElement("div");
      msgDiv.id="candidate-form-message";
      msgDiv.style.marginTop="10px";
      msgDiv.style.padding="10px";
      msgDiv.style.borderRadius="5px";
      msgDiv.style.fontWeight="500";
      form.append(msgDiv);
    }
    msgDiv.textContent=text;
    msgDiv.style.backgroundColor=(type==="success")?"#d4edda":"#f8d7da";
    msgDiv.style.color=(type==="success")?"#155724":"#721c24";
    msgDiv.style.border=(type==="success")?"1px solid #c3e6cb":"1px solid #f5c6cb";

    form.querySelectorAll("input,select,textarea").forEach(f=>f.style.borderColor="");
    if(field) field.style.borderColor="#e3342f";

    if(msgTimeout) clearTimeout(msgTimeout);
    msgTimeout=setTimeout(()=>{
      msgDiv.remove();
      form.querySelectorAll("input,select,textarea").forEach(f=>f.style.borderColor="");
    },5000);
  }

  // Form submit
  // Form submit
form.addEventListener("submit",(e)=>{
  e.preventDefault();
  const phone = document.getElementById("candidate-phone").value.trim();
  const phonePattern = /^\+?\s*(?:\d\s*){10,15}$/;

  if (!phone.match(phonePattern)) {
    showMessage("Invalid phone number. Enter 10–15 digits, spaces and + allowed.","error",document.getElementById("candidate-phone"));
    return;
  }

  const formData=new FormData(form);
  submitBtn.disabled=true;
  submitBtn.textContent="Submitting...";

  fetch("candidate_submit.php",{method:"POST",body:formData})
  .then(res=>res.json())
  .then(data=>{
    if(data.status==="success"){
      showMessage(data.message,"success");
      form.reset();
      daySelect.innerHTML="<option value=''>Day</option>";
    } else {
      showMessage(data.message,"error");
    }
    submitBtn.disabled=false;
    submitBtn.textContent="Submit";
  })
  .catch(err=>{
    showMessage("Server error. Check console.","error");
    console.error(err);
    submitBtn.disabled=false;
    submitBtn.textContent="Submit";
  });
});
});
