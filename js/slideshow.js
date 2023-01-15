function call_js() {
  let slideshowSlide = document.querySelector(".slideshow_slide");
  let arraySlide = document.querySelectorAll(".slideshow_slide a");
  let prev = document.querySelector(".prev");
  let next = document.querySelector(".next");
  let arrayIndicator = document.querySelectorAll(".indicator a");
  let timer = "";
  let slidecount = arraySlide.length;
  let currentIndex = 0;

  // 슬라이드 일열로 나열
  for (let i = 0; i < slidecount; i++) {
    let newLeft = i * 100 + "%";
    arraySlide[i].style.left = newLeft;
  }
  function gotoSlide(index) {
    currentIndex = index;
    let newLeft = currentIndex * -100 + "%";
    slideshowSlide.style.left = newLeft;
    arrayIndicator.forEach((obj) => {
      obj.classList.remove("active");
    });
    arrayIndicator[index].classList.add("active");
  }
  function startTimer() {
    timer = setInterval(() => {
      let nextIndex = (currentIndex + 1) % slidecount;
      gotoSlide(nextIndex);
    }, 2500);
  }
  startTimer();

  // 마우스 멈추면 멈춤
  slideshowSlide.addEventListener("mouseenter", () => {
    clearInterval(timer);
  });
  slideshowSlide.addEventListener("mouseleave", () => {
    startTimer();
  });
  prev.addEventListener("mouseenter", () => {
    clearInterval(timer);
  });
  next.addEventListener("mouseenter", () => {
    clearInterval(timer);
  });
  arrayIndicator.forEach((object) => {
    object.addEventListener("mouseenter", () => {
      clearInterval(timer);
    });
  });

  // prev, next 이벤트
  prev.addEventListener("click", (e) => {
    e.preventDefault();
    currentIndex = currentIndex - 1;
    if (currentIndex < 0) {
      currentIndex = 3;
    }
    gotoSlide(currentIndex);
  });
  next.addEventListener("click", (e) => {
    e.preventDefault();
    currentIndex = currentIndex + 1;
    if (currentIndex > 3) {
      currentIndex = 0;
    }
    gotoSlide(currentIndex);
  });

  // indicator 페이지이동
  for (let i = 0; i < arrayIndicator.length; i++) {
    arrayIndicator[i].addEventListener("click", (e) => {
      e.preventDefault();
      gotoSlide(i);
    });
  }
}
