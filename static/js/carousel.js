// Carousel Slider
const carouselSlide = document.querySelector(".carousel-slide");
const carouselImages = document.querySelectorAll(".carousel-slide img");
const prevbtn = document.querySelector("#prevBtn");
const nextbtn = document.querySelector("#nextBtn");
const currImg = document.querySelector("#delete-post-btn");

let counter = 0;
const size = carouselImages[0].clientWidth;

// carouselSlide.style.transform = "translateX(" + -size * counter + "px)";

nextbtn.addEventListener("click", () => {
  if (counter >= carouselImages.length - 1) return;

  carouselSlide.style.transition = "transform 0.4s ease-in-out";
  counter++;
  carouselSlide.style.transform = "translateX(" + -size * counter + "px)";

  if (counter === 1) {
    currImg.style.display = "none";
  }
});

prevbtn.addEventListener("click", () => {
  if (counter <= 0) {
    return;
  }

  carouselSlide.style.transition = "transform 0.4s ease-in-out";
  counter--;
  carouselSlide.style.transform = "translateX(" + -size * counter + "px)";

  if (counter === 0) {
    currImg.style.display = "inline";
  }
});
