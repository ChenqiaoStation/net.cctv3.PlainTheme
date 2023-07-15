window.addEventListener("popstate", function () {
  //监听返回事件
  document.querySelector("#anchorx").click(); //重新检测锚点
});

function LoadCommentList(url) {
  // 发送AJAX请求获取更多HTML
  var request = new XMLHttpRequest();
  request.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      // 解析响应数据
      var response = this.responseText;
      // 取出当前页的内容
      var div = document.createElement("div");
      div.innerHTML = response;
      var items = div.querySelector(".comment-list").innerHTML;
      // 渲染当前页的内容
      var list = document.querySelector(".comment-list");
      list.insertAdjacentHTML("beforeend", items);
      // 判断是否还有更多内容
      if (div.querySelector("#loadMoreBtn")) {
        //如果有替换翻页按钮
        const oldContent = document.querySelector("#loadMoreBtn");
        const newContent = div.querySelector("#loadMoreBtn");
        oldContent.parentNode.replaceChild(newContent, oldContent);
      } else {
        //如果没有则输出提醒
        const oldContent = document.querySelector("#loadMoreBtn");
        const newContent = document.createElement("div");
        newContent.textContent = "😜已经没有了~";
        oldContent.parentNode.replaceChild(newContent, oldContent);
      }
      main.all(); //重置函数
    }
  };
  request.open("GET", url, true);
  request.send();
}

//原生js简易提示框
function sinnertip(type, msg) {
  if (document.querySelector(".sinner-tips")) {
    return;
  }
  var ico = type
    ? '<span class="d-block text-green-500 mb-2"><?xml version="1.0" standalone="no"?><!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd"><svg t="1553065772988" fill="currentColor" class="w-28 mx-auto" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2922" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><style type="text/css"></style></defs><path d="M666.272 472.288l-175.616 192a31.904 31.904 0 0 1-23.616 10.4h-0.192a32 32 0 0 1-23.68-10.688l-85.728-96a32 32 0 1 1 47.744-42.624l62.144 69.6 151.712-165.888a32 32 0 1 1 47.232 43.2m-154.24-344.32C300.224 128 128 300.32 128 512c0 211.776 172.224 384 384 384 211.68 0 384-172.224 384-384 0-211.68-172.32-384-384-384" p-id="2923"></path></svg></span>'
    : '<span class="d-block text-red-500 mb-2"><?xml version="1.0" standalone="no"?><!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd"><svg t="1553065784656" fill="currentColor" class="w-28 mx-auto" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3053" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><style type="text/css"></style></defs><path d="M544 576a32 32 0 0 1-64 0v-256a32 32 0 0 1 64 0v256z m-32 160a32 32 0 1 1 0-64 32 32 0 0 1 0 64z m0-608C300.256 128 128 300.256 128 512s172.256 384 384 384 384-172.256 384-384S723.744 128 512 128z" p-id="3054"></path></svg></span>';
  var c = type ? "tips-success" : "tips-error";
  var html =
    '<section class="sinner-tips ' +
    c +
    ' sitips-open">' +
    '<div class="transform scale-110 fixed inset-0 z-50 flex items-end backdrop-blur-md bg-black/30 sm:items-center sm:justify-center"></div>' +
    '<div class="transform scale-110 fixed top-0 left-0 z-50 flex justify-center justify-items-center items-center w-full h-full border dark:border-gray-600"><div class="tips-body rounded pb-6 max-w-xs bg-gray-50 text-lu dark:text-white dark:bg-gray-600">' +
    '<div class="rounded-t py-2 bg-luhead bg-gray-100 dark:bg-black"><div class="mx-2 text-right"><button class="w-3 h-3 bg-gray-300 rounded-full mx-1 focus:outline-none"></button><button class="w-3 h-3 bg-gray-300 rounded-full mx-1 focus:outline-none"></button><button class="w-3 h-3 bg-gray-300 rounded-full mx-1 focus:outline-none"></button></div></div>' +
    '<div class="text-center px-6"><div class="px-5 dark:text-gray-100 dark:border-gray-400">' +
    ico +
    '<div class="text-sm">' +
    msg +
    "</div></div></div></div></div></section>";
  document.body.insertAdjacentHTML("beforeend", html);
  setTimeout(function () {
    [].slice
      .call(document.querySelectorAll(".sinner-tips"))
      .forEach(function (tips) {
        tips.classList.remove("sitips-open");
        tips.classList.add("sitips-close");
        setTimeout(function () {
          tips.classList.remove("sitips-close");
          tips.parentNode.removeChild(tips);
        }, 400);
      });
  }, 800);
}
//原生js多功能提示框
function sinnertips(type, title, html) {
  var con = html;
  var html =
    '<section class="sinner-tips sitips-open">' +
    '<div class="transform scale-110 fixed inset-0 z-50 flex items-end backdrop-blur-md bg-black/30 sm:items-center sm:justify-center"></div>' +
    '<div class="fixed top-0 left-0 z-50 flex justify-center items-center w-full h-full"><div class="tips-body overflow-hidden rounded-lg w-96 max-w-' +
    type +
    ' bg-gray-50 dark:text-white dark:bg-gray-600">' +
    '<div class="py-2 bg-gray-100 dark:bg-black"><div class="mx-2 flex items-center justify-between"><div class="text-red-500 font-black">' +
    title +
    '</div><button class="btn-close-tips bg-red-500 p-0.5 rounded-full focus:outline-none"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="text-white w-4 h-4"> <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd"></path> </svg></button></div></div>' +
    '<div class="text-center"><div class="px-3 py-3 dark:text-gray-100 dark:border-gray-400">' +
    con +
    "</div></div>\
			</div></div></section>";
  document.body.insertAdjacentHTML("beforeend", html);
  [].slice
    .call(document.querySelectorAll(".btn-close-tips"))
    .forEach(function (closebtn) {
      closebtn.onclick = function () {
        var c = this.closest(".sinner-tips");
        c.classList.remove("sitips-open");
        c.remove();
      };
    });
}

