<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>𝓘𝓪𝓶𝓮𝓻 𝓜𝓮𝓻</title>
  <link rel="icon" href="./images/logo.png" type="image/png" />
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
      color: #fff;
      margin: 0;
      padding: 0;
    }

    header {
      background-color: #1a1a1a;
      text-align: center;
      padding: 20px;
      border-bottom: 2px solid #00ffcc;
    }

    header h1 {
      font-size: 2.5rem;
      color: #00ffcc;
    }

    nav {
      background-color: #111;
      padding: 15px;
      text-align: center;
    }

    nav a {
      color: #00ffcc;
      text-decoration: none;
      margin: 0 15px;
      font-weight: bold;
      transition: color 0.3s;
    }

    nav a:hover {
      color: #ffffff;
    }

    section {
      padding: 40px 20px;
      max-width: 1000px;
      margin: auto;
      text-align: center;
    }

    h2 {
      font-size: 2rem;
      color: #00ffcc;
      margin-bottom: 20px;
    }

    .game-grid {
      display: flex;
      justify-content: center;
      gap: 30px;
      flex-wrap: wrap;
      margin-top: 30px;
    }

    .game-grid a img {
      width: 320px;
      height: 200px;
      object-fit: cover;
      border-radius: 12px;
      transition: transform 0.3s ease;
      box-shadow: 0 6px 20px rgba(0, 255, 204, 0.4);
      background-color: #fff;
    }

    .game-grid a img:hover {
      transform: scale(1.05);
    }

    .highlight-slider {
      position: relative;
      width: 600px;
      max-width: 90%;
      margin: 30px auto;
      text-align: center;
    }

    .highlight-slide {
      display: none;
      width: 100%;
      height: 300px;
      object-fit: cover;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 255, 204, 0.3);
    }

    .highlight-slide.active {
      display: block;
    }

    .highlight-slider p {
      margin-top: 15px;
      font-size: 1.2rem;
      color: #ccc;
    }

    footer {
      font-size: 0.9rem;
      color: #999;
      text-align: center;
      margin-top: auto;
      padding: 15px 0;
      width: 100%;
      max-width: 1276px;
      user-select: none;
    }
  </style>
</head>
<body>

<header>
  <div style="display: flex; align-items: center; justify-content: center; gap: 20px; flex-wrap: wrap;">
    <img src="./../../img.png" alt="Gamers Rise Logo" style="height: 60px; width: auto;" />
    <div>
      <h1>𝓘𝓪𝓶𝓮𝓻 𝓜𝓮𝓻</h1>
      <p>Some Games Available.</p>
    </div>
  </div>
</header>

<nav>
  <a href="./index.php">Home</a>
  <a href="./about.php">About</a>
  <a href="./services.php">Services</a>
  <a href="./game download.php">Games Download</a>
</nav>

<section>
  <h2>Welcome to Gamer.com</h2>
  <p>We have some games available here to play. Click on the images below to play the games online now.</p>

  <div class="game-grid">
    <a href="https://www.miniclip.com/games/en/" target="_blank">
      <img src="./imgs/./miniclip.png" alt="Miniclip Games">
    </a>
    <a href="https://www.crazygames.com/" target="_blank">
      <img src="./imgs/./crazy games.jpeg" alt="Crazy Games">
    </a>
    <a href="https://www.kongregate.com/" target="_blank">
      <img src="./imgs/./kongerate.png" alt="Kongregate Games">
    </a>
  </div>
</section>

<section>
  <h2>🎯 Game Highlight</h2>
  <div class="highlight-slider">
    <a href="https://www.pubg.com/" target="_blank">
      <img class="highlight-slide active" src="./imgs/./pubg.png" alt="PUBG">
    </a>
    <a href="https://www.epicgames.com/fortnite/en-US/home" target="_blank">
      <img class="highlight-slide" src="./imgs/./fortnite.png" alt="Fortnite">
    </a>
    <a href="https://ff.garena.com/" target="_blank">
      <img class="highlight-slide" src="./imgs/./freefire.png" alt="Free Fire">
    </a>
    <a href="https://www.callofduty.com/warzone" target="_blank">
      <img class="highlight-slide" src="./images/CoD WARZONE.png" alt="COD Warzone">
    </a>
    <a href="https://www.callofduty.com/" target="_blank">
      <img class="highlight-slide" src="./images/CoD.jpeg" alt="Call of Duty">
    </a>
    <a href="https://store.steampowered.com/app/730/CounterStrike_Global_Offensive/" target="_blank">
      <img class="highlight-slide" src="./images/counter strike.png" alt="Counter Strike">
    </a>
    <a href="https://www.ea.com/games/apex-legends" target="_blank">
      <img class="highlight-slide" src="./images/apex legends.png" alt="Apex Legends">
    </a>
    <a href="https://www.innersloth.com/games/among-us/" target="_blank">
      <img class="highlight-slide" src="./images/among us.png" alt="Among Us">
    </a>
    <a href="https://playhearthstone.com/" target="_blank">
      <img class="highlight-slide" src="./images/hearth stones.jpeg" alt="Hearthstone">
    </a>
    <a href="https://www.minecraft.net/" target="_blank">
      <img class="highlight-slide" src="./images/minecraft.jpeg" alt="Minecraft">
    </a>
    <a href="https://www.leagueoflegends.com/" target="_blank">
      <img class="highlight-slide" src="./images/leauge of legends.jpeg" alt="League of Legends">
    </a>
    <p>Popular Game of the Month!</p>
  </div>
</section>

<footer>
  &copy; 2025 Gamers Rise. All rights reserved.
</footer>

<script>
  let highlightSlideIndex = 0;
  const highlightSlides = document.querySelectorAll('.highlight-slide');

  function showHighlightSlide(index) {
    highlightSlides.forEach((slide, i) => {
      slide.classList.toggle('active', i === index);
    });
  }

  function nextHighlightSlide() {
    highlightSlideIndex = (highlightSlideIndex + 1) % highlightSlides.length;
    showHighlightSlide(highlightSlideIndex);
  }

  setInterval(nextHighlightSlide, 2500);
  showHighlightSlide(highlightSlideIndex);
</script>

</body>
</html>