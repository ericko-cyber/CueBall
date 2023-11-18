const body = document.querySelector('body'),
      sidebar = body.querySelector('nav'),
      toggle = body.querySelector(".toggle"),
      navBtn = body.querySelector(".down"),
      modeSwitch = body.querySelector(".toggle-switch"),
      modeText = body.querySelector(".mode-text");
      const table = document.querySelector('.table');

// Fungsi untuk menyesuaikan lebar tabel berdasarkan status sidebar
function adjustTableWidth() {
    const isSidebarClosed = sidebar.classList.contains('close');
  
    // Sesuaikan lebar tabel berdasarkan status sidebar
    if (isSidebarClosed) {
      table.style.width = 'calc(100% - 80px)';
    } else {
      table.style.width = '95%';
    }
  }
  
  // Panggil fungsi saat halaman dimuat
  document.addEventListener('DOMContentLoaded', () => {
    // Panggil fungsi untuk pertama kali
    adjustTableWidth();
  
    // Tambahkan event listener pada toggle sidebar
    const toggleButton = document.querySelector('.sidebar header .toggle');
    toggleButton.addEventListener('click', adjustTableWidth);
  });


toggle.addEventListener("click" , () =>{
    sidebar.classList.toggle("close");
})
navBtn.addEventListener("click" , () =>{
    sidebar.classList.remove("close");
})


modeSwitch.addEventListener("click" , () =>{
    body.classList.toggle("dark");
    
    if(body.classList.contains("dark")){
        modeText.innerText = "Light mode";
    }else{
        modeText.innerText = "Dark mode";
        
    }
});