//图片弹窗
function popups(obj) {
  var img = obj.getAttribute("data-img");
  var title = obj.getAttribute("data-title");
  var desc = obj.getAttribute("data-desc");
  var html =
    '<div class="text-center"><h6 class="mb-1 mt-2">' +
    title +
    '</h6>\
                    <div class="text-muted text-sm mb-2" > ' +
    desc +
    ' </div>\
                    <img src="' +
    img +
    '" alt="' +
    title +
    '" class="w-full h-auto">\
                    </div>';
  sinnertips("xs", html);
}
window.main = {};
//表单序列化
main.serialize = function (form) {
  var res = [], //存放结果的数组
    current = null, //当前循环内的表单控件
    i, //表单NodeList的索引
    len, //表单NodeList的长度
    k, //select遍历索引
    optionLen, //select遍历索引
    option, //select循环体内option
    optionValue, //select的value
    form = form; //用form变量拿到当前的表单，易于辨识

  for (i = 0, len = form.elements.length; i < len; i++) {
    current = form.elements[i];

    //disabled表示字段禁用，需要区分与readonly的区别
    if (current.disabled) continue;

    switch (current.type) {
      //可忽略控件处理
      case "file": //文件输入类型
      case "submit": //提交按钮
      case "button": //一般按钮
      case "image": //图像形式的提交按钮
      case "reset": //重置按钮
      case undefined: //未定义
        break;
      //select控件
      case "select-one":
      case "select-multiple":
        if (current.name && current.name.length) {
          console.log(current);
          for (k = 0, optionLen = current.options.length; k < optionLen; k++) {
            option = current.options[k];
            optionValue = "";
            if (option.selected) {
              optionValue = option.hasAttribute("value")
                ? option.value
                : option.text;
            }
            res.push(
              encodeURIComponent(current.name) +
                "=" +
                encodeURIComponent(optionValue)
            );
          }
        }
        break;

      //单选，复选框
      case "radio":
      case "checkbox":
        //这里有个取巧 的写法，这里的判断是跟下面的default相互对应。
        //如果放在其他地方，则需要额外的判断取值
        if (!current.checked) break;

      default:
        //一般表单控件处理
        if (current.name && current.name.length) {
          res.push(
            encodeURIComponent(current.name) +
              "=" +
              encodeURIComponent(current.value)
          );
        }
    }
  }
  return res.join("&");
};

