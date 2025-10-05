<?php
header("Content-Type: application/json");

// 👉 Apna Windows username dalna zaroori hai
$USERNAME = "Your_Windows_Username";
$SAVE_PATH = "C:/Users/$USERNAME/AppData/Local/StickWarLegacy/save.json";

function inject_stickwar($SAVE_PATH) {
    if (!file_exists($SAVE_PATH)) {
        return ["status" => "error", "message" => "❌ Save file nahi mili! Pehle game open karke ek new save banao."];
    }

    $content = file_get_contents($SAVE_PATH);
    $data = json_decode($content, true);

    if ($data === null) {
        return ["status" => "error", "message" => "❌ Save file corrupt ya encoded hai!"];
    }

    // Values inject karo
    $data["coins"] = 999999;
    $data["gems"] = 99999;
    $data["upgrade_level"] = 100;
    $data["skin_unlocks"] = true;

    file_put_contents($SAVE_PATH, json_encode($data, JSON_PRETTY_PRINT));

    return ["status" => "success", "message" => "✅ Injection complete! Stick War Legacy khol aur sab unlocked milega."];
}

function inject($player_id, $diamonds) {
    return [
        "status" => "success",
        "message" => "$diamonds diamonds injected to Player ID $player_id ✅"
    ];
}

// 🟢 Agar CLI se run ho
if (php_sapi_name() === "cli") {
    global $argv;
    if (count($argv) < 3) {
        echo json_encode(["status" => "error", "message" => "Missing arguments"]);
    } else {
        $player_id = $argv[1];
        $diamonds = $argv[2];
        echo json_encode(inject($player_id, $diamonds));
    }
    exit;
}

// 🟢 Agar POST request frontend se aayi ho
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = json_decode(file_get_contents("php://input"), true);

    if (!$input || !isset($input["player"]) || !isset($input["diamonds"])) {
        echo json_encode(["status" => "error", "message" => "Missing arguments"]);
        exit;
    }

    $player = htmlspecialchars($input["player"]);
    $diamonds = intval($input["diamonds"]);

    if ($diamonds <= 0) {
        echo json_encode(["status" => "error", "message" => "Invalid diamonds amount"]);
        exit;
    }

    echo json_encode(inject($player, $diamonds));
    exit;
}

// Agar GET ya aur kuch ho
echo json_encode(["status" => "error", "message" => "Invalid request"]);
?>
