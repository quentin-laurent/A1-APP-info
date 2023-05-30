const currentPassword = document.getElementById('currentPassword');
const currentPasswordMandatory = document.getElementById('currentPasswordMandatory');
const newPassword = document.getElementById('newPassword');
const newPasswordConfirm = document.getElementById('newPasswordConfirm');
const submitButton = document.getElementById('submitButton');

const confirmPassword = function() {
    if((newPassword.value === newPasswordConfirm.value)) {
        if(newPassword.value === '' && newPasswordConfirm.value === '') {
            newPassword.style.borderColor = '#DECDF5';
            newPassword.style.outline = '#DECDF5';
            newPasswordConfirm.style.borderColor = '#DECDF5';
            newPasswordConfirm.style.outline = '#DECDF5';
            submitButton.removeAttribute('disabled');
            submitButton.style.cursor = 'pointer';
            currentPasswordMandatory.style.display = 'none';
            currentPasswordMandatory.removeAttribute('required');
        }
        else {
            newPassword.style.borderColor = 'green';
            newPassword.style.outline = 'green';
            newPasswordConfirm.style.borderColor = 'green';
            newPasswordConfirm.style.outline = 'green';
            submitButton.removeAttribute('disabled');
            submitButton.style.cursor = 'pointer';
            currentPasswordMandatory.style.display = 'inline';
            currentPassword.setAttribute('required', '');
        }
    }
    else {
        newPassword.style.borderColor = 'red';
        newPassword.style.outline = 'red';
        newPasswordConfirm.style.borderColor = 'red';
        newPasswordConfirm.style.outline = 'red';
        submitButton.setAttribute('disabled', '');
        submitButton.style.cursor = 'not-allowed';
        currentPasswordMandatory.style.display = 'inline'
        currentPassword.setAttribute('required', '');
    }
};

newPassword.addEventListener('keyup', confirmPassword);
newPasswordConfirm.addEventListener('keyup', confirmPassword);

currentPassword.addEventListener('keyup', function () {
   if(currentPassword.value !== '') {
       newPassword.setAttribute('required', '');
       newPasswordConfirm.setAttribute('required', '');
   }
   else {
       newPassword.removeAttribute('required');
       newPasswordConfirm.removeAttribute('required');
   }
});