//图片懒加载函数封装
function Limg() {
  // 获取所有需要懒加载的图片
  const images = document.querySelectorAll("img[data-xurl]");

  // 创建IntersectionObserver实例
  const callback = (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const image = entry.target;
        const data_src = image.getAttribute("data-xurl");
        image.setAttribute("src", data_src);
        observer.unobserve(image);
        //console.log("触发");
        setTimeout(function () {
          image.removeAttribute("data-xurl");
        }, 50);
      }
    });
  };
  const observer = new IntersectionObserver(callback);
  // 观察所有需要懒加载的图片
  images.forEach((img) => {
    observer.observe(img);
  });
}

main.code = function () {
  if (sitedata.lines == "on") {
    lines();
  }
  if (sitedata.hljs == "on") {
    hljs.highlightAll();
  }
  if (sitedata.copycode == "on") {
    var pres = document.querySelectorAll("pre");
    if (document.getElementById("post")) {
      for (var i = 0; i < pres.length; i++) {
        var t = pres[i].getElementsByTagName("code")[0].textContent;
        var btn = document.createElement("button");
        btn.classList.add(
          "copy",
          "dark:text-white",
          "absolute",
          "top-0",
          "right-0",
          "p-2",
          "text-xs"
        );
        btn.setAttribute("data-clipboard-text", t.trim());
        btn.setAttribute("aria-label", "复制");
        var textnode = document.createTextNode("");
        btn.appendChild(textnode);
        pres[i].insertBefore(btn, pres[i].childNodes[0]);
        var c = new ClipboardJS(btn);
        c.on("success", function (e) {
          e.trigger.classList.add("copyed");
          setTimeout(() => {
            e.trigger.classList.remove("copyed");
          }, 2000);
          e.clearSelection();
        });
        c.on("error", function (e) {
          e.trigger.classList.add("copyerror");
        });
      }
    }
  }
};

