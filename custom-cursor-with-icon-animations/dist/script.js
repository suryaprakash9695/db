var cursor = document.querySelector("#cursor");
var circle1 = document.querySelector("#circle1");
var firstRect = null;
var containerMenu = document.querySelector(".container-menu");
var lineIcon = document.querySelector(".line-icon");
var closeIcon = document.querySelector(".close");

var cursorMove = function (event) {
  if (circle1.className === "" || circle1.className === "leave")
    circle1.className = "enter";
  cursor.style.left = event.clientX + "px";
  cursor.style.top = event.clientY + "px";
}

var cursorLeave = function (event) {
  circle1.className = "leave";
}

var menuFocusIn = function (event) {
  if (!firstRect) firstRect = containerMenu.getBoundingClientRect();

  let cursorX = cursor.offsetLeft + cursor.offsetWidth / 2;
  let cursorY = cursor.offsetTop + cursor.offsetHeight / 2;

  let x = cursorX - parseInt(firstRect.x + firstRect.width / 2);
  let y = cursorY - parseInt(firstRect.y + firstRect.height / 2);

  if (Math.abs(x) > 46 || Math.abs(y) > 46) {
    cursorDefault();
  } else {
    containerMenu.style.transform = `translate(${x}px,${y}px)`;
  }

  if (
    circle1.className === "enter" ||
    circle1.className === "default" ||
    circle1.className === "mouse-down-to-default"
  ) {
    circle1.className = "menuFocusIn";
    iconLineAnimation();
  }
};

var cursorDefault = function () {
  if (circle1.classList.contains("menuMouseDown")) {
    menuClick();
    circle1.className = "mouse-down-to-default";
  } else {
    circle1.className = "default";
    iconLineDefault();
  }
  containerMenu.style.transform = `translate(0px,0px)`;
};

var iconLineAnimation = function () {
  document.querySelectorAll(".container-menu .icon-row").forEach((element) => {
    element.classList.remove("default");
    element.classList.add("animate");
  });
};
var iconLineDefault = function () {
  document.querySelectorAll(".container-menu .icon-row").forEach((element) => {
    element.classList.remove("animate");
    element.classList.add("default");
  });
};

var menuClick = function (event) {
  let lastActiveElement = containerMenu.querySelector(".last-active");
  let animatableElement = lastActiveElement.classList.contains("animatable")
    ? lastActiveElement
    : lastActiveElement.querySelector(".animatable");
  let onAnimationEnd = setInterval(() => {
    if (animatableElement.style.animationPlayState !== "running") {
      clearInterval(onAnimationEnd);
      setTimeout(() => {
        if (circle1.className !== "mouse-down-to-default") {
          circle1.className = "menuClick";
        }

        if (lastActiveElement === lineIcon) {
          closeIcon.style.display = "flex";
          closeIcon.className = "close close-in active";
        } else {
          lineIcon.className = "line-icon menu-in active";
          closeIcon.style.display = "none";
        }

        if (event) this.menuFocusIn(event);
      }, 100);
    }
  }, 100);
};

var menuMouseDown = function () {
  let activeElement = containerMenu.querySelector(".active");
  circle1.className = "menuMouseDown";

  if (activeElement === closeIcon) {
    closeIcon.className = "close close-out last-active";
    lineIcon.classList.remove("last-active");
  } else {
    lineIcon.className = "line-icon menu-out last-active animatable";
    closeIcon.classList.remove("last-active");
  }
};