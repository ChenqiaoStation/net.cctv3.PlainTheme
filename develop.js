document.addEventListener("alpine:init", () => {
  Alpine.data("data", () => ({
    app: false,
    layout: false,
    open: "con",
    cate: false,
    tag: false,
    page: false,
    comments: false,
    links: false,
    Copyright:
      'Copyright © 2018~2023 Theme By <a href="#" target="_blank" rel="noopener noreferrer">Plain</a>',
    mode: getComputedStyle(document.documentElement)
      .getPropertyValue("content")
      .replace('"', "")
      .replace('"', ""),
    init() {
      if (window.matchMedia("(display-mode: standalone)").matches) {
        this.app = true;
        console.log("webapp");
      }

      fetch(sitedata.url + "?cate=1")
        .then((data) => data.json())
        .then((data) => {
          this.cate = data.data;
        });

      fetch(sitedata.url + "?comments=1")
        .then((data) => data.json())
        .then((data) => {
          this.comments = data.data;
        });

      fetch(sitedata.url + "?tags=30")
        .then((data) => data.json())
        .then((data) => {
          if (data.status == "200") {
            this.tag = data.data;
          }
        });
      fetch(sitedata.url + "?pages=1")
        .then((data) => data.json())
        .then((data) => {
          this.page = data.data;
        });
    },
    darkmode(type) {
      const darkModeQuery = window.matchMedia("(prefers-color-scheme: dark)");
      darkModeQuery.addListener(handleColorSchemeChange);
      if (type == "auto") {
        localStorage.removeItem("theme");
      }
      if (type == "dark") {
        darkModeQuery.removeListener(handleColorSchemeChange);
        localStorage.theme = "dark";
      }
      if (type == "light") {
        darkModeQuery.removeListener(handleColorSchemeChange);
        localStorage.theme = "light";
      }

      if ("theme" in localStorage) {
        if (localStorage.theme === "dark") {
          Alpine.store("ze").dark = true;
          document.cookie = "dark=true;path=/";
        } else {
          Alpine.store("ze").dark = false;
          document.cookie = "dark=light;path=/";
        }
      } else {
        handleColorSchemeChange(darkModeQuery);
      }
    },
    anchor(mao) {
      const dom = document.querySelector(mao);
      document.querySelector("#container").scrollTo({
        top: dom.offsetTop,
        behavior: "smooth",
      });
    },
  }));

  Alpine.store("ze", {
    dark: false,
    searchtext: "",
  });

  function handleColorSchemeChange(event) {
    if (event.matches) {
      // 夜间模式
      Alpine.store("ze").dark = true;
      document.cookie = "dark=true;path=/";
    } else {
      // 日间模式
      Alpine.store("ze").dark = false;
      document.cookie = "dark=light;path=/";
    }
  }
});