main.ajaxcomment = function () {
  /*ajax评论*/
  //监听评论表单提交
  [].slice
    .call(document.querySelectorAll(".comment-form"))
    .forEach(function (commentform) {
      commentform.addEventListener("submit", function (event) {
        event.preventDefault();
        var say = 0;
        var parent = 0;
        if (commentform.getAttribute("data-say")) {
          say = 1;
        }
        var params = main.serialize(commentform);
        params += "&themeAction=comment";
        var buttonhtml = document.querySelector("#submit").innerHTML;
        // 解析新评论并附加到评论列表
        var appendComment = function (comment) {
          // 评论列表
          var el = document.querySelector("#comments > .comment-list");
          var pl = " comment-parent";
          if (0 != comment.parent) {
            parent = comment.parent;
            pl = " children";
            // 子评论则重新定位评论列表
            var el = document.querySelector("#li-comment-" + comment.parent);
            // 父评论不存在子评论时
            if (el.querySelectorAll(".comment-list").length < 1) {
              el.insertAdjacentHTML(
                "beforeend",
                '<ol class="comment-list"></ol>'
              );
            }
            el = document.querySelector(
              "#li-comment-" + comment.parent + " .comment-list"
            );
          }
          if (!el) {
            //如果是第一次评论
            document
              .querySelector("#comments")
              .insertAdjacentHTML(
                "beforeend",
                '<ol class="comment-list"></ol>'
              );
            el = document.querySelector("#comments > .comment-list");
          }
          // 评论html模板，根据具体主题定制
          var html = "";
          if (say == "1") {
            if (parent == 0) {
              html =
                '<li id="li-comment-' +
                comment.coid +
                '" class="comment-body' +
                pl +
                ' comment-ajax p-3 bg-white dark:bg-gray-900 my-6"><div id="comment-' +
                comment.coid +
                '"><article id="div-comment-' +
                comment.coid +
                '" class="flex comment-body my-2"><div class="flex-none mr-3"><div class="relative"><img no-view class="relative z-10 w-12 object-cover rounded-md" src="' +
                comment.avatar +
                '"></div></div><div class="flex-initial w-full text-sm"><div class="comment-author mb-1"><div class="flex items-center"><span class="text-md font-semibold"><a href="' +
                comment.permalink +
                '" target="_blank" rel="external nofollow" class="" data-ajax="false">' +
                comment.author +
                '</a></span><span class="mx-1"></span> </div></div><div class="comment-content">' +
                comment.content +
                '</div><div class="flex items-center comment-meta text-xs text-gray-500 mt-1" data-no-instant><time class="mr-1">刚刚</time><span class="text-muted">' +
                comment.status +
                "</span></div></div></article></div></li>";
            } else {
              html =
                '<li id="li-' +
                comment.coid +
                '" class="comment-body' +
                pl +
                ' comment-ajax bg-gray-50 dark:bg-gray-800 mb-2"><div id="' +
                comment.coid +
                '" class="px-2 py-1"><article id="div-' +
                comment.coid +
                '" class="comment-body mb-2"><div class="saycon w-full text-sm"><div class="mb-1 comment-content"><span class="font-semibold"><a href="' +
                comment.permalink +
                '" target="_blank" rel="external nofollow" class="" data-ajax="false">' +
                comment.author +
                '</a>:</span><span class="mx-1"></span><span class="text-muted">' +
                comment.status +
                "</span>" +
                comment.content +
                '</div><!-- .comment-content --><div class="flex items-center comment-meta text-xs text-gray-500 mt-1" data-no-instant><time class="mr-1">刚刚</time></div></div></article></div></li>';
            }
          } else {
            html =
              '<div id="div-comment-' +
              comment.coid +
              '" class="comment-body' +
              pl +
              ' comment-ajax"><article id="div-comment-' +
              comment.coid +
              '" class="flex comment-body my-4 py-md-2"><div class="flex-none mr-1"><img alt="" src="' +
              comment.avatar +
              '" class="w-12 rounded-full scrollLoading" height="48" width="48"></div><div class="flex-initial w-full text-sm"><div class="comment-author mb-1"><div class="flex items-center"><a href="' +
              comment.permalink +
              '" target="_blank" rel="external nofollow">' +
              comment.author +
              "</a>" +
              comment.sf +
              '<span class="mx-1"></span></div></div><div class="comment-content px-4 py-2 rounded bg-slate-100 text-gray-900 dark:bg-gray-700 dark:text-gray-100">' +
              comment.content +
              '</div><div class="flex items-center comment-meta text-xs text-gray-500 mt-1"><time class="mr-1">刚刚</time><span class="text-muted">' +
              comment.status +
              "</span></div></div></article></div>";
          }
          el.insertAdjacentHTML("afterbegin", html);
        };
        // ajax提交评论
        var submit = document.querySelector("#submit");
        submit.setAttribute("disabled", "disabled");
        submit.innerHTML =
          '<svg class="animate-spin h-5 w-5 text-white m-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

        fetch(globals.post_url + "?" + params, { method: "POST" })
          .then((data) => data.json())
          .then((data) => {
            if (data.status == 1) {
              appendComment(data.comment);
              document.querySelector("#comment").value = "";
              if (document.querySelector("#nocomment")) {
                document.querySelector("#nocomment").remove();
              }
              TypechoComment.cancelReply();
              sinnertip(1, __.success);
              main.ajaxcommentfinish();
            } else {
              var tishi =
                undefined === data.msg ? "评论返回数据异常" : data.msg;
              sinnertip(0, tishi);
            }

            document.querySelector("#submit").disabled = "";
            document.querySelector("#submit").innerHTML = buttonhtml;
          });

        return false;
      });
    });
};

