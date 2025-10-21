// Privacy Policy Starts here 
document.querySelectorAll('.privacy-section h2').forEach(section => {
    section.style.cursor = 'pointer';
    section.addEventListener('click', () => {
        let next = section.nextElementSibling;
        while(next && next.tagName !== 'H2') {
            next.style.display = (next.style.display === 'none') ? 'block' : 'none';
            next = next.nextElementSibling;
        }
    });
});

/* Privacy Policy Ends here */