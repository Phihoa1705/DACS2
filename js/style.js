let footer = document.querySelector(".footer");
let body = document.querySelector("body");
let profile = document.querySelector(".header .flex .profile");
let searchForm = document.querySelector(".header .flex .search-form");
let sideBar = document.querySelector(".side-bar");
let toggleBtn = document.querySelector("#toggle-btn");
let darkMode = localStorage.getItem("dark-mode");

document.querySelector("#user-btn").onclick = () => {
  profile.classList.toggle("active");
  searchForm.classList.remove("active");
};

document.querySelector("#search-btn").onclick = () => {
  searchForm.classList.toggle("active");
  profile.classList.remove("active");
};

document.querySelector("#menu-btn").onclick = () => {
  sideBar.classList.toggle("active");
  body.classList.toggle("active");
  footer.classList.toggle("active");
};
document.querySelector(".close-bar").onclick = () => {
  sideBar.classList.remove("active");
};

window.onscroll = () => {
  profile.classList.remove("active");
  searchForm.classList.remove("active");
  if (window.innerWidth < 1200) {
    sideBar.classList.remove("active");
    body.classList.remove("active");
    footer.classList.remove("active");
  }
};
const enabelDarkMode = () => {
  toggleBtn.classList.replace("fa-sun", "fa-moon");
  body.classList.add("dark");
  localStorage.setItem("dark-mode", "enabled");
};

const disableDarkMode = () => {
  toggleBtn.classList.replace("fa-moon", "fa-sun");
  body.classList.remove("dark");
  localStorage.setItem("dark-mode", "disabled");
};

toggleBtn.onclick = (e) => {
  let darkMode = localStorage.getItem("dark-mode");
  if (darkMode === "disabled") {
    enabelDarkMode();
  } else {
    disableDarkMode();
  }
};

if (darkMode === "enabled") {
  enabelDarkMode();
}

document.querySelectorAll('input[type="number"]').forEach(InputNumber => {
  InputNumber.oninput = () =>{
     if(InputNumber.value.length > InputNumber.maxLength) InputNumber.value = InputNumber.value.slice(0, InputNumber.maxLength);
  }
});