//文章密码ajax提交
main.password = function () {
  var passwordform = document.querySelector(".protected");
  if (passwordform) {
    passwordform.addEventListener("submit", function (event) {
      document.querySelector(".protected .submit").value = "提交中...";
      event.preventDefault();
      var surl = this.getAttribute("action");
      fetch(surl + "&" + main.serialize(passwordform), { method: "POST" })
        .then((data) => data.text())
        .then((data) => {
          if (
            data.indexOf('name="protectPassword"') >= 0 ||
            data.indexOf("您输入的密码错误") >= 0
          ) {
            document.querySelector(".protected .submit").value = "提交";
            sinnertip(0, "密码错误，请重试！");
          } else {
            sinnertip(1, "密码正确，请等待页面刷新！");
            var zhongzhuan = document.createElement("div");
            zhongzhuan.innerHTML = data;
            document.querySelector(".post-content").innerHTML =
              zhongzhuan.querySelectorAll(".post-content")[0].innerHTML;
            main.ajaxcommentfinish();
          }
        });
    });
  }
};

main.ajaxcommentfinish = function () {
  main.code();
  Limg();
  window.ViewImage &&
    ViewImage.init(
      ".post-content img, .post-comment img, .post-comment a.view-image"
    );
};

main.anchor = function (k = location.hash.substring(1)) {
  const mao = k;
  console.log(mao);
  if (
    mao &&
    mao != "&cate" &&
    mao != "&searchpage" &&
    mao != "&page" &&
    mao != "&setting"
  ) {
    const dom = document.querySelector("#" + mao);
    console.log(dom);
    document.querySelector("#container").scrollTo({
      top: dom.offsetTop,
      behavior: "smooth",
    });
  }
};

main.windows = function () {
  if (navigator.userAgentData) {
    navigator.userAgentData
      .getHighEntropyValues(["platformVersion"])
      .then((ua) => {
        if (navigator.userAgentData.platform === "Windows") {
          const majorPlatformVersion = parseInt(
            ua.platformVersion.split(".")[0]
          );
          if (majorPlatformVersion >= 13) {
            document.cookie = "win11=true;path=/";
          }
        }
      });
  }
};

main.init = function () {
  //评论表情初始化
  if (document.getElementsByClassName("OwO")[0]) {
    var biaoqingapi = sitedata.theme_url + "assets/OwO.json?2022";
    if (sitedata.biaoqing.length > 1) {
      biaoqingapi = sitedata.biaoqing;
    }
    var OwO_demo = new OwO({
      container: document.getElementsByClassName("OwO")[0],
      target: document.getElementsByClassName("OwO-textarea")[0],
      api: biaoqingapi,
      position: "down",
      width: "66vw",
      maxHeight: "250px",
    });
  }

  //隐私评论交互
  var PrivateComments = document.getElementById("PrivateComments");
  if (PrivateComments) {
    var holder = document.getElementById("comment").getAttribute("placeholder");
    PrivateComments.addEventListener("change", function () {
      if (PrivateComments.checked) {
        document
          .getElementById("comment")
          .setAttribute("placeholder", "正在隐私评论中...");
      } else {
        document.getElementById("comment").setAttribute("placeholder", holder);
      }
    });
  }

  //游客信息获取
  var mail = document.getElementById("mail");
  if (mail) {
    mail.onblur = function () {
      var mailcon = mail.value;
      if (mailcon.length > 5) {
        fetch(sitedata.ajax_url + "?xid=" + mailcon + "&info=1")
          .then((data) => data.json())
          .then((data) => {
            //console.info(data);
            var author = document.getElementById("author");
            var url = document.getElementById("url");
            document.getElementById("pltx").setAttribute("src", data.url);
            if (author.value.length < 1) {
              author.value = data.info.author;
            }
            if (url.value.length < 1) {
              url.value = data.info.url;
            }
          });
      }
    };
  }

  //复制按钮
  var clipboard = new ClipboardJS(".copybtn");
  clipboard.on("success", function (e) {
    sinnertip(1, "复制成功！");
    e.clearSelection();
  });
  clipboard.on("error", function (e) {
    sinnertip(0, "复制失败！");
  });

  var clipboardurl = new ClipboardJS(".copyurl");
  clipboardurl.on("success", function (e) {
    sinnertip(1, "文章链接已复制到剪切板");
    e.clearSelection();
  });
  clipboardurl.on("error", function (e) {
    sinnertip(0, "复制失败！");
  });

  //返回顶部按钮滚动到一定距离是显示出来
  var div = document.getElementById("container");
  div.addEventListener("scroll", function () {
    var topbtn = document.getElementById("widget-top");
    var scrollTop = div.scrollTop;
    //console.log('div距离顶部的滚动距离为：' + scrollTop);
    scrollTop >= 50
      ? topbtn.classList.remove("scale-0")
      : topbtn.classList.add("scale-0");
  });
};
main.back = function () {
  var backButton = document.getElementById("backBtn");
  if (backButton) {
    if (window.history.length <= 1) {
      backButton.style.display = "none";
    } else {
      backButton.addEventListener("click", function () {
        window.history.back();
      });
    }
  }
};

