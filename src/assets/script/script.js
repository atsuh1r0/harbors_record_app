"use strict";


const btn = document.getElementById('current');
btn.addEventListener('click',() => {
  const user = document.querySelector('.user_container');
  user.classList.toggle('appear')
});


