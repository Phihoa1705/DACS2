// Tham chiếu đến phần tử body của tài liệu
let body = document.body;

// Tham chiếu đến phần tử profile nằm trong .header .flex
let profile = document.querySelector(".header .flex .profile");

// Tham chiếu đến phần tử search form nằm trong .header .flex
let searchForm = document.querySelector(".header .flex .search-form");

// Tham chiếu đến phần tử side bar
let sideBar = document.querySelector(".side-bar");

// Tham chiếu đến phần tử nút chuyển đổi (toggle button)
let toggleBtn = document.querySelector("#toggle-btn");

// Thay đổi trạng thái hiển thị của profile khi nhấn nút user
document.querySelector("#user-btn").onclick = () => {
  // Thêm hoặc gỡ bỏ class 'active' cho profile
  profile.classList.toggle("active");
  // Gỡ bỏ class 'active' khỏi search form
  searchForm.classList.remove("active");
};

// Thay đổi trạng thái hiển thị của search form khi nhấn nút search
document.querySelector("#search-btn").onclick = () => {
  // Thêm hoặc gỡ bỏ class 'active' cho search form
  searchForm.classList.toggle("active");
  // Gỡ bỏ class 'active' khỏi profile
  profile.classList.remove("active");
};

// Thay đổi trạng thái hiển thị của sidebar khi nhấn nút menu
document.querySelector("#menu-btn").onclick = () => {
  // Thêm hoặc gỡ bỏ class 'active' cho sidebar
  sideBar.classList.toggle("active");
  // Thêm hoặc gỡ bỏ class 'active' cho body
  body.classList.toggle("active");
};

// Đóng sidebar khi nhấn nút đóng trong sidebar
document.querySelector(".side-bar .close-side-bar").onclick = () => {
  // Gỡ bỏ class 'active' khỏi sidebar
  sideBar.classList.remove("active");
  // Gỡ bỏ class 'active' khỏi body
  body.classList.remove("active");
};

// Xử lý sự kiện cuộn trang
window.onscroll = () => {
  // Gỡ bỏ class 'active' khỏi profile và search form khi cuộn trang
  profile.classList.remove("active");
  searchForm.classList.remove("active");

  // Nếu chiều rộng cửa sổ nhỏ hơn 1200px, gỡ bỏ class 'active' khỏi sidebar và body
  if (window.innerWidth < 1200) {
    sideBar.classList.remove("active");
    body.classList.remove("active");
  }
};

// Lấy trạng thái chế độ tối từ localStorage
let darkMode = localStorage.getItem("dark-mode");

// Kích hoạt chế độ tối
const enableDarkMode = () => {
  // Thay đổi biểu tượng nút chuyển đổi thành mặt trăng
  toggleBtn.classList.replace("fa-sun", "fa-moon");
  // Thêm class 'dark' vào body
  body.classList.add("dark");
  // Lưu trạng thái chế độ tối vào localStorage
  localStorage.setItem("dark-mode", "enabled");
};

// Hủy kích hoạt chế độ tối
const disableDarkMode = () => {
  // Thay đổi biểu tượng nút chuyển đổi thành mặt trời
  toggleBtn.classList.replace("fa-moon", "fa-sun");
  // Gỡ bỏ class 'dark' khỏi body
  body.classList.remove("dark");
  // Lưu trạng thái chế độ tối vào localStorage
  localStorage.setItem("dark-mode", "disabled");
};

// Thiết lập trạng thái ban đầu của chế độ tối
if (!darkMode) {
  localStorage.setItem("dark-mode", "disabled");
}
if (darkMode === "enabled") {
  enableDarkMode();
}

// Thay đổi trạng thái chế độ tối khi nhấn nút chuyển đổi
if (toggleBtn) {
  toggleBtn.onclick = () => {
    let darkMode = localStorage.getItem("dark-mode");
    if (darkMode === "disabled") {
      enableDarkMode();
    } else {
      disableDarkMode();
    }
  };
}