main.say = function () {
  if (typeof globals !== "undefined" && globals && globals.url) {
    var url = globals.url;
    // 获取上传按钮和上传列表
    var uploadBtn = document.getElementById("upload-file-btn");
    var fileList = document.getElementById("file-list");
    if (uploadBtn) {
      // 给上传按钮绑定change事件
      uploadBtn.addEventListener("change", function () {
        var files = this.files;
        if (files.length === 0) {
          return;
        }
        // 遍历选中文件列表
        for (var i = 0; i < files.length; i++) {
          var file = files[i];
          // 创建文件上传表单
          var formData = new FormData();
          formData.append("file", file);
          // 发送文件上传请求
          var xhr = new XMLHttpRequest();
          xhr.open("POST", url, true);
          xhr.upload.addEventListener("progress", function (e) {
            // 显示上传进度
            if (e.lengthComputable) {
              var progress = (e.loaded / e.total) * 100;
              console.log("上传进度：" + progress + "%");
              document.querySelector("#upload-progress").style.display =
                "block";
              document.querySelector("#upload-progress").style.width =
                progress + "%";
              if (progress >= 100) {
                setTimeout(function () {
                  document.querySelector("#upload-progress").style.display =
                    "none";
                  document.querySelector("#upload-progress").style.width = "0";
                }, 50);
              }
            }
          });
          xhr.addEventListener("readystatechange", function () {
            if (this.readyState !== 4) {
              return;
            }
            if (this.status === 200) {
              // 上传成功，添加上传记录
              var data = JSON.parse(this.response)[1];
              console.log(data);
              var li =
                '<li class="mt-3" id="att' +
                data.cid +
                '" data-image="' +
                data.isImage +
                '" /><img class="rounded-md w-full object-contain bg-gray-600" src="' +
                data.url +
                '"><div class="flex mt-1"><button class="rounded-md w-full text-sm text-white py-1 bg-1 hover:bg-sky-600 insert-btn mr-1" data-txt="![' +
                data.title +
                "](" +
                data.url +
                ')">插入</button><button class="rounded-md w-full text-sm text-white py-1 bg-4 hover:bg-sky-600 delete-btn" data-cid="' +
                data.cid +
                '">删除</button></div></li>';
              li.textContent = file.name + " 上传成功";
              fileList.insertAdjacentHTML("afterbegin", li);
              main.satinsert();
              main.delete();
            } else {
              // 上传失败
              var li = document.createElement("li");
              li.textContent = file.name + " 上传失败";
              fileList.insertAdjacentHTML("afterbegin", li);
            }
          });
          xhr.send(formData);
        }
      });
      main.satinsert();
      main.delete();
    }
  }
};

