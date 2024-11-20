document.addEventListener('DOMContentLoaded', () => {
    const togglePasswordVisibility = (inputElement, buttonElement) => {
      const type = inputElement.type === 'password' ? 'text' : 'password';
      inputElement.type = type;

      const svg = buttonElement.querySelector('svg');
      svg.innerHTML =
        type === 'password'
          ? '<path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/>'
          : '<path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49"/><path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"/><path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"/><path d="m2 2 20 20"/>';
    };

    const setupPasswordToggle = (inputId, toggleId) => {
      const input = document.getElementById(inputId);
      const toggle = document.getElementById(toggleId);
      if (input && toggle) {
        toggle.addEventListener('click', () =>
          togglePasswordVisibility(input, toggle)
        );
      }
    };

    setupPasswordToggle('password', 'togglePassword');
    setupPasswordToggle('confirmPassword', 'toggleConfirmPassword');
});


// document.getElementById('createUser').addEventListener('submit', function(event) {
//     event.preventDefault();
//     validateForm(event);
// })

// function errorMessage(text,field) {
//    document.getElementById('message').innerHTML = text;
//    document.getElementById('message').classList.add('text-red-500');
//    document.getElementById(field).classList.add('border-red-500');
// }

// function isEmpty(email, password, confirmPassword, role) {
//     if (email === '' || password === '' || confirmPassword === '' || role === '') {
//         document.getElementById('message').innerHTML = 'Please fill out all the fields!';
//         document.getElementById('message').classList.add('text-red-500');
//         return true; 
//     } else {
//         return false;
//     }
// }


// function validateEmail(email) {
//     const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
//     if (email.match(pattern)) {
//         return true; 
//     } else {
//         errorMessage('Please enter a valid email address','email');
//         return false; 
//     }
// }

// function validatePassword(password,confirmPassword) {
//     if (password.length < 8 || password.length > 10) {
//         errorMessage('Password must be between 8 and 10 characters','password');
//         return false; 
//     } else if (password !== confirmPassword) {
//         errorMessage('Passwords do not match','confirmPassword');
//         return false; 
//     } else {
//         return true;
//     }
// }



// function validateForm(event) {
//     let email = document.getElementById('email').value; 
//     let password = document.getElementById('password').value;
//     let confirmPassword = document.getElementById('confirmPassword').value;
//     let role = document.getElementById('role').value;

//     //clear error message, if any 
//     document.getElementById('message').innerHTML = '';
//     document.getElementById('message').classList.remove('text-red-500');
//     document.getElementById('email').classList.remove('border-red-500');
//     document.getElementById('password').classList.remove('border-red-500');
//     document.getElementById('confirmPassword').classList.remove('border-red-500');
//     document.getElementById('role').classList.remove('border-red-500');

//     let isValid = true; 

//     //check if any fields are empty
//     if (isEmpty(email, password, confirmPassword, role)) {
//         isValid = false; 
//         event.preventDefault();
//         return;
//     }

//     //check if email is valid
//     if (!validateEmail(email)) {
//         isValid = false;
//         event.preventDefault();
//         return;
//     }

//     //check if password is valid
//     if (!validatePassword(password,confirmPassword)) {
//         isValid = false;
//         event.preventDefault();
//         return;
//     }

//     if (isValid) {
//         //clear form
//         document.getElementById('createUser').reset(); 
//     }


// }


