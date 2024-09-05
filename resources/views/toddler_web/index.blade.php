<!DOCTYPE html>
<html lang="en-us">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Little Scientists Toddler</title>
    <link rel="shortcut icon" href="/TemplateData/favicon.ico">
    <link rel="stylesheet" href="/TemplateData/style.css">
  </head>
  <body>
    <div id="unity-container" class="unity-desktop">
      <canvas id="unity-canvas" width="960" height="540" tabindex="-1"></canvas>
      <div id="unity-loading-bar">
        <div id="unity-logo"></div>
        <div id="unity-progress-bar-empty">
          <div id="unity-progress-bar-full"></div>
        </div>
      </div>
      <div id="unity-warning"> </div>
      <div id="unity-footer">
        <!--<div id="unity-webgl-logo"></div>-->
        <div id="unity-fullscreen-button"></div>
        <!--<div id="unity-build-title">Little Scientists Toddler</div>-->
      </div>
    </div>
    <script>

      var container = document.querySelector("#unity-container");
      var canvas = document.querySelector("#unity-canvas");
      var loadingBar = document.querySelector("#unity-loading-bar");
      var progressBarFull = document.querySelector("#unity-progress-bar-full");
      var fullscreenButton = document.querySelector("#unity-fullscreen-button");
      var warningBanner = document.querySelector("#unity-warning");

      function unityShowBanner(msg, type) {
        function updateBannerVisibility() {
          warningBanner.style.display = warningBanner.children.length ? 'block' : 'none';
        }
        var div = document.createElement('div');
        div.innerHTML = msg;
        warningBanner.appendChild(div);
        if (type == 'error') div.style = 'background: red; padding: 10px;';
        else {
          if (type == 'warning') div.style = 'background: yellow; padding: 10px;';
          setTimeout(function() {
            warningBanner.removeChild(div);
            updateBannerVisibility();
          }, 5000);
        }
        updateBannerVisibility();
      }

      var buildUrl = "/ToddlerBuild";
      var loaderUrl = buildUrl + "/9edd899bc6b6e0bbc4f46ff33ca0bba6.loader.js";
      var config = {
        dataUrl: buildUrl + "/d0ad18cb9a8ca211954b7a13708ebf91.data.br",
        frameworkUrl: buildUrl + "/9cb3713b2c176cfae7d4094ad76b3b9c.framework.js.br",
        codeUrl: buildUrl + "/8d1c68c3dfda1722fe4846a022f1b731.wasm.br",
        streamingAssetsUrl: "StreamingAssets",
        companyName: "Alfa and Friends Sdn Bhd",
        productName: "Little Scientists Toddler",
        productVersion: "2.0.0",
        showBanner: unityShowBanner,
      };

      if (/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) {
        var meta = document.createElement('meta');
        meta.name = 'viewport';
        meta.content = 'width=device-width, height=device-height, initial-scale=1.0, user-scalable=no, shrink-to-fit=yes';
        document.getElementsByTagName('head')[0].appendChild(meta);
        container.className = "unity-mobile";
        canvas.className = "unity-mobile";
      } else {
        canvas.style.width = "960px";
        canvas.style.height = "540px";
      }

      loadingBar.style.display = "block";

      var script = document.createElement("script");
      script.src = loaderUrl;
      script.onload = () => {
        createUnityInstance(canvas, config, (progress) => {
          progressBarFull.style.width = 100 * progress + "%";
        }).then((unityInstance) => {
          loadingBar.style.display = "none";

          // Automatically enter fullscreen when the Unity instance is ready
          unityInstance.SetFullscreen(1);

          fullscreenButton.onclick = () => {
            unityInstance.SetFullscreen(1);
          };
        }).catch((message) => {
          alert(message);
        });
      };

      document.body.appendChild(script);

    </script>
  </body>
</html>
