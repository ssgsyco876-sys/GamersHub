<!DOCTYPE html>
<html>
<head>
  <title>Offline Game Injector</title>
  <style>
    body { font-family: Arial; background: #111; color: #fff; text-align: center; }
    .box { margin: 100px auto; width: 300px; background: #222; padding: 20px; border-radius: 10px; }
    input, button { width: 90%; padding: 10px; margin: 5px 0; border-radius: 5px; }
    button { background: green; color: white; cursor: pointer; }
  </style>
</head>
<body>
  <div class="box">
    <h2>Game Injector</h2>
    <input type="text" id="player" placeholder="Player Name / ID"><br>
    <input type="number" id="amount" placeholder="Amount"><br>
    <button onclick="inject()">Inject</button>
    <p id="result"></p>
  </div>

  <script>
    function inject() {
      let player = document.getElementById("player").value;
      let amount = document.getElementById("amount").value;

      fetch("backend.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "player=" + player + "&amount=" + amount
      })
      .then(res => res.json())
      .then(data => {
        document.getElementById("result").innerText = data.message;
      });
    }
  </script>
</body>
</html>
