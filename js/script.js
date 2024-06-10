document.addEventListener("DOMContentLoaded", () => {
  const ball = document.querySelector(".toggle-ball");
  const items = document.querySelectorAll(
    ".container, .navbar, .bi, .sidebar, .sidebar i, .toggle, .toggle-ball, .movie-list-filter select, .movie-list-title, #loginLink, #registerLink, .profile-text-container a, body, .category-title, .db-movie-details, .menu-list-item, .container-movie"
  );

  function toggleDarkMode() {
    items.forEach((item) => {
      item.classList.toggle("active");
    });
    const isDarkMode = ball.classList.contains("active");
    localStorage.setItem("darkMode", isDarkMode ? "enabled" : "disabled");
  }

  ball.addEventListener("click", () => {
    ball.classList.toggle("active");
    toggleDarkMode();
  });

  if (localStorage.getItem("darkMode") === "enabled") {
    ball.classList.add("active");
    toggleDarkMode();
  }

  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }

  // Handle movie list scrolling
  const movieLists = document.querySelectorAll(".movie-list");

  movieLists.forEach((movieList) => {
    const arrowLeft = document.createElement('button');
    arrowLeft.classList.add('arrow', 'arrow-left');
    arrowLeft.innerHTML = '&#8249;'; // Unicode karakteri sol ok için
    movieList.parentElement.appendChild(arrowLeft);

    const arrowRight = document.createElement('button');
    arrowRight.classList.add('arrow', 'arrow-right');
    arrowRight.innerHTML = '&#8250;'; // Unicode karakteri sağ ok için
    movieList.parentElement.appendChild(arrowRight);

    const imageItemCount = movieList.querySelectorAll("img").length;
    const movieWidth = 209; // 209px genişliğinde film afişi
    const visibleMovies = Math.floor(window.innerWidth / movieWidth);
    let clickCounter = 0;

    arrowLeft.addEventListener("click", () => {
      if (clickCounter > 0) {
        clickCounter--;
        movieList.style.transform = `translateX(${
          -movieWidth * clickCounter
        }px)`;
      }
    });

    arrowRight.addEventListener("click", () => {
      const maxClick = imageItemCount - visibleMovies;
      if (clickCounter < maxClick) {
        clickCounter++;
        movieList.style.transform = `translateX(${
          -movieWidth * clickCounter
        }px)`;
      } else {
        movieList.style.transform = "translateX(0)";
        clickCounter = 0;
      }
    });
  });

  // Handle login form submission
  document.getElementById("login-form").addEventListener("submit", function (event) {
    event.preventDefault();
    var formData = new FormData(this);

    fetch("login.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          document.getElementById("login-area").innerHTML =
            '<a href="logout.php">Çıkış Yap</a>';
        } else {
          alert("Giriş başarısız: " + data.message);
        }
      })
      .catch((error) => {
        console.error("Hata:", error);
      });
  });

  // Handle movie list scrolling with arrow buttons
  document.querySelectorAll('.arrow-right').forEach(function (arrow) {
      arrow.addEventListener('click', function () {
          const movieList = this.previousElementSibling;
          const movieWidth = movieList.querySelector('.movie-item').offsetWidth;
          movieList.scrollBy({ left: movieWidth, behavior: 'smooth' });
      });
  });

  document.querySelectorAll('.arrow-left').forEach(function (arrow) {
      arrow.addEventListener('click', function () {
          const movieList = this.nextElementSibling;
          const movieWidth = movieList.querySelector('.movie-item').offsetWidth;
          movieList.scrollBy({ left: -movieWidth, behavior: 'smooth' });
      });
  });

});