main.satinsert = function () {
  // 给每个插入按钮绑定click事件
  [].slice
    .call(document.querySelectorAll(".insert-btn"))
    .forEach(function (insertBtn) {
      insertBtn.onclick = function () {
        var textArea = document.getElementById("comment");
        var content = insertBtn.getAttribute("data-txt") + "\n";
        // 获取当前操作的textarea
        //console.log(textArea);
        //var textArea = this.previousElementSibling;
        var start = textArea.selectionStart;
        var end = textArea.selectionEnd;
        var oldContent = textArea.value;
        // 向textarea中插入内容
        textArea.value =
          oldContent.substring(0, start) + content + oldContent.substring(end);
      };
    });
};
main.delete = function () {
  var notice = globals.prefix + "__typecho_notice";
  var noticeType = globals.prefix + "__typecho_notice_type";
  //编辑说说
  [].slice
    .call(document.querySelectorAll(".operate-edit"))
    .forEach(function (editbtn) {
      editbtn.onclick = function () {
        var url = editbtn.getAttribute("data-url");
        var comment = editbtn.closest("li").getAttribute("data-comment");
        var saycon = editbtn.closest("li").querySelector(".saycon");
        var sayed = editbtn.closest("li").querySelector(".sayed");
        saycon.style.display = "none";
        sayed.innerHTML =
          '<div class="comment-edit-content"><textarea name="text" rows="6" class="w-full bg-slate-100 dark:bg-gray-600 rounded py-2 px-1.5">' +
          comment +
          '</textarea><p class="mt-1"><button type="button" data-url="' +
          url +
          "\" class=\"sayedit text-2 mr-2\">提交</button><button type=\"button\" class=\"text-4 cancel\" onclick=\"this.closest('li').querySelector('.sayed').style.display = 'none';this.closest('li').querySelector('.saycon').style.display = '';\">取消</button></p></div>";
        sayed.style.display = "";
        main.sayedit();
      };
    });

  // 删除说说
  [].slice
    .call(document.querySelectorAll(".operate-delete"))
    .forEach(function (deletebtn) {
      var msg = "您真的确定要删除这条内容吗？";
      deletebtn.onclick = function () {
        if (confirm(msg) == true) {
          var url = deletebtn.getAttribute("data-url");
          console.log(url);
          fetch(url).then(function (response) {
            //response.status表示响应的http状态码
            if (response.status === 200) {
              sinnertip(1, "已删除");
              deletebtn.closest("li").remove();
              main.deleteCookie(notice);
              main.deleteCookie(noticeType);
            }
          });
        }
      };
    });

  //删除附件
  var url = globals.delete;
  [].slice
    .call(document.querySelectorAll(".delete-btn"))
    .forEach(function (insertBtn) {
      var msg = "您真的确定要删除吗？";
      insertBtn.onclick = function () {
        if (confirm(msg) == true) {
          var cid = insertBtn.getAttribute("data-cid");
          var xhr = new XMLHttpRequest();
          xhr.open("POST", url, true);
          xhr.addEventListener("readystatechange", function () {
            if (this.readyState !== 4) {
              return;
            }
            if (this.status === 200) {
              sinnertip(1, "已删除");
              document.getElementById("att" + cid).remove();
              main.deleteCookie(notice);
              main.deleteCookie(noticeType);
            }
          });
          var formData = new FormData();
          formData.append("do", "delete");
          formData.append("cid", cid);
          xhr.send(formData);
        }
      };
    });
};

main.sayedit = function () {
  [].slice
    .call(document.querySelectorAll(".sayedit"))
    .forEach(function (sayeditbtn) {
      sayeditbtn.onclick = function () {
        var saycon = sayeditbtn.closest("li").querySelector(".saycon");
        var sayed = sayeditbtn.closest("li").querySelector(".sayed");
        var url = sayeditbtn.getAttribute("data-url");
        var text = sayeditbtn
          .closest(".comment-edit-content")
          .querySelector("textarea").value;
        sayeditbtn.closest("li").setAttribute("data-comment", text);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", url, true);
        xhr.addEventListener("readystatechange", function () {
          if (this.status === 200) {
            sinnertip(1, "修改成功");
            saycon.querySelector(".comment-content").innerHTML = this.response;
            sayed.style.display = "none";
            saycon.style.display = "";
            main.ajaxcommentfinish();
          }
        });
        var formData = new FormData();
        formData.append("text", text);
        xhr.send(formData);
      };
    });
};

main.deleteCookie = function (name) {
  document.cookie =
    name +
    "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; domain=" +
    globals.domain +
    "; path=/;";
};

main.all = function () {
  main.init();
  main.code();
  main.ajaxcomment();
  main.password();
  main.windows();
  Limg();
  window.ViewImage &&
    ViewImage.init(
      ".post-content img, .post-comment img, .post-comment a.view-image"
    );
  linkCard(".post-content", "0");
  setTimeout(function () {
    main.anchor();
  }, 50);
  main.back();
  main.say();
};
main.all();
