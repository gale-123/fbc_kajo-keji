const menuToggle = document.querySelector('.menu-toggle');
const menu = document.querySelector('.menu');
const dropdowns = document.querySelectorAll('.has-dropdown');

menuToggle.addEventListener('click', () => {
  const open = menu.classList.toggle('open');
  menuToggle.setAttribute('aria-expanded', open);
});

document.querySelectorAll('.dropdown-toggle').forEach(button => {
  button.addEventListener('click', () => {
    const parent = button.parentElement;
    const isOpen = parent.classList.contains('open');
    dropdowns.forEach(item => {
      item.classList.remove('open');
      item.querySelector('.dropdown-toggle').setAttribute('aria-expanded', 'false');
    });
    if (!isOpen) {
      parent.classList.add('open');
      button.setAttribute('aria-expanded', 'true');
    }
  });
});

document.querySelectorAll('.menu a').forEach(link => link.addEventListener('click', () => {
  menu.classList.remove('open');
  menuToggle.setAttribute('aria-expanded', 'false');
}));

document.addEventListener('keydown', event => {
  if (event.key === 'Escape') {
    menu.classList.remove('open');
    menuToggle.setAttribute('aria-expanded', 'false');
    dropdowns.forEach(item => item.classList.remove('open'));
  }
});

document.querySelector('#year').textContent = new Date().getFullYear();

document.querySelector('#visit-form').addEventListener('submit', event => {
  const form = event.currentTarget;
  const status = form.querySelector('.form-status');
  if (!form.checkValidity()) {
    event.preventDefault();
    form.reportValidity();
    status.textContent = 'Please enter your name and a valid email address.';
    return;
  }
  status.textContent = 'Sending your enquiry…';
});
